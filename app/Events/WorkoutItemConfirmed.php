<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class WorkoutItemConfirmed
{
    use Dispatchable;

    public function __construct(
        public int $workoutItemId,
        public int $patientId,
        public int $educatorId
    ) {}
}
