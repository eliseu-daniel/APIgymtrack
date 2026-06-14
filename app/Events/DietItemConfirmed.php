<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class DietItemConfirmed
{
    use Dispatchable;

    public function __construct(
        public int $dietItemId,
        public int $patientId,
        public int $educatorId
    ) {}
}
