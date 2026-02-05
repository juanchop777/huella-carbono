<?php

namespace Modules\HUELLACARBONO\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HUELLACARBONO\Entities\PersonalCarbonCalculation;
use Modules\HUELLACARBONO\Entities\EmissionFactor;
use Modules\HUELLACARBONO\Entities\DailyConsumption;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Página principal pública del módulo
     * Redirige automáticamente según el rol del usuario
     */
    public function index()
    {
        // Si el usuario está autenticado, redirigir según su rol (mismo orden que el navbar: Líder antes que Admin)
        if (Auth::check()) {
            if (checkRol('huellacarbono.superadmin')) {
                return redirect()->route('cefa.huellacarbono.superadmin.dashboard');
            }
            if (checkRol('huellacarbono.leader')) {
                return redirect()->route('cefa.huellacarbono.leader.dashboard');
            }
            if (checkRol('huellacarbono.admin')) {
                return redirect()->route('cefa.huellacarbono.admin.dashboard');
            }
        }
        
        // Usuario sin rol específico o visitante → vista pública
        return view('huellacarbono::public.index');
    }

    /**
     * Información sobre la huella de carbono
     */
    public function information()
    {
        $emissionFactors = EmissionFactor::active()->get();
        return view('huellacarbono::public.information', compact('emissionFactors'));
    }

    /**
     * Página de desarrolladores y herramientas del proyecto
     */
    public function developers()
    {
        return view('huellacarbono::public.developers');
    }

    /**
     * Calculadora personal de huella de carbono
     */
    public function personalCalculator()
    {
        $emissionFactors = EmissionFactor::active()->get();
        return view('huellacarbono::public.calculator', compact('emissionFactors'));
    }

    /**
     * Calcular huella de carbono personal
     */
    public function calculatePersonalFootprint(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'water_consumption' => 'nullable|numeric|min:0',
            'energy_consumption' => 'nullable|numeric|min:0',
            'gasoline_consumption' => 'nullable|numeric|min:0',
            'diesel_consumption' => 'nullable|numeric|min:0',
            'waste_generation' => 'nullable|numeric|min:0',
            'number_of_animals' => 'nullable|integer|min:0',
            'synthetic_fertilizers' => 'nullable|numeric|min:0',
            'fertilizer_nitrogen_percentage' => 'nullable|numeric|min:0|max:100',
            'insecticides' => 'nullable|numeric|min:0',
            'fungicides' => 'nullable|numeric|min:0',
            'herbicides' => 'nullable|numeric|min:0',
            'period' => 'required|in:daily,weekly,monthly,yearly'
        ]);

        // Calcular el total de CO2
        $totalCO2 = PersonalCarbonCalculation::calculateTotalCO2($validated);
        $validated['total_co2'] = $totalCO2;

        // Guardar el cálculo
        $calculation = PersonalCarbonCalculation::create($validated);

        return response()->json([
            'success' => true,
            'total_co2' => $totalCO2,
            'message' => 'Cálculo realizado exitosamente',
            'calculation_id' => $calculation->id
        ]);
    }

    /**
     * Estadísticas públicas del centro de formación
     */
    public function publicStatistics(Request $request)
    {
        $period = $request->get('period', 'weekly'); // weekly, monthly, yearly
        
        $startDate = match($period) {
            'weekly' => Carbon::now()->startOfWeek(),
            'monthly' => Carbon::now()->startOfMonth(),
            'yearly' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfWeek(),
        };
        
        $endDate = Carbon::now();

        // Obtener total de CO2 del centro
        $totalCO2 = DailyConsumption::whereBetween('consumption_date', [$startDate, $endDate])
            ->sum('co2_generated');

        // CO2 por unidad productiva (Top 10)
        $co2ByUnit = DailyConsumption::whereBetween('consumption_date', [$startDate, $endDate])
            ->selectRaw('productive_unit_id, SUM(co2_generated) as total_co2')
            ->groupBy('productive_unit_id')
            ->with('productiveUnit')
            ->orderBy('total_co2', 'desc')
            ->limit(10)
            ->get();

        // CO2 por tipo de consumo
        $co2ByType = DailyConsumption::whereBetween('consumption_date', [$startDate, $endDate])
            ->selectRaw('emission_factor_id, SUM(co2_generated) as total_co2')
            ->groupBy('emission_factor_id')
            ->with('emissionFactor')
            ->orderBy('total_co2', 'desc')
            ->get();

        return view('huellacarbono::public.statistics', compact(
            'totalCO2',
            'co2ByUnit',
            'co2ByType',
            'period',
            'startDate',
            'endDate'
        ));
    }
}

