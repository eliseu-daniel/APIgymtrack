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

        $notifications = \App\Models\Notification::query()
            ->where('educator_id', $educatorId)
            ->where('type', 'diet_feedback')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notifications, 200);
    }
}
