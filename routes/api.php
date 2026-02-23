<?php

use App\Http\Controllers\{
    AdministratorController,
    AnthropometryController,
    AuthenticateController,
    DietController,
    DietFeedbackController,
    DietFeedbackNotificationController,
    DietItemController,
    DietNotificationController,
    EducatorController,
    ExerciseController,
    FoodController,
    MealController,
    MuscleGroupController,
    PatientController,
    PatientRegistrationController,
    PatientWeightController,
    ProgressChartController,
    WorkoutController,
    WorkoutFeedbackController,
    WorkoutFeedbackNotificationController,
    WorkoutItemController,
    WorkoutNotificationController,
    WorkoutTypeController,
};
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::post('/login', [AuthenticateController::class, 'login']);
Route::post('/loginPatient', [AuthenticateController::class, 'loginPatient']);
Route::post('/loginAdministrator', [AuthenticateController::class, 'loginAdministrator']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'logout']);

    Route::apiResource('diets', DietController::class);
    Route::apiResource('administrators', AdministratorController::class);
    Route::apiResource('anthropometrys', AnthropometryController::class);
    Route::apiResource('diet-feedbacks', DietFeedbackController::class);
    Route::apiResource('diet-feedback-notifications', DietFeedbackNotificationController::class);
    Route::apiResource('diet-items', DietItemController::class);
    Route::apiResource('diet-notifications', DietNotificationController::class);
    Route::apiResource('educators', EducatorController::class);
    Route::get('/educator/notifications/diet-feedback', [DietFeedbackController::class, 'newForEducator']);
    Route::get('/educator/notifications/workout-feedback', [WorkoutFeedbackController::class, 'newForEducator']);
    Route::apiResource('exercises', ExerciseController::class);
    Route::apiResource('foods', FoodController::class);
    Route::apiResource('meals', MealController::class);
    Route::apiResource('muscle-groups', MuscleGroupController::class);
    Route::apiResource('patients', PatientController::class);
    Route::get('/patient/notifications/diet-items', [DietItemController::class, 'notifiedForPatient']);
    Route::get('/patient/notifications/workout-items', [WorkoutItemController::class, 'notifiedForPatient']);
    Route::apiResource('patient-registrations', PatientRegistrationController::class);
    Route::apiResource('patient-weights', PatientWeightController::class);
    Route::apiResource('progress-charts', ProgressChartController::class);
    Route::apiResource('workouts', WorkoutController::class);
    Route::apiResource('workout-feedbacks', WorkoutFeedbackController::class);
    Route::apiResource('workout-feedback-notifications', WorkoutFeedbackNotificationController::class);
    Route::apiResource('workout-items', WorkoutItemController::class);
    Route::apiResource('workout-notifications', WorkoutNotificationController::class);
    Route::apiResource('workout-type', WorkoutTypeController::class);
});
