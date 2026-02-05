@extends('huellacarbono::layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <i class="fas fa-user-shield text-red-600"></i> Panel SuperAdmin
            </h1>
            <p class="text-gray-600">Gestión completa del módulo Huella de Carbono</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- CO2 Semanal -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar-week text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Semanal</span>
                </div>
                <p class="text-3xl font-bold mb-1">{{ number_format($weeklyTotal, 2) }}</p>
                <p class="text-sm opacity-90">kg CO₂ esta semana</p>
            </div>

            <!-- CO2 Mensual -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar-alt text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Mensual</span>
                </div>
                <p class="text-3xl font-bold mb-1">{{ number_format($monthlyTotal, 2) }}</p>
                <p class="text-sm opacity-90">kg CO₂ este mes</p>
            </div>

            <!-- CO2 Anual -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Anual</span>
                </div>
                <p class="text-3xl font-bold mb-1">{{ number_format($yearlyTotal, 2) }}</p>
                <p class="text-sm opacity-90">kg CO₂ este año</p>
            </div>

            <!-- Total Registros -->
            <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-database text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Total</span>
                </div>
                <p class="text-3xl font-bold mb-1">{{ number_format($totalConsumptions) }}</p>
                <p class="text-sm opacity-90">registros en el sistema</p>
            </div>
        </div>

        @if($unitsWithoutReportToday->isNotEmpty() || $pendingRequestsCount > 0)
        <!-- Alertas -->
        <div class="space-y-4 mb-8">
            @if($unitsWithoutReportToday->isNotEmpty())
            <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg p-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-amber-600 text-2xl mr-3 mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-amber-900 mb-2">Unidades que no reportaron hoy</h4>
                        <p class="text-sm text-amber-800 mb-2">Las siguientes unidades con líder asignado no tienen ningún consumo registrado para el día de hoy:</p>
                        <ul class="flex flex-wrap gap-2 mb-3">
                            @foreach($unitsWithoutReportToday as $u)
                            <li class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                {{ $u->name }}
                            </li>
                            @endforeach
                        </ul>
                        <p class="text-xs text-amber-700">El registro es diario. Los líderes pueden solicitar agregar consumos de días anteriores desde su panel (requiere tu aprobación).</p>
                    </div>
                </div>
            </div>
            @endif
            @if($pendingRequestsCount > 0)
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-paper-plane text-blue-600 text-2xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-900">Solicitudes de registro pendientes</h4>
                            <p class="text-sm text-blue-800">{{ $pendingRequestsCount }} solicitud(es) de líderes para agregar consumos en fechas pasadas</p>
                        </div>
                    </div>
                    <a href="{{ route('cefa.huellacarbono.superadmin.requests.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        <i class="fas fa-check-double mr-2"></i>Revisar solicitudes
                    </a>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Unidades Productivas -->
            <a href="{{ route('cefa.huellacarbono.superadmin.units.index') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-industry text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Unidades Productivas</h3>
                        <p class="text-sm text-gray-500">{{ $activeUnits }}/{{ $totalUnits }} activas</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Gestionar unidades y líderes</p>
            </a>

            <!-- Factores de Emisión -->
            <a href="{{ route('cefa.huellacarbono.superadmin.factors.index') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-flask text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Factores de Emisión</h3>
                        <p class="text-sm text-gray-500">{{ $totalFactors }} factores</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Configurar variables de cálculo</p>
            </a>

            <!-- Gráficas -->
            <a href="{{ route('cefa.huellacarbono.superadmin.charts.index') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-chart-bar text-2xl text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Gráficas</h3>
                        <p class="text-sm text-gray-500">Análisis visual</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Tendencias y comparaciones</p>
            </a>
            
            <!-- Reportes -->
            <a href="{{ route('cefa.huellacarbono.superadmin.reports.index') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-file-pdf text-2xl text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Reportes</h3>
                        <p class="text-sm text-gray-500">Exportar PDF/Excel</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Generar informes personalizados</p>
            </a>
        </div>

        <!-- Últimos Registros (sincronizados por actividad: nuevos y modificaciones) -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-clock text-blue-600 mr-2"></i>
                    Últimos Registros
                </h2>
                <a href="{{ route('cefa.huellacarbono.superadmin.consumptions.index') }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium">
                    Ver todos →
                </a>
            </div>
            <p class="text-xs text-gray-500 mb-3">Consumos recientes de todas las unidades (ordenados por actividad)</p>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Unidad</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Factor</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Cantidad</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">CO₂</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentConsumptions as $consumption)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $consumption->consumption_date->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $consumption->productiveUnit->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $consumption->emissionFactor->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right text-gray-900">
                                {{ $consumption->quantity }} {{ $consumption->emissionFactor->unit ?? '' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right font-semibold text-green-600">
                                {{ number_format($consumption->co2_generated, 3) }} kg
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $consumption->registeredBy->nickname ?? 'N/A' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                <p>No hay registros aún</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

