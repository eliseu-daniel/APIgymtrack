<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    public function getEducatorNotifications(int $educatorId, ?string $after = null): Collection
    {
        $query = Notification::query()
            ->where('educator_id', $educatorId)
            ->where('type', 'feedback')
            ->where('read', false)
            ->orderBy('created_at', 'desc');

        if ($after) {
            $query->where('created_at', '>', $after);
        }

        return $query->get();
    }

    public function getPatientNotifications(int $patientId, string $type): Collection
    {
        return Notification::query()
            ->where('patient_id', $patientId)
            ->where('type', $type)
            ->orderByDesc('created_at')
            ->where('read', false)
            ->get();
    }

    public function markAsRead(int $educatorId, ?string $id = null, ?array $ids = null, bool $all = false): array
    {
        if ($all) {
            $count = Notification::where('educator_id', $educatorId)
                ->where('read', false)
                ->update(['read' => true]);
            return ['updated' => $count];
        }

        if (!empty($ids)) {
            $count = Notification::where('educator_id', $educatorId)
                ->whereIn('id', $ids)
                ->update(['read' => true]);
            return ['updated' => $count];
        }

        if ($id) {
            $notification = Notification::find($id);
            if (!$notification) {
                return ['error' => 'Notificação não encontrada', 'code' => 404];
            }
            if ($notification->educator_id !== $educatorId) {
                return ['error' => 'Não autorizado', 'code' => 403];
            }
            $notification->update(['read' => true]);
            return ['updated' => 1];
        }

        return ['error' => 'Nenhum ID fornecido', 'code' => 400];
    }

    public function markAsReadPatient(int $patientId, ?string $id = null, ?array $ids = null, bool $all = false): array
    {
        if ($all) {
            $count = Notification::where('patient_id', $patientId)
                ->where('read', false)
                ->update(['read' => true]);
            return ['updated' => $count];
        }

        if (!empty($ids)) {
            $count = Notification::where('patient_id', $patientId)
                ->whereIn('id', $ids)
                ->update(['read' => true]);
            return ['updated' => $count];
        }

        if ($id) {
            $notification = Notification::find($id);
            if (!$notification) {
                return ['error' => 'Notificação não encontrada', 'code' => 404];
            }
            if ($notification->patient_id !== $patientId) {
                return ['error' => 'Não autorizado', 'code' => 403];
            }
            $notification->update(['read' => true]);
            return ['updated' => 1];
        }

        return ['error' => 'Nenhum ID fornecido', 'code' => 400];
    }
}
