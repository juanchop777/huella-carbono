<?php

namespace Modules\HUELLACARBONO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmissionFactorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factors = [
            [
                'name' => 'Consumo de agua',
                'code' => 'WATER',
                'unit' => 'L',
                'factor' => 0.0001427,
                'description' => 'Consumo de agua en litros',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Consumo de energía',
                'code' => 'ENERGY',
                'unit' => 'Kw/h',
                'factor' => 0.112,
                'description' => 'Consumo de energía eléctrica',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Consumo de combustible gasolina',
                'code' => 'GASOLINE',
                'unit' => 'galón',
                'factor' => 8.8,
                'description' => 'Consumo de gasolina',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'Consumo de combustible ACPM',
                'code' => 'DIESEL',
                'unit' => 'galón',
                'factor' => 10.16,
                'description' => 'Consumo de combustible diesel (ACPM)',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 4
            ],
            [
                'name' => 'Generación de residuos sólidos y orgánicos',
                'code' => 'WASTE',
                'unit' => 'Kg',
                'factor' => 0.003,
                'description' => 'Generación de residuos sólidos y orgánicos',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 5
            ],
            [
                'name' => 'Cantidad de animales',
                'code' => 'ANIMALS',
                'unit' => 'Und',
                'factor' => 3.36,
                'description' => 'Cantidad de animales',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 6
            ],
            [
                'name' => 'Uso de fertilizantes sintéticos',
                'code' => 'FERTILIZERS',
                'unit' => 'Kg',
                'factor' => 0.00265,
                'description' => 'Uso de fertilizantes sintéticos (con % Nitrógeno)',
                'requires_percentage' => true,
                'is_active' => true,
                'order' => 7
            ],
            [
                'name' => 'Uso de insecticidas',
                'code' => 'INSECTICIDES',
                'unit' => 'Kg',
                'factor' => 5.1,
                'description' => 'Uso de insecticidas',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 8
            ],
            [
                'name' => 'Uso de fungicidas',
                'code' => 'FUNGICIDES',
                'unit' => 'Kg',
                'factor' => 3.9,
                'description' => 'Uso de fungicidas',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 9
            ],
            [
                'name' => 'Uso de herbicidas',
                'code' => 'HERBICIDES',
                'unit' => 'Kg',
                'factor' => 6.3,
                'description' => 'Uso de herbicidas',
                'requires_percentage' => false,
                'is_active' => true,
                'order' => 10
            ]
        ];

        foreach ($factors as $factor) {
            DB::table('hc_emission_factors')->updateOrInsert(
                ['code' => $factor['code']],
                array_merge($factor, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}





