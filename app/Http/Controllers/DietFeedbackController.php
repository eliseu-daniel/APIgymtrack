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

        $data = DietFeedback::query()
            ->select([
                'diet_feedback.*',
                'diet_feedback.id as diet_feedback_id',
                'patients.name as patient_name',
                'diets.id as diet_id',
            ])
            ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->orderBy('diet_feedback.created_at', 'desc')
            ->get();

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

        if ($feedback && $feedback->send_notification) {
            $data = DietFeedback::query()
                ->select([
                    'diets.id as diet_id',
                    'patients.id as patient_id',
                    'patients.name as patient_name',
                ])
                ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
                ->join('patients', 'patients.id', '=', 'diets.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('diets.id', $feedback->diet_id)
                ->where('patient_registrations.educator_id', $idEducator)
                ->first();

            if ($data) {
                NotifyEducatorNewDietFeedbackJob::dispatch(
                    (int) $data->patient_id,
                    (string) $data->patient_name,
                    (string) $feedback->comment,
                    (int) $data->educator_id
                );
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
        $data = DietFeedback::query()
            ->select([
                'diet_feedback.*',
                'patients.name as patient_name',
            ])
            ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('diet_feedback.id', $id)
            ->first();
        if (!$idEducator) {
            return response()->json(['status' => false, 'message' => 'Antropometria não encontrada'], 404);
        }
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Feedback de dieta não encontrado'], 404);
        }
        return response()->json(['status' => true, 'data' => $data]);
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
