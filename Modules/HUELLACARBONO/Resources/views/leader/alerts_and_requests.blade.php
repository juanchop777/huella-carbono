@extends('huellacarbono::layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <i class="fas fa-bell text-amber-600"></i> Alertas
            </h1>
            <p class="text-gray-600">Días sin reporte de consumo y estado de tus solicitudes al Admin.</p>
        </div>

        @if(count($daysWithoutReport) > 0)
        <!-- Alerta: días sin reporte -->
        <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-amber-600 text-2xl mr-3 mt-0.5"></i>
                <div class="flex-1">
                    <h4 class="font-semibold text-amber-900 mb-2">No se reportó consumo en los siguientes días</h4>
                    <p class="text-sm text-amber-800 mb-3">
                        El registro es diario. Los siguientes días no tienen ningún consumo registrado para tu unidad:
                    </p>
                    <ul class="flex flex-wrap gap-2 mb-4">
                        @foreach($daysWithoutReport as $date)
                        <li class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                            {{ $date->format('d/m/Y') }}
                        </li>
                        @endforeach
                    </ul>
                    <p class="text-sm text-amber-800 mb-2">
                        Para agregar consumos en esas fechas debes <strong>solicitar aprobación del Admin</strong>.
                    </p>
                    <a href="{{ route('cefa.huellacarbono.leader.request_form') }}" 
                       class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>Solicitar registro para fecha no reportada
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-600 text-2xl mr-3 mt-0.5"></i>
                <div>
                    <h4 class="font-semibold text-green-900 mb-1">Al día con los reportes</h4>
                    <p class="text-sm text-green-800">En los últimos 7 días tu unidad tiene consumo registrado.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Estado de tus solicitudes -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">
                    <i class="fas fa-paper-plane mr-2"></i> Estado de tus solicitudes de registro
                </h3>
                <a href="{{ route('cefa.huellacarbono.leader.request_form') }}" class="text-white/90 hover:text-white text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i> Nueva solicitud
                </a>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-600 text-sm mb-4">Aquí ves si el Admin <strong>aceptó</strong> o <strong>rechazó</strong> cada solicitud que enviaste para agregar consumos en fechas pasadas.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Fecha solicitud</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Fecha a reportar</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Variables</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Respuesta del Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($myRequests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $req->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $req->consumption_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @foreach($req->items as $item)
                                <span class="block">{{ $item->emissionFactor->name ?? 'N/A' }}: {{ $item->quantity }} {{ $item->emissionFactor->unit ?? '' }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($req->status === 'approved')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i> Aceptada
                                </span>
                                <p class="text-xs text-gray-500 mt-1">El Admin aprobó tu solicitud</p>
                                @elseif($req->status === 'rejected')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-2"></i> Rechazada
                                </span>
                                <p class="text-xs text-gray-500 mt-1">El Admin rechazó tu solicitud</p>
                                @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-amber-100 text-amber-800">
                                    <i class="fas fa-clock mr-2"></i> Pendiente
                                </span>
                                <p class="text-xs text-gray-500 mt-1">En espera de revisión</p>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p>Aún no has enviado solicitudes de registro.</p>
                                <p class="text-sm mt-1">Si necesitas agregar consumos de días anteriores, envía una solicitud para que el Admin la apruebe.</p>
                                <a href="{{ route('cefa.huellacarbono.leader.request_form') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition">
                                    <i class="fas fa-paper-plane mr-2"></i> Solicitar registro
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('cefa.huellacarbono.leader.dashboard') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
        </a>
    </div>
</div>
@endsection
