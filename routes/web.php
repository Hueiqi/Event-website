<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [EventController::class, 'publicIndex'])->name('home');
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show')->whereNumber('event');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');

// Authenticated (all roles)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::put('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/notifications', [UserController::class, 'updateNotifications'])->name('profile.notifications');
    Route::delete('/profile', [UserController::class, 'destroyAccount'])->name('profile.destroy');

    // Participant
    Route::middleware('role:participant')->group(function () {
        Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('registrations.store');
        Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
        Route::get('/registrations/{registration}/certificate', [CertificateController::class, 'generate'])->name('certificates.generate');
        Route::get('/registrations/{registration}/attendance-slip', [RegistrationController::class, 'showAttendanceSlip'])->name('registrations.attendance-slip');
        Route::get('/registrations/{registration}/questionnaire', [RegistrationController::class, 'showQuestionnaire'])->name('registrations.questionnaire.show');
        Route::post('/registrations/{registration}/questionnaire', [RegistrationController::class, 'submitQuestionnaire'])->name('registrations.questionnaire');
    });

    // Material downloads (any authenticated + registered participant)
    Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');

    // Event Organizer + Agency Admin + Admin
    Route::middleware('role:organizer,agency_admin,admin')->group(function () {
        Route::resource('events', EventController::class)->except(['show']);
        Route::get('/events/{event}/registrations', [RegistrationController::class, 'index'])->name('events.registrations');
        Route::post('/events/{event}/attendance/{registration}', [RegistrationController::class, 'markAttendance'])->name('registrations.attendance');
        Route::post('/events/{event}/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
        Route::get('/events/{event}/report', [EventController::class, 'report'])->name('events.report');
        Route::post('/events/{event}/announce', [EventController::class, 'announce'])->name('events.announce');
    });

    // Agency Admin
    Route::middleware('role:agency_admin,admin')->group(function () {
        Route::get('/agency/profile', [AgencyController::class, 'edit'])->name('agency.edit');
        Route::put('/agency/profile', [AgencyController::class, 'update'])->name('agency.update');
        Route::resource('organizers', UserController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/agency/reports', [AgencyController::class, 'reports'])->name('agency.reports');
    });

    // System Administrator
    Route::middleware('role:admin')->group(function () {
        Route::resource('agencies', AgencyController::class);
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/admin/reports', [DashboardController::class, 'systemReports'])->name('admin.reports');
        Route::get('/admin/activity', [DashboardController::class, 'activityLog'])->name('admin.activity');
    });
});
