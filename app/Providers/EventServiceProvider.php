<?php

namespace App\Providers;

use App\Events\DietFeedbackSubmitted;
use App\Events\DietItemConfirmed;
use App\Events\WorkoutFeedbackSubmitted;
use App\Events\WorkoutItemConfirmed;
use App\Listeners\SendDietFeedbackNotification;
use App\Listeners\SendDietItemNotification;
use App\Listeners\SendWorkoutFeedbackNotification;
use App\Listeners\SendWorkoutItemNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DietItemConfirmed::class => [
            SendDietItemNotification::class,
        ],
        WorkoutItemConfirmed::class => [
            SendWorkoutItemNotification::class,
        ],
        DietFeedbackSubmitted::class => [
            SendDietFeedbackNotification::class,
        ],
        WorkoutFeedbackSubmitted::class => [
            SendWorkoutFeedbackNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
