<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class DateServices
{
    public static function generatePlan(string $startDate, string $planDescription)
    {
        $date = Carbon::createFromFormat('Y-m-d', $startDate);

        if ($planDescription === 'monthly') {
            $nextDate = $date->copy()->addDays(30);
        } elseif ($planDescription === 'quarterly') {
            $nextDate = $date->copy()->addDays(90);
        } elseif ($planDescription === 'semiannual') {
            $nextDate = $date->copy()->addDays(180);
        } else {
            throw new InvalidArgumentException('Plano inválido. Use "monthly", "quarterly" ou "semiannual".');
        }

        return $date = $nextDate->format('Y-m-d');
    }

    public function toDatabaseFormat(string $date): string
    {
        try {
            $parsedDate = Carbon::createFromFormat('d/m/Y', $date);
            return $parsedDate->format('Y-m-d');
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Data inválida. Use o formato DD/MM/YYYY (ex.: 21/10/2025).');
        }
    }

    public static function toBrazilianFormat(string $date): string
    {
        try {
            $parsedDate = Carbon::createFromFormat('Y-m-d', $date);
            return $parsedDate->format('d/m/Y');
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Data inválida. Use o formato Y-m-d (ex.: 2025-10-21).');
        }
    }
}
