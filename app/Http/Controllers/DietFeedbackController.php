<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietFeedbackRequest;
use App\Models\DietFeedback;
use Illuminate\Http\Request;

class DietFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;
        return response()->json(['status' => true, 'data' => DietFeedback::select('patients.name', 'diet_feedbacks.*')
            ->join('patients', 'patients.id', '=', 'diet_feedbacks.patient_id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDietFeedbackRequest $request)
    {
        $validator = $request->validate();

        $feedback = DietFeedback::create($validator);

        return response()->json(['status' => true, 'message' => 'Feedback de dieta criado com sucesso', 'data' => $feedback], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $idPatient)
    {
        $idEducator = request()->user()->id;
        return response()->json(['status' => true, 'data' => DietFeedback::select('patients.name', 'diet_feedbacks.*')
            ->join('patients', 'patients.id', '=', 'diet_feedbacks.patient_id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('diet_feedbacks.id', $id)
            ->where('patients.id', $idPatient)
            ->get()], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
