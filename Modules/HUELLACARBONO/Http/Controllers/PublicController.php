<?php

namespace Modules\HUELLACARBONO\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HUELLACARBONO\Entities\PersonalCarbonCalculation;
use Modules\HUELLACARBONO\Entities\EmissionFactor;
use Modules\HUELLACARBONO\Entities\DailyConsumption;
use Modules\HUELLACARBONO\Entities\ProductiveUnit;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Página principal pública del módulo
     * Redirige automáticamente según el rol del usuario
     */
    public function index()
    {
        // Si el usuario está autenticado, redirigir según su rol (Líder tiene prioridad: no ver Admin)
        if (Auth::check()) {
            if (checkRol('huellacarbono.leader')) {
                // Solo redirigir al dashboard si tiene una unidad asignada (evita bucle cuando se quitó rol y se volvió a asignar sin reasignar en Unidades)
                $leaderUnit = ProductiveUnit::where('leader_user_id', Auth::id())->first();
                if ($leaderUnit) {
                    return redirect()->route('cefa.huellacarbono.leader.dashboard');
                }
                session()->flash('message', 'Tienes rol de líder pero no tienes una unidad productiva asignada. Un administrador debe asignarte como líder en la sección Unidades.');
                session()->flash('icon', 'error');
            }
            if (checkRol('huellacarbono.admin')) {
                return redirect()->route('cefa.huellacarbono.admin.dashboard');
            }
        }
        
        // Mapa de calor: todas las unidades activas. Si tienen lat/lng se usan; si no, posición por defecto (las de antes).
        $centerLat = (float) env('MAPBOX_CENTER_LAT', 2.612606);
        $centerLng = (float) env('MAPBOX_CENTER_LNG', -75.361439);
        $defaultPositions = [
            ['lat' => $centerLat, 'lng' => $centerLng],
            ['lat' => $centerLat - 0.0004, 'lng' => $centerLng - 0.0005],
            ['lat' => $centerLat + 0.0002, 'lng' => $centerLng - 0.0003],
            ['lat' => $centerLat - 0.0003, 'lng' => $centerLng + 0.0004],
            ['lat' => $centerLat - 0.0005, 'lng' => $centerLng + 0.0002],
            ['lat' => $centerLat - 0.0006, 'lng' => $centerLng - 0.0002],
            ['lat' => $centerLat + 0.0003, 'lng' => $centerLng + 0.0003],
            ['lat' => $centerLat + 0.0005, 'lng' => $centerLng + 0.0005],
            ['lat' => $centerLat + 0.0006, 'lng' => $centerLng + 0.0006],
            ['lat' => $centerLat + 0.0004, 'lng' => $centerLng + 0.0007],
            ['lat' => $centerLat + 0.0001, 'lng' => $centerLng - 0.0004],
            ['lat' => $centerLat - 0.0001, 'lng' => $centerLng - 0.0001],
            ['lat' => $centerLat - 0.0002, 'lng' => $centerLng],
            ['lat' => $centerLat - 0.0007, 'lng' => $centerLng - 0.0004],
            ['lat' => $centerLat - 0.0004, 'lng' => $centerLng - 0.0006],
            ['lat' => $centerLat - 0.0006, 'lng' => $centerLng + 0.0001],
            ['lat' => $centerLat + 0.0002, 'lng' => $centerLng - 0.0005],
            ['lat' => $centerLat - 0.0002, 'lng' => $centerLng + 0.00035],
            ['lat' => $centerLat + 0.00055, 'lng' => $centerLng + 0.0004],
            ['lat' => $centerLat + 0.00005, 'lng' => $centerLng + 0.0001],
        ];

        $units = ProductiveUnit::where('is_active', true)->orderBy('name')->get();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $heatmapZones = [];
        $forceDefaultForNames = ['cárnica', 'carnica', 'sen']; // Unidad Cárnica y Unidad SEN en la misma zona que las demás
        foreach ($units as $index => $unit) {
            $co2 = (float) DailyConsumption::where('productive_unit_id', $unit->id)
                ->whereBetween('consumption_date', [$startOfMonth, $endOfMonth])
                ->sum('co2_generated');
            $pos = $defaultPositions[$index % count($defaultPositions)];
            $nameLower = mb_strtolower($unit->name);
            $useDefault = ($unit->latitude === null && $unit->longitude === null)
                || collect($forceDefaultForNames)->contains(fn ($term) => str_contains($nameLower, $term));
            $heatmapZones[] = [
                'name' => $unit->name,
                'lat'  => $useDefault ? $pos['lat'] : (float) $unit->latitude,
                'lng'  => $useDefault ? $pos['lng'] : (float) $unit->longitude,
                'co2'  => round($co2, 2),
            ];
        }

        $mapboxToken = config('services.mapbox.token', env('MAPBOX_TOKEN'));

        return view('huellacarbono::public.index', compact('heatmapZones', 'mapboxToken'));
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
     * Calcular huella de carbono personal usando los factores de emisión de la base de datos
     */
    public function calculatePersonalFootprint(Request $request)
    {
        $emissionFactors = EmissionFactor::active()->get();

        // Normalizar: vacío o 0 en consumos como null para validación
        $input = $request->all();
        foreach ($emissionFactors as $factor) {
            $key = strtolower(trim($factor->code)) . '_consumption';
            if (array_key_exists($key, $input)) {
                $v = $input[$key];
                if ($v === '' || $v === null || $v === '0' || (is_numeric($v) && (float) $v <= 0)) {
                    $input[$key] = null;
                }
            }
        }
        if (array_key_exists('fertilizer_nitrogen_percentage', $input) && ($input['fertilizer_nitrogen_percentage'] === '' || $input['fertilizer_nitrogen_percentage'] === null)) {
            $input['fertilizer_nitrogen_percentage'] = null;
        }
        $request->merge($input);

        $rules = [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'period' => 'required|in:daily,weekly,monthly,yearly',
            'fertilizer_nitrogen_percentage' => 'nullable|numeric|min:0|max:100',
        ];
        foreach ($emissionFactors as $factor) {
            $key = strtolower(trim($factor->code)) . '_consumption';
            $rules[$key] = 'nullable|numeric|min:0';
        }

        try {
            $validated = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => implode(' ', $e->validator->errors()->all()),
                'errors' => $e->errors()
            ], 422);
        }

        // Calcular total CO2 con los factores de la base de datos
        $totalCO2 = 0;
        $nitrogenPct = isset($validated['fertilizer_nitrogen_percentage']) ? (float) $validated['fertilizer_nitrogen_percentage'] : null;

        foreach ($emissionFactors as $factor) {
            $key = strtolower(trim($factor->code)) . '_consumption';
            $quantity = isset($validated[$key]) ? (float) $validated[$key] : 0;
            if ($quantity <= 0) {
                continue;
            }
            $totalCO2 += $factor->calculateCO2($quantity, $factor->requires_percentage ? $nitrogenPct : null);
        }

        $totalCO2 = round($totalCO2, 3);
        $validated['total_co2'] = $totalCO2;

        // Campos numéricos que la BD no acepta como NULL (consumos con default 0)
        $numericNotNull = [
            'water_consumption', 'energy_consumption', 'gasoline_consumption', 'diesel_consumption',
            'waste_generation', 'number_of_animals', 'synthetic_fertilizers', 'insecticides',
            'fungicides', 'herbicides',
        ];
        $model = new PersonalCarbonCalculation();
        $allowed = array_flip($model->getFillable());
        $fillable = array_intersect_key($validated, $allowed);
        foreach ($numericNotNull as $key) {
            if (array_key_exists($key, $allowed) && (!isset($fillable[$key]) || $fillable[$key] === null || $fillable[$key] === '')) {
                $fillable[$key] = $key === 'number_of_animals' ? 0 : 0.0;
            }
        }
        try {
            $calculation = PersonalCarbonCalculation::create($fillable);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el cálculo: ' . $e->getMessage()
            ], 500);
        }

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

