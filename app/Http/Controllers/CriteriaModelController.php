<?php

namespace App\Http\Controllers;

use App\Models\CriteriaModel;
use App\Models\AlternatifSkor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CriteriaModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criterion = CriteriaModel::get();

        // sum all weight
        $sumWeights = CriteriaModel::sum('weight');

        return view('criteria.index', compact('criterion'))->with('i', 0)->with('sumWeights', $sumWeights);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // sum all weight
        $sumWeights = CriteriaModel::sum('weight');
        return view('criteria.create')->with('sumWeights', $sumWeights);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|unique:criteria_models',
                'type' => 'required',
                'weight' => 'required',
                'description' => 'required',
            ]);

            // Make variable weight from request and sum all weight
            $weights = $request->weight;
            $weights = $weights + CriteriaModel::sum('weight');

            // Check if sum of weight is more than 10
            if ($weights > 10.0) {
                return redirect()->back()
                                 ->withInput()
                                 ->withErrors(['weight1' => 'Total weight cannot be more than 10.', 'weight2' => 'Please subtract weights from other criteria.']);
            }

            CriteriaModel::create($request->all());

            return redirect()->route('criteria.index')
                            ->with('success', 'Criteria created successfully');

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Error code 1062 is for duplicate entry
                return redirect()->back()
                                 ->withInput()
                                 ->withErrors(['name' => 'Criteria code already exists']);
            }
            // Handle other query exceptions if needed
            return redirect()->route('criteria.index')
                            ->with('error','Failed to create criteria.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CriteriaModel $criteriaModel)
    {
        // Retrieve alternatives and their scores associated with the specified criterion
        $scores = AlternatifSkor::where('criteria_id', $criteriaModel->id)
                                ->leftJoin('alternatif_models', 'alternatif_models.id', '=', 'alternatif_skors.alternatif_id')
                                ->select(
                                    'alternatif_models.name as alternatif_name',
                                    'alternatif_skors.score as score'
                                )
                                ->get();

        return view('criteria.show', compact('criteriaModel', 'scores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CriteriaModel $criterion)
    {
        // sum all weight
        $sumWeights = CriteriaModel::sum('weight');
        return view('criteria.edit', compact('criterion'))->with('sumWeights', $sumWeights);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CriteriaModel $criterion)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'weight' => 'required',
            'description' => 'required',
        ]);

        // Find weight from criterion
        $weightBefore = CriteriaModel::where('id', $criterion->id)->first()->weight;

        // Make variable weight from request and sum all weight
        $weights = $request->weight;

        // Subtract weight from criterion
        $weights -= $weightBefore;

        // Sum all weight
        $weights = $weights + CriteriaModel::sum('weight');

        // Check if sum of weight is more than 10
        if ($weights > 10.0) {
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['weight1' => 'Total weight cannot be more than 10.', 'weight2' => 'Please subtract weights from other criteria.']);
        }

        $criterion->update($request->all());

        return redirect()->route('criteria.index')
                        ->with('success', 'Criteria updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        CriteriaModel::findOrFail($id)->delete();

        return redirect()->route('criteria.index')
                        ->with('success', 'Criteria deleted successfully');
    }
}
