<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\Recepcion\ClienteRecepcionController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\Recepcion\MembresiaRecepcionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ClientePanelController;
use App\Http\Controllers\EntrenadorPanelController;
use App\Http\Controllers\EntrenadorRutinaController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Rutas exclusivas del Super Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('sucursal', SucursalController::class);
        Route::resource('usuario', UserController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas compartidas: Super Admin y Admin de Sucursal
    |--------------------------------------------------------------------------
    | Admin de sucursal puede administrar operación de su sucursal.
    | Ojo: el filtrado por sucursal debe manejarse en cada controlador.
    */
    Route::middleware('role:super_admin|admin_sucursal')->group(function () {
    Route::resource('cliente', ClienteController::class);
    Route::resource('entrenador', EntrenadorController::class);
    Route::resource('membresia', MembresiaController::class);
    });

    Route::middleware('role:super_admin|admin_sucursal|recepcionista')->group(function () {
    Route::resource('pago', PagoController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Recepción
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:recepcionista|super_admin|admin_sucursal')
        ->prefix('recepcion')
        ->name('recepcion.')
        ->group(function () {
            Route::get('/clientes', [ClienteRecepcionController::class, 'index'])
                ->name('clientes.index');

            Route::get('/clientes/create', [ClienteRecepcionController::class, 'create'])
                ->name('clientes.create');

            Route::post('/clientes', [ClienteRecepcionController::class, 'store'])
                ->name('clientes.store');

            Route::get('/membresias', [MembresiaRecepcionController::class, 'index'])
                ->name('membresias.index');

            Route::get('/membresias/create', [MembresiaRecepcionController::class, 'create'])
                ->name('membresias.create');

            Route::post('/membresias', [MembresiaRecepcionController::class, 'store'])
                ->name('membresias.store');
        });

    Route::middleware('role:recepcionista|super_admin|admin_sucursal')
        ->get('/dashboard/recepcionista', [ClienteRecepcionController::class, 'index'])
        ->name('recepcion.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Asistencias
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:recepcionista|super_admin|admin_sucursal')
        ->group(function () {
            Route::get('/asistencias', [AsistenciaController::class, 'index'])
                ->name('asistencias.index');

            Route::get('/asistencias/create', [AsistenciaController::class, 'create'])
                ->name('asistencias.create');

            Route::post('/asistencias', [AsistenciaController::class, 'store'])
                ->name('asistencias.store');

            Route::get('/asistencias/{asistencia}/denegado', [AsistenciaController::class, 'denegado'])
                ->name('asistencias.denegado');
        });

    /*
    |--------------------------------------------------------------------------
    | Panel Cliente
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:cliente')
        ->prefix('cliente-panel')
        ->name('cliente-panel.')
        ->group(function () {
            Route::get('/perfil', [ClientePanelController::class, 'perfil'])
                ->name('perfil');

            Route::get('/membresia', [ClientePanelController::class, 'membresia'])
                ->name('membresia');

            Route::get('/perfil/editar', [ClientePanelController::class, 'editPerfil'])
                ->name('perfil.edit');

            Route::patch('/perfil', [ClientePanelController::class, 'updatePerfil'])
                ->name('perfil.update');

            Route::get('/entrenador', [ClientePanelController::class, 'entrenador'])
                ->name('entrenador');

            Route::get('/rutinas', [ClientePanelController::class, 'rutinas'])
                ->name('rutinas');
        });

    Route::middleware('role:cliente')
        ->get('/dashboard/cliente', [ClientePanelController::class, 'perfil'])
        ->name('cliente.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Panel Entrenador
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:entrenador')
        ->prefix('entrenador-panel')
        ->name('entrenador-panel.')
        ->group(function () {
            Route::get('/perfil', [EntrenadorPanelController::class, 'perfil'])
                ->name('perfil');

            Route::get('/perfil/editar', [EntrenadorPanelController::class, 'editPerfil'])
                ->name('perfil.edit');

            Route::patch('/perfil', [EntrenadorPanelController::class, 'updatePerfil'])
                ->name('perfil.update');

            Route::get('/mis-clientes', [EntrenadorPanelController::class, 'misClientes'])
                ->name('mis-clientes');

            Route::get('/elegir-clientes', [EntrenadorPanelController::class, 'elegirClientes'])
                ->name('elegir-clientes');

            Route::post('/elegir-clientes', [EntrenadorPanelController::class, 'guardarClientes'])
                ->name('guardar-clientes');

            Route::get('/clientes/{cliente}/asignar-rutina', [EntrenadorPanelController::class, 'asignarRutina'])
                ->name('asignar-rutina');

            Route::post('/clientes/{cliente}/asignar-rutina', [EntrenadorPanelController::class, 'guardarRutina'])
                ->name('guardar-rutina');

            Route::get('/clientes/{cliente}/rutinas', [EntrenadorPanelController::class, 'rutinasCliente'])
                ->name('rutinas-cliente');

            Route::patch('/clientes/{cliente}/rutinas/{asignacion}/quitar', [EntrenadorPanelController::class, 'quitarRutina'])
                ->name('quitar-rutina');

            Route::get('/rutinas', [EntrenadorRutinaController::class, 'index'])
                ->name('rutinas.index');

            Route::get('/rutinas/create', [EntrenadorRutinaController::class, 'create'])
                ->name('rutinas.create');

            Route::post('/rutinas', [EntrenadorRutinaController::class, 'store'])
                ->name('rutinas.store');

            Route::get('/rutinas/{rutina}/edit', [EntrenadorRutinaController::class, 'edit'])
                ->name('rutinas.edit');

            Route::patch('/rutinas/{rutina}', [EntrenadorRutinaController::class, 'update'])
                ->name('rutinas.update');

            Route::delete('/rutinas/{rutina}', [EntrenadorRutinaController::class, 'destroy'])
                ->name('rutinas.destroy');
        });

    Route::middleware('role:entrenador')
        ->get('/dashboard/entrenador', [EntrenadorPanelController::class, 'misClientes'])
        ->name('entrenador.dashboard');
});

require __DIR__.'/settings.php';