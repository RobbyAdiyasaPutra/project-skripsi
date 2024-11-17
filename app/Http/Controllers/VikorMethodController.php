<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use App\Models\CriteriaModel;
use App\Models\AlternatifSkor;
use Illuminate\Http\Request;

class VikorMethodController extends Controller
{
    public function index()
    {
        // Mengambil semua data alternatif, kriteria, dan skor alternatif
        $alternatif = AlternatifModel::all();
        $criterion = CriteriaModel::all();
        $scores = AlternatifSkor::with(['alternatif', 'criteria'])->get();

        // Mendapatkan bobot dari setiap kriteria
        $weights = $criterion->pluck('weight');
        $sumWeight = $weights->sum();

        // Cek jika jumlah bobot = 0 untuk mencegah pembagian dengan nol
        if ($sumWeight == 0) {
            return back()->withErrors('Total weight cannot be zero.');
        }

        // Normalisasi bobot berdasarkan total bobot
        foreach ($weights as $key => $weight) {
            $weights[$key] = number_format($weight / $sumWeight, 3);
        }

        $f_plus = [];
        $f_min = [];

        // Menghitung f_plus (nilai maksimum) dan f_min (nilai minimum) untuk setiap kriteria
        foreach ($criterion as $c) {
            $criteriaId = $c->id;
            $f_plus[$criteriaId] = $scores->where('criteria_id', $criteriaId)->pluck('score')->max();
            $f_min[$criteriaId] = $scores->where('criteria_id', $criteriaId)->pluck('score')->min();
        }

        // Normalisasi matriks nilai
        $normalizedMatrix = [];

        foreach ($scores as $sc) {
            $criteriaId = $sc->criteria_id;
            $alternatifId = $sc->alternatif_id;
            $score = $sc->score;

            if (!isset($normalizedMatrix[$alternatifId])) {
                $normalizedMatrix[$alternatifId] = [];
            }

            // Normalisasi nilai berdasarkan jenis kriteria (Benefit / Cost)
            $denominator = $f_plus[$criteriaId] - $f_min[$criteriaId];
            if ($denominator != 0) {
                if ($criterion->where('id', $criteriaId)->first()->type == 'benefit') {
                    $normalizedMatrix[$alternatifId][$criteriaId] = number_format(
                        ($f_plus[$criteriaId] - $score) / $denominator, 3
                    );
                } else {
                    $normalizedMatrix[$alternatifId][$criteriaId] = number_format(
                        ($f_min[$criteriaId] - $score) / $denominator, 3
                    );
                }
            } else {
                $normalizedMatrix[$alternatifId][$criteriaId] = 0; // Nilai default jika pembagian tidak valid
            }
        }

        // Matriks berbobot berdasarkan bobot kriteria
        $weightedMatrix = [];

        foreach ($normalizedMatrix as $alternatifId => $criteriaValue) {
            foreach ($criteriaValue as $criteriaId => $normalizedValue) {
                if (!isset($weightedMatrix[$alternatifId])) {
                    $weightedMatrix[$alternatifId] = [];
                }

                $weightedMatrix[$alternatifId][$criteriaId] = number_format($normalizedValue * $weights[$criteriaId - 1], 3);
            }
        }

        // Menghitung ukuran utilitas (S dan R)
        $s = [];
        $r = [];

        foreach ($weightedMatrix as $alternatifId => $criteriaValue) {
            $s[$alternatifId] = 0;
            $r[$alternatifId] = 0;
            foreach ($criteriaValue as $criteriaId => $weightedValue) {
                $s[$alternatifId] += $weightedValue;
                $r[$alternatifId] = max($r[$alternatifId], $weightedValue);
            }
        }

        // Menghitung indeks VIKOR (Q)
        $s_min = min($s);
        $s_max = max($s);
        $r_min = min($r);
        $r_max = max($r);
        $v = 0.5;  // Faktor kompromi (nilai antara 0 dan 1)

        $q = [];
        foreach ($s as $alternatifId => $s_value) {
            $r_value = $r[$alternatifId];

            $s_diff = $s_max - $s_min;
            $r_diff = $r_max - $r_min;

            $q[$alternatifId] = number_format(
                ($s_diff != 0 ? ($v * (($s_value - $s_min) / $s_diff)) : 0) +
                ($r_diff != 0 ? ((1 - $v) * (($r_value - $r_min) / $r_diff)) : 0),
                3
            );
        }

        // Menggabungkan nilai Q dan alternatif
        $result = array_combine($alternatif->pluck('name')->toArray(), $q);

        // Mengurutkan hasil berdasarkan nilai Q dari yang terendah hingga tertinggi
        asort($result);

        // Mengembalikan data ke tampilan (view)
        return view('calculate.index', compact(
            'alternatif',
            'criterion',
            'scores',
            'weights',
            'normalizedMatrix',
            'weightedMatrix',
            'alternatifId',
            's',
            'r',
            's_min',
            's_max',
            'r_min',
            'r_max',
            'v',
            'q',
            'result'
        ));
    }
}
