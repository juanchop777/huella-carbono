@extends('huellacarbono::layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <i class="fas fa-chart-line text-green-600"></i> Estadísticas de mi Unidad
            </h1>
            <p class="text-gray-600">{{ $unit->name }}</p>
        </div>

        <!-- Resumen CO₂ por período -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar-week text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Semanal</span>
                </div>
                <p class="text-4xl font-bold mb-1">{{ number_format($weeklyTotal, 2) }}</p>
                <p class="text-sm opacity-90">kg CO₂ esta semana</p>
            </div>

            <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar-alt text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Mensual</span>
                </div>
                <p class="text-4xl font-bold mb-1">{{ number_format($monthlyTotal, 2) }}</p>
                <p class="text-sm opacity-90">kg CO₂ este mes</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar text-4xl opacity-80"></i>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Anual</span>
                </div>
                <p class="text-4xl font-bold mb-1">{{ number_format($yearlyTotal, 2) }}</p>
                <p class="text-sm opacity-90">kg CO₂ este año</p>
            </div>
        </div>

        <!-- Equivalente en árboles -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-tree text-green-600 mr-2"></i> Equivalente en árboles
            </h3>
            <p class="text-gray-600 mb-4">
                Un árbol absorbe aproximadamente 22 kg de CO₂ al año. Esta es la cantidad de árboles que se necesitarían para compensar las emisiones de tu unidad:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">{{ number_format($weeklyTotal / 22 * 52, 1) }}</p>
                    <p class="text-sm text-gray-600">árboles/año (proyección semanal)</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ number_format($monthlyTotal / 22 * 12, 1) }}</p>
                    <p class="text-sm text-gray-600">árboles/año (proyección mensual)</p>
                </div>
                <div class="bg-teal-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-teal-700">{{ number_format($yearlyTotal / 22, 1) }}</p>
                    <p class="text-sm text-gray-600">árboles para compensar este año</p>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('cefa.huellacarbono.leader.history') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition flex items-center">
                <div class="bg-teal-100 w-14 h-14 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-history text-2xl text-teal-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Ver Historial</h3>
                    <p class="text-sm text-gray-500">Consulta todos los registros de consumo</p>
                </div>
            </a>
            <a href="{{ route('cefa.huellacarbono.leader.charts') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition flex items-center">
                <div class="bg-green-100 w-14 h-14 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-2xl text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Gráficas</h3>
                    <p class="text-sm text-gray-500">Visualiza tendencias y comparativas</p>
                </div>
            </a>
        </div>

        <!-- Botón Volver -->
        <div class="mt-8">
            <a href="{{ route('cefa.huellacarbono.leader.dashboard') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
