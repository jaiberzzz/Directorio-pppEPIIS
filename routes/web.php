<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\HomeController;

// --- Rutas Públicas ---

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Datos para el directorio de practicantes (AJAX/API)
Route::get('/directory-data', [HomeController::class, 'getPractitioners'])->name('directory.data');



// Página de contacto y envío de formulario
use App\Http\Controllers\ContactController;
Route::get('/contacto', [ContactController::class, 'index'])->name('contact');
Route::post('/contacto', [ContactController::class, 'send'])->name('contact.send');

use App\Http\Controllers\ConvocatoriaController;
// Listado público de convocatorias
Route::get('/convocatorias', [ConvocatoriaController::class, 'index'])->name('convocatorias.index');


// --- Rutas Protegidas (Requieren inicio de sesión y verificación de correo) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard general (vista por defecto)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- Rutas Administrativas ---
    // Accesibles para roles: Superadmin y Docente
    Route::middleware(['role:Superadmin|Docente'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Administrativo (Nuevo)
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Gestión de practicantes, convocatorias, noticias, documentos y solicitudes
        Route::resource('practitioners', App\Http\Controllers\Admin\PractitionerController::class);
        Route::resource('convocatorias', App\Http\Controllers\Admin\ConvocatoriaController::class);
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
        Route::resource('documents', App\Http\Controllers\Admin\DocumentController::class);
        Route::resource('requests', App\Http\Controllers\Admin\PermissionRequestController::class);

        // Report Actions
        Route::get('/practitioners/{practitioner}/review-report', [App\Http\Controllers\Admin\PractitionerController::class, 'reviewReport'])->name('practitioners.review-report');
        Route::post('/practitioners/{practitioner}/approve-report', [App\Http\Controllers\Admin\PractitionerController::class, 'approveReport'])->name('practitioners.approve-report');
        Route::post('practitioners/{practitioner}/reject-report', [App\Http\Controllers\Admin\PractitionerController::class, 'rejectReport'])->name('practitioners.reject-report');

        // Notifications
        Route::get('/notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
    });

    // --- Rutas de Superadministrador ---
    // Accesibles solo para rol: Superadmin
    Route::middleware(['role:Superadmin'])->prefix('admin')->name('admin.')->group(function () {
        // Gestión de usuarios del sistema
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        // Gestión de Configuración (Superadmin)
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    });
});

// --- Rutas del Portal de Estudiantes ---
// Redirección al dashboard del estudiante y lógica de reportes/solicitudes
Route::middleware(['auth', 'verified'])->get('/dashboard', [App\Http\Controllers\Student\PortalController::class, 'index'])->name('dashboard');
Route::middleware(['auth', 'verified'])->post('/student/report/upload', [App\Http\Controllers\Student\PortalController::class, 'uploadReport'])->name('student.report.upload');
Route::middleware(['auth', 'verified'])->post('/student/request/store', [App\Http\Controllers\Student\PortalController::class, 'storeRequest'])->name('student.request.store');
Route::middleware(['auth', 'verified'])->post('/student/schedule/update', [App\Http\Controllers\Student\ScheduleController::class, 'update'])->name('student.schedule.update');

// --- Rutas de Perfil de Usuario ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
