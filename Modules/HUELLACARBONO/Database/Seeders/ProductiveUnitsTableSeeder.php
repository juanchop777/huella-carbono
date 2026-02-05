<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductiveUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['name' => 'Ecoturismo', 'code' => 'ECOTURISMO', 'description' => 'Unidad de Ecoturismo'],
            ['name' => 'Zona Agroecológica', 'code' => 'ZONA_AGROECOLOGICA', 'description' => 'Líder de Zona Agroecológica'],
            ['name' => 'Unidad de Guadua', 'code' => 'GUADUA', 'description' => 'Unidad de Guadua'],
            ['name' => 'Vivero Forestal', 'code' => 'VIVERO_FORESTAL', 'description' => 'Vivero Forestal'],
            ['name' => 'Ambiental Pecuario', 'code' => 'AMBIENTAL_PECUARIO', 'description' => 'Líder Ambiental Pecuario'],
            ['name' => 'Ambiental Acuícola', 'code' => 'AMBIENTAL_ACUICOLA', 'description' => 'Líder Ambiental Acuícola'],
            ['name' => 'Ambiental Agroindustria', 'code' => 'AMBIENTAL_AGROINDUSTRIA', 'description' => 'Líder Ambiental Agroindustria'],
            ['name' => 'Ambiental Agrícola', 'code' => 'AMBIENTAL_AGRICOLA', 'description' => 'Líder Ambiental Agrícola'],
            ['name' => 'Lombricultivo', 'code' => 'LOMBRICULTIVO', 'description' => 'Líder de Lombricultivo'],
            ['name' => 'Monitoreo Aire y Ruido', 'code' => 'MONITOREO_AIRE_RUIDO', 'description' => 'Líder Monitoreo Aire y Ruido'],
            ['name' => 'Compostaje', 'code' => 'COMPOSTAJE', 'description' => 'Líder Compostaje'],
            ['name' => 'Planta de Tratamiento Residuos Sólidos', 'code' => 'PTRS', 'description' => 'Líder Planta de Tratamiento Residuos Sólidos'],
            ['name' => 'Costos Ambientales', 'code' => 'COSTOS_AMBIENTALES', 'description' => 'Líder Costos Ambientales'],
            ['name' => 'PTAP Acueducto', 'code' => 'PTAP_ACUEDUCTO', 'description' => 'Líder PTAP Acueducto'],
            ['name' => 'Educación Ambiental', 'code' => 'EDUCACION_AMBIENTAL', 'description' => 'Líder Educación Ambiental'],
            ['name' => 'Zonas Verdes', 'code' => 'ZONAS_VERDES', 'description' => 'Líder Zonas Verdes'],
            ['name' => 'Acantarillado y Tratamiento', 'code' => 'ACANTARILLADO_TRATAMIENTO', 'description' => 'Líder Acantarillado y Tratamiento']
        ];

        foreach ($units as $unit) {
            DB::table('hc_productive_units')->updateOrInsert(
                ['code' => $unit['code']],
                array_merge($unit, [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}





