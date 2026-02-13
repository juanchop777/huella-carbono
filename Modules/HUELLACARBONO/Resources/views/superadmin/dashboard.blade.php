@extends('huellacarbono::layouts.master')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header con acento ambiental -->
        <div class="mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-sm font-semibold mb-4">
                <i class="fas fa-leaf"></i>
                <span>Panel Administrador</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-2">
                Huella de Carbono
            </h1>
            <p class="text-slate-600 text-lg max-w-2xl">Resumen y acceso rápido a la gestión del módulo.</p>
        </div>

        <!-- Stats Cards (paleta ambiental) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
            <!-- CO2 Semanal -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-calendar-week text-2xl"></i>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-90">Semana</span>
                    </div>
                    <p class="text-3xl font-bold tabular-nums">{{ number_format($weeklyTotal, 2) }}</p>
                    <p class="text-sm opacity-90 mt-1">kg CO₂</p>
                </div>
            </div>

            <!-- CO2 Mensual -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-90">Mes</span>
                    </div>
                    <p class="text-3xl font-bold tabular-nums">{{ number_format($monthlyTotal, 2) }}</p>
                    <p class="text-sm opacity-90 mt-1">kg CO₂</p>
                </div>
            </div>

            <!-- CO2 Anual -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-br from-green-600 to-emerald-700 p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-calendar text-2xl"></i>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-90">Año</span>
                    </div>
                    <p class="text-3xl font-bold tabular-nums">{{ number_format($yearlyTotal, 2) }}</p>
                    <p class="text-sm opacity-90 mt-1">kg CO₂</p>
                </div>
            </div>

            <!-- Total Registros -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-br from-sky-500 to-teal-600 p-6 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-database text-2xl"></i>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-90">Registros</span>
                    </div>
                    <p class="text-3xl font-bold tabular-nums">{{ number_format($totalConsumptions) }}</p>
                    <p class="text-sm opacity-90 mt-1">en el sistema</p>
                </div>
            </div>
        </div>

        @if($unitsWithoutReportToday->isNotEmpty() || $pendingRequestsCount > 0)
        <!-- Alertas -->
        <div class="space-y-4 mb-10">
            @if($unitsWithoutReportToday->isNotEmpty())
            <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-exclamation-triangle text-amber-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-amber-900 mb-1">Unidades sin reporte hoy</h4>
                        <p class="text-sm text-amber-800 mb-3">No hay consumo registrado para el día de hoy en:</p>
                        <ul class="flex flex-wrap gap-2 mb-2">
                            @foreach($unitsWithoutReportToday as $u)
                            <li class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-amber-100 text-amber-800">
                                {{ $u->name }}
                            </li>
                            @endforeach
                        </ul>
                        <p class="text-xs text-amber-700">Los líderes pueden solicitar agregar consumos de días anteriores (requiere tu aprobación).</p>
                    </div>
                </div>
            </div>
            @endif
            @if($pendingRequestsCount > 0)
            <div class="bg-teal-50/80 border border-teal-200 rounded-2xl p-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-paper-plane text-teal-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-teal-900">Solicitudes pendientes</h4>
                        <p class="text-sm text-teal-800">{{ $pendingRequestsCount }} solicitud(es) de líderes para fechas pasadas</p>
                    </div>
                </div>
                <a href="{{ route('cefa.huellacarbono.admin.requests.index') }}" 
                   class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl font-semibold transition shadow-md hover:shadow-lg">
                    <i class="fas fa-check-double"></i>
                    Revisar
                </a>
            </div>
            @endif
        </div>
        @endif

        <!-- Accesos rápidos -->
        <div class="mb-10">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Accesos rápidos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('cefa.huellacarbono.admin.units.index') }}" 
                   class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                        <i class="fas fa-industry text-2xl text-emerald-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-emerald-700">Unidades</h3>
                        <p class="text-sm text-slate-500">{{ $activeUnits }}/{{ $totalUnits }} activas · Gestionar líderes</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-emerald-500 transition-colors"></i>
                </a>

                <a href="{{ route('cefa.huellacarbono.admin.factors.index') }}" 
                   class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                        <i class="fas fa-flask text-2xl text-blue-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-blue-700">Factores</h3>
                        <p class="text-sm text-slate-500">{{ $totalFactors }} factores · Variables de cálculo</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-blue-500 transition-colors"></i>
                </a>

                <a href="{{ route('cefa.huellacarbono.admin.consumptions.index') }}" 
                   class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-slate-200 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center group-hover:bg-slate-600 transition-colors">
                        <i class="fas fa-clipboard-list text-2xl text-slate-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900">Consumos</h3>
                        <p class="text-sm text-slate-500">Ver y editar todos los registros</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-slate-500 transition-colors"></i>
                </a>

                <a href="{{ route('cefa.huellacarbono.admin.requests.index') }}" 
                   class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-teal-200 transition-all group {{ $pendingRequestsCount > 0 ? 'ring-2 ring-teal-200' : '' }}">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center group-hover:bg-teal-500 transition-colors relative">
                        <i class="fas fa-paper-plane text-2xl text-teal-600 group-hover:text-white transition-colors"></i>
                        @if($pendingRequestsCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center">{{ $pendingRequestsCount }}</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-teal-700">Solicitudes</h3>
                        <p class="text-sm text-slate-500">Aprobar o rechazar registros en fechas pasadas</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-teal-500 transition-colors"></i>
                </a>

                <a href="{{ route('cefa.huellacarbono.admin.charts.index') }}" 
                   class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-cyan-200 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-100 flex items-center justify-center group-hover:bg-cyan-500 transition-colors">
                        <i class="fas fa-chart-line text-2xl text-cyan-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-cyan-700">Gráficas</h3>
                        <p class="text-sm text-slate-500">Tendencias y comparaciones</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-cyan-500 transition-colors"></i>
                </a>

                <a href="{{ route('cefa.huellacarbono.admin.reports.index') }}" 
                   class="flex items-center gap-4 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-sky-200 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center group-hover:bg-sky-500 transition-colors">
                        <i class="fas fa-file-export text-2xl text-sky-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-sky-700">Reportes</h3>
                        <p class="text-sm text-slate-500">Exportar PDF y Excel</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-sky-500 transition-colors"></i>
                </a>
            </div>
        </div>

        <!-- Últimos registros -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-5 bg-slate-50/80 border-b border-slate-100">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-9 h-9 rounded-xl bg-slate-200 flex items-center justify-center">
                            <i class="fas fa-clock text-slate-600"></i>
                        </span>
                        Últimos registros
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Consumos recientes de todas las unidades</p>
                </div>
                <a href="{{ route('cefa.huellacarbono.admin.consumptions.index') }}" 
                   class="inline-flex items-center gap-2 text-slate-700 hover:text-green-600 font-medium transition">
                    Ver todos
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="px-5 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Fecha</th>
                            <th class="px-5 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Unidad</th>
                            <th class="px-5 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Factor</th>
                            <th class="px-5 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider text-right">Cantidad</th>
                            <th class="px-5 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider text-right">CO₂</th>
                            <th class="px-5 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentConsumptions as $consumption)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-5 py-3.5 text-sm">
                                <div class="flex flex-col gap-1">
                                    <span class="text-slate-900 font-medium">{{ $consumption->consumption_date->format('d/m/Y') }}</span>
                                    @if($consumption->isDelayFromAdminApproval())
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-amber-100 text-amber-800 w-fit" title="Registro agregado con permiso del Admin">
                                        <i class="fas fa-clock"></i> Retraso
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-slate-900">{{ $consumption->productiveUnit->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3.5 text-sm text-slate-600">{{ $consumption->emissionFactor->name ?? 'N/A' }}</td>
                            <td class="px-5 py-3.5 text-sm text-right text-slate-900">{{ $consumption->quantity }} {{ $consumption->emissionFactor->unit ?? '' }}</td>
                            <td class="px-5 py-3.5 text-sm text-right font-semibold text-green-600">{{ number_format($consumption->co2_generated, 3) }} kg</td>
                            <td class="px-5 py-3.5 text-sm text-slate-600">{{ $consumption->registeredBy->nickname ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="inline-flex flex-col items-center text-slate-400">
                                    <span class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-2xl"></i>
                                    </span>
                                    <p class="font-medium text-slate-500">No hay registros aún</p>
                                </div>
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

