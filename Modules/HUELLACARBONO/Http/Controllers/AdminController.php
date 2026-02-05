<?php

namespace Modules\HUELLACARBONO\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HUELLACARBONO\Entities\ProductiveUnit;
use Modules\HUELLACARBONO\Entities\EmissionFactor;
use Modules\HUELLACARBONO\Entities\DailyConsumption;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard del Admin
     */
    public function dashboard()
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Estadísticas generales
        $totalUnits = ProductiveUnit::where('is_active', true)->count();
        $totalFactors = EmissionFactor::where('is_active', true)->count();
        $totalConsumptions = DailyConsumption::count();

        // CO2 semanal, mensual y anual
        $weeklyTotal = DailyConsumption::whereBetween('consumption_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->sum('co2_generated');

        $monthlyTotal = DailyConsumption::whereBetween('consumption_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->sum('co2_generated');

        $yearlyTotal = DailyConsumption::whereBetween('consumption_date', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear()
        ])->sum('co2_generated');

        // Últimos registros
        $recentConsumptions = DailyConsumption::with(['productiveUnit', 'emissionFactor', 'registeredBy'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('huellacarbono::admin.dashboard', compact(
            'totalUnits',
            'totalFactors',
            'totalConsumptions',
            'weeklyTotal',
            'monthlyTotal',
            'yearlyTotal',
            'recentConsumptions'
        ));
    }

    /**
     * Ver todos los consumos (solo lectura)
     */
    public function allConsumptions(Request $request)
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $query = DailyConsumption::with(['productiveUnit', 'emissionFactor', 'registeredBy']);

        // Filtros
        if ($request->has('unit_id')) {
            $query->where('productive_unit_id', $request->unit_id);
        }
        if ($request->has('start_date')) {
            $query->where('consumption_date', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->where('consumption_date', '<=', $request->end_date);
        }

        $consumptions = $query->orderBy('consumption_date', 'desc')->paginate(50);
        $units = ProductiveUnit::where('is_active', true)->get();

        return view('huellacarbono::admin.consumptions', compact('consumptions', 'units'));
    }

    /**
     * Ver unidades productivas (solo lectura)
     */
    public function productiveUnits()
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $units = ProductiveUnit::with('leader')->where('is_active', true)->orderBy('name')->get();
        
        return view('huellacarbono::admin.units', compact('units'));
    }

    /**
     * Reportes
     */
    public function reports()
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $units = ProductiveUnit::where('is_active', true)->get();
        
        return view('huellacarbono::admin.reports', compact('units'));
    }

    /**
     * Gráficas
     */
    public function charts()
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return view('huellacarbono::admin.charts');
    }

    /**
     * Exportar PDF
     */
    public function exportPDF(Request $request)
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // Implementar exportación PDF
        return response()->json([
            'message' => 'Funcionalidad de exportación a PDF en desarrollo'
        ]);
    }

    /**
     * Exportar Excel
     */
    public function exportExcel(Request $request)
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // Implementar exportación Excel
        return response()->json([
            'message' => 'Funcionalidad de exportación a Excel en desarrollo'
        ]);
    }

    /**
     * Obtener datos para gráficas
     */
    public function getChartData(Request $request)
    {
        // Verificar permisos
        if (!checkRol('huellacarbono.admin') && !checkRol('huellacarbono.superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos.'
            ], 403);
        }

        $period = $request->get('period', 'monthly');
        
        // Implementar lógica de gráficas según período
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }
}





