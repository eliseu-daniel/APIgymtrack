<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function markAsRead(Request $request, ?string $id = null)
    {
        $idEducator = $request->user()->id;
        $all = $id === 'all' || $request->input('all') === true;
        $ids = $request->input('ids');
        $singleId = $id ?? $request->input('id');

        $result = $this->notificationService->markAsRead(
            $idEducator,
            $all ? null : $singleId,
            is_array($ids) ? $ids : null,
            $all
        );

        if (isset($result['error'])) {
            return response()->json([
                'status' => false,
                'message' => $result['error']
            ], $result['code']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Notificações marcadas como lidas'
        ]);
    }

    public function markAsReadPatient(Request $request, ?string $id = null)
    {
        $idPatient = $request->user()->id;
        $all = $id === 'all' || $request->input('all') === true;
        $ids = $request->input('ids');
        $singleId = $id ?? $request->input('id');

        $result = $this->notificationService->markAsReadPatient(
            $idPatient,
            $all ? null : $singleId,
            is_array($ids) ? $ids : null,
            $all
        );

        if (isset($result['error'])) {
            return response()->json([
                'status' => false,
                'message' => $result['error']
            ], $result['code']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Notificações marcadas como lidas'
        ]);
    }
}
