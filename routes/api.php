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

Route::middleware('auth:sanctum')->prefix('educators')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'logout']);

    Route::apiResource('diets', DietController::class);
    Route::apiResource('anthropometrys', AnthropometryController::class);
    Route::apiResource('diet-feedbacks', DietFeedbackController::class);
    Route::apiResource('diet-feedback-notifications', DietFeedbackNotificationController::class);
    Route::apiResource('diet-items', DietItemController::class);
    Route::apiResource('diet-notifications', DietNotificationController::class);
    Route::apiResource('educators', EducatorController::class);
    Route::get('notifications/diet-feedback', [DietFeedbackController::class, 'newForEducator']);
    Route::get('notifications/workout-feedback', [WorkoutFeedbackController::class, 'newForEducator']);
    Route::apiResource('patients', PatientController::class);
    Route::get('patients/for-educator', [PatientController::class, 'PatientsForEducator']);
    Route::get('notifications/diet-items', [DietItemController::class, 'notifiedForPatient']);
    Route::get('notifications/workout-items', [WorkoutItemController::class, 'notifiedForPatient']);
    Route::apiResource('patient-registrations', PatientRegistrationController::class);
    Route::apiResource('patient-weights', PatientWeightController::class);
    Route::apiResource('progress-charts', ProgressChartController::class);
    Route::apiResource('workouts', WorkoutController::class);
    Route::apiResource('workout-feedbacks', WorkoutFeedbackController::class);
    Route::apiResource('workout-feedback-notifications', WorkoutFeedbackNotificationController::class);
    Route::apiResource('workout-items', WorkoutItemController::class);
    Route::apiResource('workout-notifications', WorkoutNotificationController::class);

    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::get('exercises/{id}', [ExerciseController::class, 'show']);
    Route::get('foods', [FoodController::class, 'index']);
    Route::get('foods/{id}', [FoodController::class, 'show']);
    Route::get('meals', [MealController::class, 'index']);
    Route::get('meals/{id}', [MealController::class, 'show']);
    Route::get('workout-type', [WorkoutTypeController::class, 'index']);
    Route::get('workout-type/{id}', [WorkoutTypeController::class, 'show']);
    Route::get('muscle-groups', [MuscleGroupController::class, 'index']);
    Route::get('muscle-groups/{id}', [MuscleGroupController::class, 'show']);

    // Route::apiResource('administrators', AdministratorController::class); // uso so pra teste, depois retirar
});

Route::middleware('auth:patient')->prefix('patients')->group(function () {
    Route::get('/diets', [DietController::class, 'getForPacientDiets']);
    Route::get('/diet-items', [DietItemController::class, 'getForPacientDietItem']);
    Route::get('/workouts', [WorkoutController::class, 'getForPacientWorkout']);
    Route::get('/workout-items', [WorkoutItemController::class, 'getForPacientWorkoutItem']);

    Route::post('logout', [AuthenticateController::class, 'logout']);
});

Route::middleware('auth:administrator')->prefix('administrators')->group(function () {
    Route::apiResource('administrators', AdministratorController::class);
    Route::apiResource('exercises', ExerciseController::class);
    Route::apiResource('foods', FoodController::class);
    Route::apiResource('meals', MealController::class);
    Route::apiResource('workout-type', WorkoutTypeController::class);
    Route::apiResource('muscle-groups', MuscleGroupController::class);

    Route::post('logout', [AuthenticateController::class, 'logout']);
});
