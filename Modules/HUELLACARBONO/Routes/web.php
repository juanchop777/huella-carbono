<?php

use Illuminate\Support\Facades\Route;
use Modules\HUELLACARBONO\Http\Controllers\HUELLACARBONOController;
use Modules\HUELLACARBONO\Http\Controllers\SuperAdminController;
use Modules\HUELLACARBONO\Http\Controllers\AdminController;
use Modules\HUELLACARBONO\Http\Controllers\LeaderController;
use Modules\HUELLACARBONO\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['lang'])->group(function () {
    Route::prefix('huellacarbono')->group(function() {
        
        // ===== RUTAS PÚBLICAS (Visitantes) =====
        Route::controller(PublicController::class)->group(function() {
            Route::get('/index', 'index')->name('cefa.huellacarbono.index');
            Route::get('/informacion', 'information')->name('cefa.huellacarbono.information');
            Route::get('/calculadora-personal', 'personalCalculator')->name('cefa.huellacarbono.personal_calculator');
            Route::post('/calculadora-personal/calcular', 'calculatePersonalFootprint')->name('cefa.huellacarbono.calculate_personal');
            Route::get('/estadisticas-publicas', 'publicStatistics')->name('cefa.huellacarbono.public_statistics');
            Route::get('/desarrolladores', 'developers')->name('cefa.huellacarbono.developers');
        });

        // ===== RUTAS SUPERADMIN =====
        Route::middleware(['auth'])->prefix('superadmin')->controller(SuperAdminController::class)->group(function() {
            Route::get('/dashboard', 'dashboard')->name('cefa.huellacarbono.superadmin.dashboard');
            
            // Gestión de Unidades Productivas
            Route::get('/unidades', 'productiveUnits')->name('cefa.huellacarbono.superadmin.units.index');
            Route::post('/unidades/store', 'storeProductiveUnit')->name('cefa.huellacarbono.superadmin.units.store');
            Route::put('/unidades/{id}/update', 'updateProductiveUnit')->name('cefa.huellacarbono.superadmin.units.update');
            Route::delete('/unidades/{id}/delete', 'deleteProductiveUnit')->name('cefa.huellacarbono.superadmin.units.delete');
            Route::post('/unidades/{id}/asignar-lider', 'assignLeader')->name('cefa.huellacarbono.superadmin.units.assign_leader');
            Route::post('/unidades/{id}/toggle-status', 'toggleUnitStatus')->name('cefa.huellacarbono.superadmin.units.toggle_status');
            
            // Gestión de Factores de Emisión
            Route::get('/factores-emision', 'emissionFactors')->name('cefa.huellacarbono.superadmin.factors.index');
            Route::post('/factores-emision/store', 'storeEmissionFactor')->name('cefa.huellacarbono.superadmin.factors.store');
            Route::put('/factores-emision/{id}/update', 'updateEmissionFactor')->name('cefa.huellacarbono.superadmin.factors.update');
            Route::post('/factores-emision/{id}/toggle-status', 'toggleFactorStatus')->name('cefa.huellacarbono.superadmin.factors.toggle_status');
            Route::delete('/factores-emision/{id}/delete', 'deleteEmissionFactor')->name('cefa.huellacarbono.superadmin.factors.delete');
            
            // Gestión de Usuarios
            Route::get('/usuarios', 'users')->name('cefa.huellacarbono.superadmin.users.index');
            Route::post('/usuarios/{id}/roles', 'assignRole')->name('cefa.huellacarbono.superadmin.users.assign_role');
            
            // Visualización y Edición de Datos
            Route::get('/consumos', 'allConsumptions')->name('cefa.huellacarbono.superadmin.consumptions.index');
            Route::put('/consumos/{id}/editar', 'editConsumption')->name('cefa.huellacarbono.superadmin.consumptions.edit');
            Route::delete('/consumos/{id}/eliminar', 'deleteConsumption')->name('cefa.huellacarbono.superadmin.consumptions.delete');
            
            // Reportes y Exportaciones
            Route::get('/reportes', 'reports')->name('cefa.huellacarbono.superadmin.reports.index');
            Route::get('/reportes/exportar-pdf', 'exportPDF')->name('cefa.huellacarbono.superadmin.reports.export_pdf');
            Route::get('/reportes/exportar-excel', 'exportExcel')->name('cefa.huellacarbono.superadmin.reports.export_excel');
            
            // Gráficas
            Route::get('/graficas', 'charts')->name('cefa.huellacarbono.superadmin.charts.index');
            Route::post('/graficas/datos', 'getChartData')->name('cefa.huellacarbono.superadmin.charts.data');
            
            // Solicitudes de registro (Líder → aprobación SuperAdmin)
            Route::get('/solicitudes-registro', 'consumptionRequests')->name('cefa.huellacarbono.superadmin.requests.index');
            Route::post('/solicitudes-registro/{id}/aprobar', 'approveConsumptionRequest')->name('cefa.huellacarbono.superadmin.requests.approve');
            Route::post('/solicitudes-registro/{id}/rechazar', 'rejectConsumptionRequest')->name('cefa.huellacarbono.superadmin.requests.reject');
        });

        // ===== RUTAS ADMIN =====
        Route::middleware(['auth'])->prefix('admin')->controller(AdminController::class)->group(function() {
            Route::get('/dashboard', 'dashboard')->name('cefa.huellacarbono.admin.dashboard');
            
            // Visualización de Datos
            Route::get('/consumos', 'allConsumptions')->name('cefa.huellacarbono.admin.consumptions.index');
            Route::get('/unidades', 'productiveUnits')->name('cefa.huellacarbono.admin.units.index');
            
            // Reportes y Gráficas
            Route::get('/reportes', 'reports')->name('cefa.huellacarbono.admin.reports.index');
            Route::get('/reportes/exportar-pdf', 'exportPDF')->name('cefa.huellacarbono.admin.reports.export_pdf');
            Route::get('/reportes/exportar-excel', 'exportExcel')->name('cefa.huellacarbono.admin.reports.export_excel');
            Route::get('/graficas', 'charts')->name('cefa.huellacarbono.admin.charts.index');
            Route::post('/graficas/datos', 'getChartData')->name('cefa.huellacarbono.admin.charts.data');
        });

        // ===== RUTAS LÍDER DE UNIDAD =====
        Route::middleware(['auth'])->prefix('lider')->controller(LeaderController::class)->group(function() {
            Route::get('/dashboard', 'dashboard')->name('cefa.huellacarbono.leader.dashboard');
            Route::get('/alertas-solicitudes', 'alertsAndRequests')->name('cefa.huellacarbono.leader.alerts_requests');
            
            // Registro de Consumos Diarios
            Route::get('/registrar-consumo', 'registerConsumption')->name('cefa.huellacarbono.leader.register');
            Route::post('/registrar-consumo/guardar', 'storeConsumption')->name('cefa.huellacarbono.leader.store_consumption');
            Route::post('/registrar-consumo/guardar-multiples', 'storeMultipleConsumptions')->name('cefa.huellacarbono.leader.store_multiple_consumptions');
            
            // Ver Historial de su Unidad
            Route::get('/historial', 'history')->name('cefa.huellacarbono.leader.history');
            Route::get('/consumo/{id}/editar', 'editOwnConsumption')->name('cefa.huellacarbono.leader.edit_consumption');
            Route::put('/consumo/{id}/actualizar', 'updateOwnConsumption')->name('cefa.huellacarbono.leader.update_consumption');
            
            // Estadísticas de su Unidad
            Route::get('/estadisticas', 'statistics')->name('cefa.huellacarbono.leader.statistics');
            Route::get('/graficas', 'charts')->name('cefa.huellacarbono.leader.charts');
            
            // Solicitar registro para fecha no reportada (requiere aprobación SuperAdmin)
            Route::get('/solicitar-registro', 'requestConsumptionForm')->name('cefa.huellacarbono.leader.request_form');
            Route::post('/solicitar-registro/guardar', 'storeConsumptionRequest')->name('cefa.huellacarbono.leader.store_request');
        });
    });
});

