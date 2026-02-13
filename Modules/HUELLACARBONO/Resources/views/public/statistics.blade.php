@extends('huellacarbono::layouts.master')

@section('content')
<!-- Banner título (igual que página principal: imagen de fondo + overlay) -->
<div class="relative overflow-hidden h-[320px] min-h-[320px]">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1600" alt="" class="w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-emerald-900/80"></div>
    </div>
    <div class="absolute inset-0 z-10 flex items-center justify-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 left-0 right-0">
        <div class="text-center text-white">
            <i class="fas fa-chart-line text-7xl mb-6 drop-shadow-lg"></i>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg">Estadísticas del Centro de Formación</h1>
            <p class="text-xl opacity-90 mb-2 drop-shadow-md">Huella de Carbono Generada</p>
            <p class="text-lg opacity-75 drop-shadow-md">{{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Selector de Período -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <label class="text-gray-700 font-semibold">Seleccionar período:</label>
            <select name="period" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>📅 Semanal</option>
                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>📆 Mensual</option>
                <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>🗓️ Anual</option>
            </select>
        </form>
    </div>

    <!-- Total General -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl shadow-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-white/20 w-20 h-20 rounded-2xl flex items-center justify-center mr-6">
                    <i class="fas fa-cloud text-5xl"></i>
                </div>
                <div>
                    <p class="text-lg opacity-90 mb-1">Total CO₂ Generado - {{ ucfirst($period) }}</p>
                    <h2 class="text-5xl font-bold">{{ number_format($totalCO2, 2) }} <span class="text-2xl">kg CO₂</span></h2>
                </div>
            </div>
            <div class="text-right">
                <i class="fas fa-tree text-6xl opacity-50"></i>
                <p class="text-sm mt-2 opacity-90">
                    ≈ {{ number_format($totalCO2 / 22, 1) }} árboles/año
                </p>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- CO2 por Unidad Productiva -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-industry text-teal-600 mr-3"></i>
                CO₂ por Unidad Productiva
            </h3>
            <div class="relative" style="height: 400px;">
                <canvas id="chartByUnit"></canvas>
            </div>
        </div>

        <!-- CO2 por Tipo de Consumo -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-list text-amber-600 mr-3"></i>
                CO₂ por Tipo de Consumo
            </h3>
            <div class="relative" style="height: 400px;">
                <canvas id="chartByType"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabla Detallada -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-teal-600 to-emerald-700 px-6 py-4">
            <h3 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-table mr-3"></i>
                Detalle por Unidad Productiva
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Unidad Productiva
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            CO₂ Generado (kg)
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            % del Total
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Impacto
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($co2ByUnit as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-industry text-teal-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $item->productiveUnit->name ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-lg font-bold text-green-600">
                                {{ number_format($item->total_co2, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @php
                                $percentage = $totalCO2 > 0 ? ($item->total_co2 / $totalCO2) * 100 : 0;
                            @endphp
                            <div class="flex items-center justify-end">
                                <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ number_format($percentage, 1) }}%
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($percentage >= 20)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    Alto
                                </span>
                            @elseif($percentage >= 10)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    Medio
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Bajo
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">No hay datos para el período seleccionado</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                    <tr>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">TOTAL</td>
                        <td class="px-6 py-4 text-right text-xl font-bold text-green-600">
                            {{ number_format($totalCO2, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">100%</td>
                        <td class="px-6 py-4"></td>
                    </tr>
                </tfoot>
            </table>
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Configuración de colores
const colors = [
    'rgba(59, 130, 246, 0.8)',   // blue
    'rgba(16, 185, 129, 0.8)',   // green
    'rgba(251, 146, 60, 0.8)',   // orange
    'rgba(139, 92, 246, 0.8)',   // purple
    'rgba(236, 72, 153, 0.8)',   // pink
    'rgba(234, 179, 8, 0.8)',    // yellow
    'rgba(239, 68, 68, 0.8)',    // red
    'rgba(20, 184, 166, 0.8)',   // teal
    'rgba(168, 85, 247, 0.8)',   // violet
    'rgba(34, 197, 94, 0.8)',    // emerald
];

// Gráfica por Unidad Productiva (dispersión)
@php
    $labelsUnit = $co2ByUnit->map(function ($item) { return $item->productiveUnit->name ?? 'N/A'; })->values()->all();
    $dataUnit = $co2ByUnit->map(function ($item) { return (float) $item->total_co2; })->values()->all();
@endphp
const labelsUnit = @json($labelsUnit);
const dataUnit = @json($dataUnit);
const scatterUnit = labelsUnit.map(function(label, i) { return { x: i, y: dataUnit[i] }; });
const ctxUnit = document.getElementById('chartByUnit').getContext('2d');
new Chart(ctxUnit, {
    type: 'scatter',
    data: {
        datasets: [{
            label: 'CO₂ (kg)',
            data: scatterUnit,
            backgroundColor: scatterUnit.map(function(_, i) { return colors[i % colors.length]; }),
            borderColor: '#374151',
            borderWidth: 1,
            pointRadius: 10,
            pointHoverRadius: 14
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        var idx = context.raw.x;
                        return (labelsUnit[idx] || '') + ': ' + context.parsed.y.toFixed(2) + ' kg CO₂';
                    }
                }
            }
        },
        scales: {
            x: {
                min: -0.5,
                max: Math.max(0, labelsUnit.length - 1) + 0.5,
                ticks: {
                    stepSize: 1,
                    callback: function(value) { return labelsUnit[value] != null ? labelsUnit[value] : value; }
                },
                title: { display: true, text: 'Unidad' }
            },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: { callback: function(value) { return value + ' kg'; } },
                title: { display: true, text: 'kg CO₂' }
            }
        }
    }
});

// Gráfica por Tipo de Consumo
const ctxType = document.getElementById('chartByType').getContext('2d');
new Chart(ctxType, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($co2ByType as $item)
            '{{ $item->emissionFactor->name ?? "N/A" }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($co2ByType as $item)
                {{ $item->total_co2 }},
                @endforeach
            ],
            backgroundColor: colors,
            borderColor: '#fff',
            borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    padding: 15,
                    font: {
                        size: 12
                    },
                    usePointStyle: true,
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        const value = context.parsed;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return context.label + ': ' + value.toFixed(2) + ' kg (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
</script>
@endsection
