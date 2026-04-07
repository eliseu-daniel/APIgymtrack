<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietFeedbackRequest;
use App\Jobs\NotifyEducatorNewDietFeedbackJob;
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

        $data = DietFeedback::with('diet.patient')
            ->whereHas('diet.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($feedback) {
                $feedbackArray = $feedback->toArray();
                $feedbackArray['diet_feedback_id'] = $feedback->id;
                $feedbackArray['patient_name'] = $feedback->diet->patient['name'] ?? null;
                $feedbackArray['diet_id'] = $feedback->diet_id;
                unset($feedbackArray['diet']);
                return $feedbackArray;
            });

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
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
        $validator = $request->validated();
        $idEducator = request()->user()->id;

        $feedback = DietFeedback::create([
            'diet_id' => $validator['diet_id'],
            'comment' => $validator['comment'],
            'send_notification' => $validator['send_notification'] ?? 1,
        ]);

        if ($feedback->send_notification == true) {
            $dietWithPatient = \App\Models\Diet::with('patient.registrations')->find($feedback->diet_id);

            if ($dietWithPatient && $dietWithPatient->patient) {
                $registration = $dietWithPatient->patient->registrations->first();
                
                if ($registration && $registration->educator_id) {
                    NotifyEducatorNewDietFeedbackJob::dispatch(
                        (int) $dietWithPatient->patient_id,
                        (string) $dietWithPatient->patient->name,
                        (string) $feedback->comment,
                        (int) $registration->educator_id
                    );
                }
            }
        }


        return response()->json([
            'status' => true,
            'message' => 'Feedback de dieta criado com sucesso',
            'data' => $feedback
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $feedback = DietFeedback::with('diet.patient')
            ->whereHas('diet.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('id', $id)
            ->first();

        if (!$idEducator) {
            return response()->json(['status' => false, 'message' => 'Antropometria não encontrada'], 404);
        }
        if (!$feedback) {
            return response()->json(['status' => false, 'message' => 'Feedback de dieta não encontrado'], 404);
        }

        $feedbackArray = $feedback->toArray();
        $feedbackArray['patient_name'] = $feedback->diet->patient['name'] ?? null;
        unset($feedbackArray['diet']);

        return response()->json(['status' => true, 'data' => $feedbackArray]);
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
