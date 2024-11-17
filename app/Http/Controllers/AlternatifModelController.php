<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use App\Models\AlternatifSkor;
use App\Models\CriteriaModel;
use Illuminate\Http\Request;

class AlternatifModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data skor, alternatif, dan kriteria
        $scores = AlternatifSkor::select(
            'alternatif_skors.alternatif_id as id',
            'alternatif_models.id as ida',
            'alternatif_skors.score as score',
            'criteria_models.id as idc',
            'criteria_models.code as name',
            'criteria_models.type as type',
            'criteria_models.weight as weight',
            'criteria_models.description as description'
        )
        ->leftJoin('alternatif_models', 'alternatif_models.id', '=', 'alternatif_skors.alternatif_id')
        ->leftJoin('criteria_models', 'criteria_models.id', '=', 'alternatif_skors.criteria_id')
        ->get();

        // Ambil data alternatif dan kriteria
        $alternatif = AlternatifModel::get();
        $criterion = CriteriaModel::get();

        // Normalisasi skor
        $normalizedScores = $this->normalizeScores($scores, $criterion);

        // Menghitung solusi ideal positif dan negatif
        $idealSolutions = $this->calculateIdealSolutions($normalizedScores, $criterion);

        // Kembalikan data ke view
        return view('alternatif.index', compact('scores', 'alternatif', 'criterion', 'normalizedScores', 'idealSolutions'))->with('i', 0);
    }

    /**
     * Fungsi untuk normalisasi skor
     */
    public function normalizeScores($scores, $criteria)
    {
        $normalizedScores = [];

        foreach ($criteria as $criterion) {
            $maxValue = $this->getMaxValueForCriterion($scores, $criterion);
            $minValue = $this->getMinValueForCriterion($scores, $criterion);

            // Check if maxValue or minValue is zero to avoid division by zero
            if ($maxValue == 0) {
                $maxValue = 1; // Set to 1 to prevent division by zero
            }
            if ($minValue == 0) {
                $minValue = 1; // Set to 1 to prevent division by zero
            }

            // Normalisasi untuk setiap alternatif
            foreach ($scores as $score) {
                if ($criterion->type == 'benefit') {
                    // Avoid division by zero by ensuring maxValue is not zero
                    $normalizedValue = $score->score / $maxValue;
                } else { // cost
                    // Avoid division by zero by ensuring minValue is not zero
                    $normalizedValue = $minValue / $score->score;
                }

                // Menyimpan hasil normalisasi
                $normalizedScores[$score->alternatif_id][$criterion->id] = $normalizedValue;
            }
        }

        return $normalizedScores;
    }

    /**
     * Fungsi untuk mendapatkan nilai maksimum untuk kriteria tertentu
     */
    public function getMaxValueForCriterion($scores, $criterion)
    {
        $maxValue = null;
        foreach ($scores as $score) {
            if ($score->criteria_id == $criterion->id) {
                if ($maxValue === null || $score->score > $maxValue) {
                    $maxValue = $score->score;
                }
            }
        }
        return $maxValue;
    }

    /**
     * Fungsi untuk mendapatkan nilai minimum untuk kriteria tertentu
     */
    public function getMinValueForCriterion($scores, $criterion)
    {
        $minValue = null;
        foreach ($scores as $score) {
            if ($score->criteria_id == $criterion->id) {
                if ($minValue === null || $score->score < $minValue) {
                    $minValue = $score->score;
                }
            }
        }
        return $minValue;
    }

    /**
     * Fungsi untuk menghitung solusi ideal (A+ dan A-)
     */
    public function calculateIdealSolutions($normalizedScores, $criteria)
    {
        $A_plus = [];
        $A_minus = [];

        foreach ($criteria as $criterion) {
            $columnValues = [];

            foreach ($normalizedScores as $alternatifId => $scores) {
                // Check if the score exists for the current criterion
                if (isset($scores[$criterion->id])) {
                    $columnValues[] = $scores[$criterion->id];
                }
            }

            // Ensure columnValues is not empty before calling max() or min()
            if (count($columnValues) > 0) {
                if ($criterion->type == 'benefit') {
                    $A_plus[$criterion->id] = max($columnValues);
                    $A_minus[$criterion->id] = min($columnValues);
                } else { // cost
                    $A_plus[$criterion->id] = min($columnValues);
                    $A_minus[$criterion->id] = max($columnValues);
                }
            } else {
                // Handle the case where no values are found for the criterion
                $A_plus[$criterion->id] = 0;
                $A_minus[$criterion->id] = 0;
            }
        }

        return ['A_plus' => $A_plus, 'A_minus' => $A_minus];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterion = CriteriaModel::get();
        return view('alternatif.create', compact('criterion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'score' => 'required|array',
            'score.*' => 'required|numeric',
        ]);

        // Simpan alternatif
        $alt = new AlternatifModel;
        $alt->name = $request->name;
        $alt->save();

        // Simpan skor
        $criterion = CriteriaModel::get();
        foreach ($criterion as $c) {
            $score = new AlternatifSkor();
            $score->alternatif_id = $alt->id;
            $score->criteria_id = $c->id;
            $score->score = $request->score[$c->id] ?? 0;
            $score->save();
        }

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlternatifModel $alternatif)
    {
        $criterion = CriteriaModel::get();
        $alternatifskor = AlternatifSkor::where('alternatif_id', $alternatif->id)->get();
        return view('alternatif.edit', compact('alternatif', 'alternatifskor', 'criterion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlternatifModel $alternatif)
    {
        $request->validate([
            'name' => 'required',
            'score' => 'required|array',
            'score.*' => 'required|numeric',
        ]);

        // Update skor
        $criterion = CriteriaModel::get();
        foreach ($criterion as $c) {
            $score = AlternatifSkor::updateOrCreate(
                [
                    'alternatif_id' => $alternatif->id,
                    'criteria_id' => $c->id,
                ],
                [
                    'score' => $request->score[$c->id] ?? 0,
                ]
            );
        }

        // Update alternatif
        $alternatif->update([
            'name' => $request->name,
        ]);

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlternatifModel $alternatif)
    {
        $score = AlternatifSkor::where('alternatif_id', $alternatif->id)->delete();
        $alternatif->delete();

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif deleted successfully');
    }
}
