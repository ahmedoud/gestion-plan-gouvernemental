<?php

use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\TaskManagerController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\SubActivityController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Auth::routes(['register' => false]);

// Routes pour la gestion des mots de passe oubliés
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Groupement des routes sous /dashboard
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // Tableau de bord
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/default-content', [DashboardController::class, 'defaultContent'])->name('dashboard.default_content');

    // Routes pour les utilisateurs
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Route pour afficher les programmes d'un secteur spécifique
    Route::get('secteur/{secteur}/programmes', [SecteurController::class, 'programmes'])->name('secteurs.programmes');

    // Routes pour les secteurs
    Route::resource('secteurs', SecteurController::class);

    // Routes pour les plans
    Route::resource('plans', PlanController::class);
    Route::post('plans/{plan}/archive', [PlanController::class, 'archive'])->name('plans.archive');
    Route::post('plans/{plan}/unarchive', [PlanController::class, 'unarchive']);
    Route::get('plans/{plan}/report', [PlanController::class, 'generateReport'])->name('plans.report');
    Route::post('plans/{planId}/comments', [PlanController::class, 'addComment'])->name('plans.addComment');
    Route::delete('comments/{id}', [PlanController::class, 'deleteComment'])->name('comments.delete');

    // Routes pour les programmes
    Route::resource('programmes', ProgrammeController::class);
    Route::post('programmes/{programme}/archive', [ProgrammeController::class, 'archive'])->name('programmes.archive');
    Route::get('programmes/{programme}/plans', [ProgrammeController::class, 'showPlans'])->name('programmes.plans');
    Route::get('programmes/{programme}/report', [ProgrammeController::class, 'generateReport'])->name('programmes.report');
    Route::post('/programmes/{id}/comments', [ProgrammeController::class, 'addComment'])->name('comments.add');
    Route::delete('/comments/{id}', [ProgrammeController::class, 'deleteComment'])->name('comments.delete');

    // Routes pour les activités et sous-activités sous un plan spécifique
    Route::prefix('plans/{plan}')->group(function () {
        Route::resource('activities', ActivityController::class)->except(['show']);
        Route::get('activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');

        // Sous-activités
        Route::prefix('activities/{activity}')->group(function () {
            Route::resource('sub-activities', SubActivityController::class);
            Route::prefix('sub-activities/{subActivity}')->group(function () {
                Route::resource('tasks', TaskManagerController::class);
            });
        });

        // Jalons
        Route::resource('activities/{activity}/milestones', MilestoneController::class);
    });

    // Rapports
    Route::get('/reports/plans', [ReportController::class, 'showPlans'])->name('reports.index');

    // Calendrier
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'getAllEvents'])->name('calendar.events');

    // Routes dynamiques
    Route::get('/secteurs/{id}/loadProgrammes', [SecteurController::class, 'loadProgrammes']);
    Route::get('/programmes/{id}/loadPlans', [ProgrammeController::class, 'loadPlans']);
    Route::get('/plans/{id}/loadActivities', [PlanController::class, 'loadActivities']);
    Route::get('/activities/{id}/loadSubActivities', [ActivityController::class, 'loadSubActivities']);
    Route::get('/subActivities/{id}/loadTasks', [SubActivityController::class, 'loadTasks']);
});
Route::get('/secteurs/{id}/loadProgrammes', [SecteurController::class, 'loadProgrammes']);
Route::get('/programmes/{id}/loadPlans', [ProgrammeController::class, 'loadPlans']);
Route::get('/plans/{id}/loadActivities', [PlanController::class, 'loadActivities']);
Route::get('/activities/{id}/loadSubActivities', [ActivityController::class, 'loadSubActivities']);
Route::get('/subActivities/{id}/loadTasks', [SubActivityController::class, 'loadTasks']);

// Routes pour les API dynamiques
Route::prefix('api')->group(function () {
    Route::get('/events', [ProgrammeController::class, 'getProgrammesForCalendar'])->name('calendar.programmes');
    Route::get('programmes/{programmeId}/loadPlans', [ProgrammeController::class, 'loadPlans'])->name('programmes.loadPlans');
    Route::get('plans/{planId}/loadActivities', [ProgrammeController::class, 'loadActivities'])->name('plans.loadActivities');
    Route::get('activities/{activityId}/loadSubActivities', [ProgrammeController::class, 'loadSubActivities'])->name('activities.loadSubActivities');
    Route::get('subActivities/{subActivityId}/loadTasks', [ProgrammeController::class, 'loadTasks'])->name('subActivities.loadTasks');
});

// Rôles et permissions
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('roles', RolePermissionController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('/permissions/assign', [RolePermissionController::class, 'assignPermissions'])->name('permissions.assign');
});

// Routes pour les activités et sous-activités sous un plan spécifique
Route::group(['prefix' => 'plans/{plan}', 'middleware' => 'auth'], function () {
    Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    // Routes pour les sous-activités
    Route::get('activities/{activity}/sub-activities', [SubActivityController::class, 'index'])->name('sub_activities.index');
    Route::get('activities/{activity}/sub-activities/create', [SubActivityController::class, 'create'])->name('sub_activities.create');
    Route::post('activities/{activity}/sub-activities', [SubActivityController::class, 'store'])->name('sub_activities.store');
    Route::get('activities/{activity}/sub-activities/{subActivity}/edit', [SubActivityController::class, 'edit'])->name('sub_activities.edit');
    Route::put('activities/{activity}/sub-activities/{subActivity}', [SubActivityController::class, 'update'])->name('sub_activities.update');
    Route::delete('activities/{activity}/sub-activities/{subActivity}', [SubActivityController::class, 'destroy'])->name('sub_activities.destroy');
    Route::get('activities/{activity}/sub-activities/{subActivity}', [SubActivityController::class, 'show'])->name('sub_activities.show');

    // Routes pour les tâches
    Route::get('activities/{activity}/sub-activities/{subActivity}/tasks', [TaskManagerController::class, 'index'])->name('tasks.index');
    Route::get('activities/{activity}/sub-activities/{subActivity}/tasks/create', [TaskManagerController::class, 'create'])->name('tasks.create');
    Route::post('activities/{activity}/sub-activities/{subActivity}/tasks', [TaskManagerController::class, 'store'])->name('tasks.store');
    Route::get('activities/{activity}/sub-activities/{subActivity}/tasks/{task}/edit', [TaskManagerController::class, 'edit'])->name('tasks.edit');
    Route::put('activities/{activity}/sub-activities/{subActivity}/tasks/{task}', [TaskManagerController::class, 'update'])->name('tasks.update');
    Route::delete('activities/{activity}/sub-activities/{subActivity}/tasks/{task}', [TaskManagerController::class, 'destroy'])->name('tasks.destroy');
    Route::get('activities/{activity}/sub-activities/{subActivity}/tasks/{task}', [TaskManagerController::class, 'show'])->name('tasks.show');
});