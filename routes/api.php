<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AnthropometryController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\DietFeedbackController;
use App\Http\Controllers\DietFeedbackNotificationController;
use App\Http\Controllers\DietItemController;
use App\Http\Controllers\DietNotificationController;
use App\Http\Controllers\EducatorController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MuscleGroupController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientRegistrationController;
use App\Http\Controllers\PatientWeightController;
use App\Http\Controllers\ProgressChartController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutFeedbackNotificationController;
use App\Http\Controllers\WorkoutItemController;
use App\Http\Controllers\WorkoutNotificationController;
use App\Http\Controllers\WorkoutTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/api/register', [AuthenticateController::class, 'register']);
Route::post('/api/login', [AuthenticateController::class, 'login']);

Route::prefix('api')->middleware('auth:sanctum')->group(function (){
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    
    Route::apiResource('diets', DietController::class);
    Route::apiResource('administrators', AdministratorController::class);
    Route::apiResource('anthropometrys', AnthropometryController::class);
    Route::apiResource('diet-feedbacks', DietFeedbackController::class);
    Route::apiResource('diet-feedback-notifications', DietFeedbackNotificationController::class);
    Route::apiResource('diet-items', DietItemController::class);
    Route::apiResource('diet-notifications', DietNotificationController::class);
    Route::apiResource('educators', EducatorController::class);
    Route::apiResource('exercises', ExerciseController::class);
    Route::apiResource('foods', FoodController::class);
    Route::apiResource('meals', MealController::class);
    Route::apiResource('muscle-groups', MuscleGroupController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('patient-registrations', PatientRegistrationController::class);
    Route::apiResource('patient-weights',PatientWeightController::class);
    Route::apiResource('progress-charts', ProgressChartController::class);
    Route::apiResource('workouts', WorkoutController::class);
    Route::apiResource('workout-feedbacks', WorkoutController::class);
    Route::apiResource('workout-feedback-notifications', WorkoutFeedbackNotificationController::class);
    Route::apiResource('workout-items', WorkoutItemController::class);
    Route::apiResource('workout-notifications', WorkoutNotificationController::class);
    Route::apiResource('workout-type', WorkoutTypeController::class);
});