<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class WorkoutFeedbackSubmitted
{
    use Dispatchable;

    public function __construct(
        public int $patientId,
        public string $patientName,
        public string $comment,
        public int $educatorId
    ) {}
}
