<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\HUELLACARBONO\Entities\ProductiveUnit;
use Modules\HUELLACARBONO\Entities\EmissionFactor;
use Modules\HUELLACARBONO\Entities\DailyConsumption;
use Carbon\Carbon;

class HistoricalDataSeeder extends Seeder
{
    /**
     * Generar datos históricos de consumos desde 2022 hasta 2024
     * Con variaciones estacionales y patrones realistas
     *
     * @return void
     */
    public function run()
    {
        echo "\n🌱 ========== GENERANDO DATOS HISTÓRICOS DE HUELLA DE CARBONO ==========\n\n";

        // Obtener unidades y factores activos
        $units = ProductiveUnit::where('is_active', true)->get();
        $factors = EmissionFactor::where('is_active', true)->get();
        
        if ($units->isEmpty() || $factors->isEmpty()) {
            echo "❌ Error: No hay unidades o factores de emisión activos\n";
            return;
        }

        echo "📊 Configuración:\n";
        echo "   ├─ Unidades productivas: {$units->count()}\n";
        echo "   ├─ Factores de emisión: {$factors->count()}\n";
        echo "   ├─ Período: Enero 2022 - Diciembre 2024\n";
        echo "   └─ Registros estimados: ~15,000+\n\n";

        // Obtener un usuario para asignar registros (SuperAdmin)
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : 1;

        // Configuración de frecuencias por tipo de factor
        $frequencies = [
            'Consumo de agua' => 'weekly',           // Semanal
            'Consumo de energía' => 'weekly',        // Semanal
            'Consumo de combustible gasolina' => 'monthly',  // Mensual
            'Consumo de combustible ACPM' => 'monthly',      // Mensual
            'Generación de residuos sólidos y orgánicos' => 'weekly', // Semanal
            'Cantidad de animales' => 'monthly',     // Mensual (varía poco)
            'Uso de fertilizantes sintéticos' => 'biweekly', // Quincenal
            'Uso de insecticidas' => 'monthly',      // Mensual
            'Uso de fungicidas' => 'monthly',        // Mensual
            'Uso de herbicidas' => 'biweekly'        // Quincenal
        ];

        $startDate = Carbon::create(2022, 1, 1);
        $endDate = Carbon::create(2024, 12, 31);
        
        $totalInserted = 0;
        $currentDate = $startDate->copy();

        echo "🔄 Generando registros...\n\n";

        while ($currentDate <= $endDate) {
            $month = $currentDate->month;
            $year = $currentDate->year;
            
            // Mostrar progreso cada trimestre
            if ($currentDate->day == 1 && in_array($month, [1, 4, 7, 10])) {
                echo "   📅 Procesando: " . $currentDate->format('Y-m') . "\n";
            }

            // Para cada unidad productiva
            foreach ($units as $unit) {
                // Determinar qué factores aplican en esta fecha
                foreach ($factors as $factor) {
                    $frequency = $frequencies[$factor->name] ?? 'monthly';
                    
                    $shouldRegister = false;
                    
                    switch ($frequency) {
                        case 'weekly':
                            // Registrar cada 7 días (lunes)
                            $shouldRegister = $currentDate->dayOfWeek == 1;
                            break;
                        case 'biweekly':
                            // Registrar dos veces al mes (día 1 y 15)
                            $shouldRegister = in_array($currentDate->day, [1, 15]);
                            break;
                        case 'monthly':
                            // Registrar el primer día del mes
                            $shouldRegister = $currentDate->day == 1;
                            break;
                    }

                    if ($shouldRegister) {
                        // Generar cantidad con variación estacional
                        $quantity = $this->generateRealisticQuantity($factor, $month, $unit);
                        
                        // Calcular CO2
                        $co2 = $quantity * $factor->factor;
                        
                        // Si requiere porcentaje de nitrógeno (fertilizantes)
                        $nitrogenPercentage = null;
                        if ($factor->requires_percentage) {
                            $nitrogenPercentage = rand(30, 50); // 30-50% de nitrógeno
                            $co2 = $co2 * ($nitrogenPercentage / 100);
                        }

                        // Insertar registro
                        DailyConsumption::create([
                            'productive_unit_id' => $unit->id,
                            'emission_factor_id' => $factor->id,
                            'consumption_date' => $currentDate->format('Y-m-d'),
                            'quantity' => $quantity,
                            'nitrogen_percentage' => $nitrogenPercentage,
                            'co2_generated' => round($co2, 3),
                            'registered_by' => $userId,
                            'observations' => 'Dato histórico generado automáticamente'
                        ]);

                        $totalInserted++;
                    }
                }
            }

            $currentDate->addDay();
        }

        echo "\n✅ Generación completada!\n\n";
        
        // Estadísticas finales
        $this->showStatistics($totalInserted);
    }

    /**
     * Generar cantidad realista según el tipo de factor y estación
     */
    private function generateRealisticQuantity($factor, $month, $unit)
    {
        $baseRanges = [
            'Consumo de agua' => [1000, 5000],           // Litros
            'Consumo de energía' => [500, 2000],         // Kw/h
            'Consumo de combustible gasolina' => [10, 50],   // Galones
            'Consumo de combustible ACPM' => [15, 60],       // Galones
            'Generación de residuos sólidos y orgánicos' => [50, 200], // Kg
            'Cantidad de animales' => [20, 100],         // Unidades
            'Uso de fertilizantes sintéticos' => [100, 500],   // Kg
            'Uso de insecticidas' => [5, 30],            // Kg
            'Uso de fungicidas' => [5, 25],              // Kg
            'Uso de herbicidas' => [10, 40]              // Kg
        ];

        $range = $baseRanges[$factor->name] ?? [10, 100];
        
        // Variación estacional (más consumo en ciertos meses)
        $seasonalMultiplier = 1.0;
        
        // Temporada de lluvias (Abril-Noviembre) = más consumo de fungicidas/agua
        if (in_array($month, [4, 5, 6, 7, 8, 9, 10, 11])) {
            if (in_array($factor->name, ['Consumo de agua', 'Uso de fungicidas'])) {
                $seasonalMultiplier = 1.3;
            }
        }
        
        // Temporada seca (Diciembre-Marzo) = más riego
        if (in_array($month, [12, 1, 2, 3])) {
            if ($factor->name == 'Consumo de agua') {
                $seasonalMultiplier = 1.5;
            }
        }

        // Meses de mayor actividad agrícola (fertilización)
        if (in_array($month, [3, 4, 9, 10])) {
            if (in_array($factor->name, ['Uso de fertilizantes sintéticos', 'Uso de herbicidas'])) {
                $seasonalMultiplier = 1.4;
            }
        }

        $quantity = rand($range[0], $range[1]) * $seasonalMultiplier;
        
        // Añadir variación aleatoria del ±10%
        $variation = rand(-10, 10) / 100;
        $quantity = $quantity * (1 + $variation);

        return round($quantity, 2);
    }

    /**
     * Mostrar estadísticas finales
     */
    private function showStatistics($totalInserted)
    {
        echo "📊 ========== ESTADÍSTICAS ==========\n\n";
        echo "   ✅ Total de registros generados: " . number_format($totalInserted) . "\n\n";

        // CO2 por año
        $byYear = DailyConsumption::selectRaw('YEAR(consumption_date) as year, 
                                                COUNT(*) as count, 
                                                SUM(co2_generated) as total_co2')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        echo "   CO₂ Generado por Año:\n";
        foreach ($byYear as $row) {
            echo "   ├─ {$row->year}: " . number_format($row->total_co2, 2) . " kg CO₂ ({$row->count} registros)\n";
        }

        echo "\n   CO₂ por Unidad Productiva (Top 5):\n";
        $byUnit = DailyConsumption::join('hc_productive_units', 'hc_daily_consumptions.productive_unit_id', '=', 'hc_productive_units.id')
            ->selectRaw('hc_productive_units.name, SUM(co2_generated) as total_co2')
            ->groupBy('hc_productive_units.id', 'hc_productive_units.name')
            ->orderBy('total_co2', 'desc')
            ->limit(5)
            ->get();

        foreach ($byUnit as $row) {
            echo "   ├─ {$row->name}: " . number_format($row->total_co2, 2) . " kg CO₂\n";
        }

        echo "\n   CO₂ por Factor de Emisión (Top 5):\n";
        $byFactor = DailyConsumption::join('hc_emission_factors', 'hc_daily_consumptions.emission_factor_id', '=', 'hc_emission_factors.id')
            ->selectRaw('hc_emission_factors.name, SUM(co2_generated) as total_co2')
            ->groupBy('hc_emission_factors.id', 'hc_emission_factors.name')
            ->orderBy('total_co2', 'desc')
            ->limit(5)
            ->get();

        foreach ($byFactor as $row) {
            echo "   ├─ {$row->name}: " . number_format($row->total_co2, 2) . " kg CO₂\n";
        }

        $totalCO2 = DailyConsumption::sum('co2_generated');
        $treesNeeded = round($totalCO2 / 22, 2);

        echo "\n📈 TOTALES GENERALES:\n";
        echo "   🌍 CO₂ Total: " . number_format($totalCO2, 2) . " kg\n";
        echo "   🌳 Árboles necesarios: " . number_format($treesNeeded, 2) . " árboles/año\n";
        echo "   📅 Período completo: 2022-2024 (3 años)\n\n";

        echo "🎉 ¡Datos listos para generar gráficas!\n\n";
    }
}





