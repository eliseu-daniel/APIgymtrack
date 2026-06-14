<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutFeedbackRequest;
use App\Services\FeedbackService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WorkoutFeedbackController extends Controller
{
    public function __construct(
        private FeedbackService $feedbackService,
        private NotificationService $notificationService
    ) {}

    public function index()
    {
        $idEducator = request()->user()->id;

        return response()->json([
            'status' => true,
            'DataFeedback' => $this->feedbackService->getWorkoutFeedbacks($idEducator)
        ], 200);
    }

    public function store(CreateWorkoutFeedbackRequest $request): JsonResponse
    {
        $workoutFeedback = $this->feedbackService->createWorkoutFeedback($request->validated());

        if ($workoutFeedback && $workoutFeedback->send_notification) {
            $this->feedbackService->dispatchWorkoutFeedbackNotification($workoutFeedback);
        }

        return response()->json([
            'status' => true,
            'message' => 'Feedback do treino criado com sucesso',
            'DataFeedback' => $workoutFeedback
        ], 201);
    }

    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $workoutFeedback = $this->feedbackService->getWorkoutFeedback($idEducator, (int) $id);

        if (!$workoutFeedback) {
            return response()->json(['status' => false, 'message' => 'Feeback não encontrado'], 404);
        }
        return response()->json(['status' => true, 'message' => $workoutFeedback], 200);
    }

    public function newForEducator(Request $request): JsonResponse
    {
        $idEducator = $request->user()->id;
        $after = $request->query('after');

        $data = $this->notificationService->getEducatorNotifications($idEducator, $after);

        if ($data->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de feedback de treino encontrada.'], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
}
