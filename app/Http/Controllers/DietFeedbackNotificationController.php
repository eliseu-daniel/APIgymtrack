<?php

namespace App\Http\Controllers;

use App\Models\DietFeedback;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DietFeedbackNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function dietFeedback(Request $request): JsonResponse
    {
        $educatorId = $request->user()->id;

        $notifications = DietFeedback::query()
            ->select(
                'diet_feedback.id as diet_feedback_id',
                'diet_feedback.comment',
                'diet_feedback.send_notification',
                'diet_feedback.created_at',
                'patients.id as patient_id',
                'patients.name as patient_name'
            )
            ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('diet_feedback.send_notification', 1)
            ->orderByDesc('diet_feedback.created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'diet-' . $item->diet_feedback_id,
                    'type' => 'diet',
                    'title' => 'Novo feedback de dieta',
                    'message' => $item->patient_name . ' enviou um feedback de dieta.',
                    'comment' => $item->comment,
                    'created_at' => $item->created_at,
                    'read' => false,
                ];
            })
            ->values();

        return response()->json($notifications, 200);
    }
}
