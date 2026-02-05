@extends('huellacarbono::layouts.master')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <i class="fas fa-info-circle text-7xl mb-4"></i>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                ¿Qué es la Huella de Carbono?
            </h1>
            <p class="text-xl opacity-90">
                Información sobre medición y cálculo de emisiones
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:flex lg:gap-8">
        <!-- Contenido Principal -->
        <div class="lg:flex-1 space-y-8">
            <!-- Definición -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Definición</h3>
                </div>
                
                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                    La <strong class="text-green-600">huella de carbono</strong> es un indicador ambiental que mide el total de 
                    gases de efecto invernadero (GEI) generados por nuestras actividades, expresado en 
                    unidades equivalentes de dióxido de carbono (CO₂e).
                </p>
                
                <hr class="my-6">
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="bg-green-100 w-8 h-8 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-1">
                            <i class="fas fa-calculator text-green-600"></i>
                        </div>
                        <div>
                            <h5 class="text-xl font-semibold text-gray-900 mb-2">¿Cómo se calcula?</h5>
                            <p class="text-gray-600">
                                El cálculo básico de la huella de carbono sigue esta fórmula:
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-6 rounded-lg">
                        <h4 class="text-center text-2xl font-bold text-gray-900 mb-2">
                            Huella de Carbono = Actividad × Factor de Emisión
                        </h4>
                        <p class="text-center text-sm text-gray-600">Fórmula básica de cálculo</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h6 class="font-semibold text-gray-900 mb-2">
                                <i class="fas fa-chart-line text-blue-600 mr-2"></i>Actividad
                            </h6>
                            <p class="text-sm text-gray-600">
                                Cantidad de consumo (litros, kWh, galones, kg, etc.)
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h6 class="font-semibold text-gray-900 mb-2">
                                <i class="fas fa-flask text-purple-600 mr-2"></i>Factor de Emisión
                            </h6>
                            <p class="text-sm text-gray-600">
                                Coeficiente que convierte la actividad en kg de CO₂
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ejemplo Práctico -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-xl p-8 border border-yellow-200">
                <div class="flex items-center mb-6">
                    <div class="bg-yellow-400 w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-lightbulb text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Ejemplo Práctico</h3>
                </div>
                
                <h5 class="text-xl font-semibold text-gray-900 mb-3">Electricidad en Casa</h5>
                <p class="text-lg font-medium text-gray-700 mb-4">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Supongamos que gasté <strong>100 kWh al mes</strong>
                </p>
                
                <div class="space-y-2 mb-6">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Consumo: <strong class="ml-2">100 kWh</strong>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Factor de emisión: <strong class="ml-2">0.18 kg CO₂/kWh</strong>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h5 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-calculator text-blue-600 mr-2"></i> Cálculo:
                    </h5>
                    <p class="text-xl text-gray-800">
                        100 kWh × 0.18 = <strong class="text-2xl text-green-600">18 kg de CO₂</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-80 lg:flex-shrink-0 mt-8 lg:mt-0">
            <div class="lg:sticky lg:top-24 space-y-6">
                <!-- Factores de Emisión -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-green-600 text-white px-6 py-4">
                    <h3 class="text-xl font-bold flex items-center">
                        <i class="fas fa-list-ol mr-2"></i> Factores de Emisión
                    </h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Variable</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Unidad</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Factor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($emissionFactors as $factor)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $factor->name }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $factor->unit }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900">{{ $factor->factor }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>

                <!-- Botón Calculadora -->
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-xl p-6 text-white text-center">
                    <i class="fas fa-calculator text-5xl mb-4"></i>
                    <h5 class="text-xl font-bold mb-2">¿Quieres calcular tu huella?</h5>
                    <p class="text-sm opacity-90 mb-4">Usa nuestra calculadora interactiva</p>
                    <a href="{{ route('cefa.huellacarbono.personal_calculator') }}" 
                       class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-arrow-right mr-2"></i> Ir a la Calculadora
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón Volver -->
    <div class="mt-12 text-center">
        <a href="{{ route('cefa.huellacarbono.index') }}" 
           class="inline-flex items-center px-8 py-4 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition shadow-lg">
            <i class="fas fa-arrow-left mr-2"></i> Volver al Inicio
        </a>
    </div>
</div>
@endsection
