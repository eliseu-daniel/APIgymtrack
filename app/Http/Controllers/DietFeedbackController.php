<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietFeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class DietFeedbackController extends Controller
{
    public function __construct(
        private FeedbackService $feedbackService
    ) {}

    public function index()
    {
        $idEducator = request()->user()->id;

        return response()->json([
            'status' => true,
            'data' => $this->feedbackService->getDietFeedbacks($idEducator)
        ], 200);
    }

    public function store(CreateDietFeedbackRequest $request)
    {
        $validator = $request->validated();

        $feedback = $this->feedbackService->createDietFeedback($validator);

        if ($feedback->send_notification) {
            $this->feedbackService->dispatchDietFeedbackNotification($feedback, request()->user()->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Feedback de dieta criado com sucesso',
            'data' => $feedback
        ], 201);
    }

    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $data = $this->feedbackService->getDietFeedback($idEducator, (int) $id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Feedback de dieta não encontrado'], 404);
        }
        return response()->json(['status' => true, 'data' => $data]);
    }
}
