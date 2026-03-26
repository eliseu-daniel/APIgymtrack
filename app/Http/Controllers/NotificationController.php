<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, ?string $id = null)
    {
        $idEducator = $request->user()->id;

        if ($id === 'all' || $request->input('all') === true) {
            Notification::where('educator_id', $idEducator)
                ->where('read', false)
                ->update(['read' => true]);

            return response()->json(['status' => true, 'message' => 'Todas as notificações foram marcadas como lidas']);
        }

        if ($request->has('ids') && is_array($request->input('ids'))) {
            Notification::where('educator_id', $idEducator)
                ->whereIn('id', $request->input('ids'))
                ->update(['read' => true]);

            return response()->json(['status' => true, 'message' => 'Notificações marcadas como lidas']);
        }

        $singleId = $id ?? $request->input('id');

        if ($singleId) {
            $notification = Notification::find($singleId);

            if (!$notification) {
                return response()->json(['status' => false, 'message' => 'Notificação não encontrada'], 404);
            }

            if ($notification->educator_id !== $idEducator) {
                return response()->json(['status' => false, 'message' => 'Não autorizado'], 403);
            }

            $notification->update(['read' => true]);

            return response()->json(['status' => true, 'message' => 'Notificação marcada como lida']);
        }

        return response()->json(['status' => false, 'message' => 'Nenhum ID fornecido'], 400);
    }

    public function markAsReadPatient(Request $request, ?string $id = null)
    {
        $idPatient = $request->user()->id;

        // Se passar "all" na URL ou no corpo ("all": true)
        if ($id === 'all' || $request->input('all') === true) {
            Notification::where('patient_id', $idPatient)
                ->where('read', false)
                ->update(['read' => true]);

            return response()->json(['status' => true, 'message' => 'Todas as notificações foram marcadas como lidas']);
        }

        // Se passar um Array de IDs no corpo ("ids": [1, 2, 3])
        if ($request->has('ids') && is_array($request->input('ids'))) {
            Notification::where('patient_id', $idPatient)
                ->whereIn('id', $request->input('ids'))
                ->update(['read' => true]);

            return response()->json(['status' => true, 'message' => 'Notificações marcadas como lidas']);
        }

        // Se omitiu o ID na URL mas enviou no body ("id": 1) ou pegou da URL normal
        $singleId = $id ?? $request->input('id');

        if ($singleId) {
            $notification = Notification::find($singleId);

            if (!$notification) {
                return response()->json(['status' => false, 'message' => 'Notificação não encontrada'], 404);
            }

            if ($notification->patient_id !== $idPatient) {
                return response()->json(['status' => false, 'message' => 'Não autorizado'], 403);
            }

            $notification->update(['read' => true]);

            return response()->json(['status' => true, 'message' => 'Notificação marcada como lida']);
        }

        return response()->json(['status' => false, 'message' => 'Nenhum ID fornecido'], 400);
    }
}
