<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\HUELLACARBONO\Entities\ProductiveUnit as HCProductiveUnit;

class ImportOriginalUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Importa las unidades productivas originales de SICA a la tabla de Huella de Carbono
     *
     * @return void
     */
    public function run()
    {
        echo "\n🔄 Importando unidades productivas de SICA...\n";

        // Obtener las unidades originales de SICA
        $originalUnits = DB::table('productive_units')
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        if ($originalUnits->isEmpty()) {
            echo "⚠️  No hay unidades en la tabla original (productive_units)\n";
            return;
        }

        $imported = 0;
        $skipped = 0;

        foreach ($originalUnits as $unit) {
            // Generar código único a partir del nombre
            $code = strtoupper(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\s]/', '', $unit->name)));
            
            // Limitar código a 50 caracteres
            if (strlen($code) > 50) {
                $code = substr($code, 0, 50);
            }

            // Verificar si ya existe una unidad HC con este código
            $exists = HCProductiveUnit::where('code', $code)
                ->orWhere('productive_unit_id', $unit->id)
                ->first();

            if ($exists) {
                echo "   ⏭️  Saltando: {$unit->name} (ya existe)\n";
                $skipped++;
                continue;
            }

            // Crear la unidad en HC relacionada con la original
            HCProductiveUnit::create([
                'productive_unit_id' => $unit->id, // ← Relación con SICA
                'name' => $unit->name,
                'code' => $code,
                'description' => $unit->description ?? 'Unidad importada de SICA',
                'leader_user_id' => null, // Se asignará después
                'is_active' => true
            ]);

            echo "   ✅ Importada: {$unit->name} [{$code}]\n";
            $imported++;
        }

        echo "\n📊 Resumen:\n";
        echo "   ✅ Importadas: {$imported}\n";
        echo "   ⏭️  Saltadas: {$skipped}\n";
        echo "   📦 Total originales: " . $originalUnits->count() . "\n\n";
    }
}





