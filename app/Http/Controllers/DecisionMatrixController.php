<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlternatifModel;
use App\Models\CriteriaModel;
use App\Models\AlternatifSkor;

class DecisionMatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data alternatif dan kriteria
        $alternatif = AlternatifModel::all();
        $criterion = CriteriaModel::all();
        $scores = AlternatifSkor::with(['alternatif', 'criteria'])->get();

        // Matriks keputusan: Alternatif x Kriteria
        $decisionMatrix = [];
        foreach ($alternatif as $alt) {
            foreach ($criterion as $crit) {
                // Cek apakah skor untuk alternatif dan kriteria tersebut ada
                $scoreRecord = $scores->where('alternatif_id', $alt->id)
                                      ->where('criteria_id', $crit->id)
                                      ->first();

                // Pastikan record skor ditemukan, jika tidak, set ke 0 atau nilai default lainnya
                $score = $scoreRecord ? $scoreRecord->score : 0;
                $decisionMatrix[$alt->id][$crit->id] = $score;
            }
        }

        // Normalisasi matriks keputusan
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix, $criterion);

        // Hitung nilai VIKOR (Q) untuk setiap alternatif
        $vikorScores = $this->calculateVikorScores($normalizedMatrix, $criterion);

        // Urutkan alternatif berdasarkan nilai Q
        usort($vikorScores, function($a, $b) {
            return $a['Q'] <=> $b['Q'];
        });

        // Kirim data ke view
        return view('decisionmatrix.index', compact('alternatif', 'criterion', 'scores', 'vikorScores'));
    }

    /**
     * Normalisasi matriks keputusan.
     */
    private function normalizeMatrix($decisionMatrix, $criterion)
    {
        $normalizedMatrix = [];

        // Normalisasi berdasarkan kriteria (jika benefit atau cost)
        foreach ($criterion as $crit) {
            $maxValue = max(array_column($decisionMatrix, $crit->id));
            $minValue = min(array_column($decisionMatrix, $crit->id));

            // Pastikan tidak terjadi pembagian dengan nol
            if ($maxValue == 0) $maxValue = 1;  // Set nilai default jika maxValue = 0
            if ($minValue == 0) $minValue = 1;  // Set nilai default jika minValue = 0

            foreach ($decisionMatrix as $altId => $scores) {
                foreach ($scores as $critId => $score) {
                    if ($crit->type === 'benefit') {
                        // Normalisasi untuk kriteria Benefit (nilai lebih tinggi lebih baik)
                        // Cek jika maxValue adalah 0, untuk mencegah pembagian dengan nol
                        $normalizedMatrix[$altId][$critId] = $score / $maxValue;
                    } elseif ($crit->type === 'cost') {
                        // Normalisasi untuk kriteria Cost (nilai lebih rendah lebih baik)
                        // Cek jika minValue adalah 0, untuk mencegah pembagian dengan nol
                        if ($score != 0) {
                            $normalizedMatrix[$altId][$critId] = $minValue / $score;
                        } else {
                            $normalizedMatrix[$altId][$critId] = 0;  // Menghindari pembagian dengan nol
                        }
                    }
                }
            }
        }

        return $normalizedMatrix;
    }

    /**
     * Menghitung skor VIKOR (Q).
     */
    private function calculateVikorScores($normalizedMatrix, $criterion)
    {
        $vikorScores = [];
        
        foreach ($normalizedMatrix as $altId => $scores) {
            $S = 0;
            $R = 0;
            $V = 0;
            
            foreach ($scores as $critId => $score) {
                // Ambil bobot kriteria berdasarkan ID kriteria
                $weight = $criterion->where('id', $critId)->first()->weight;
                $S += $score * $weight;
                $R += abs($score - max($scores)) * $weight;  // Difference from ideal solution
            }

            // Menghitung nilai Q
            $Q = $S + $R;

            // Simpan hasil perhitungan Q untuk setiap alternatif
            $vikorScores[] = [
                'alternatif_id' => $altId,
                'Q' => $Q
            ];
        }

        return $vikorScores;
    }
}
