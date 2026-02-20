@extends('huellacarbono::layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <i class="fas fa-clipboard-list text-green-600"></i> Todos los Consumos
            </h1>
            <p class="text-gray-600">Visualización y edición de todos los registros del sistema</p>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-filter text-blue-600 mr-2"></i>
                Filtros de Búsqueda
            </h3>
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unidad Productiva</label>
                    <select name="unit_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">Todas</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           min="{{ $dateMin }}" max="{{ $dateMax }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                           title="Solo hay registros entre {{ $dateMin }} y {{ $dateMax }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           min="{{ $dateMin }}" max="{{ $dateMax }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                           title="Solo hay registros entre {{ $dateMin }} y {{ $dateMax }}">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de Consumos -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">
                    <i class="fas fa-database mr-2"></i> Registros de Consumo
                </h3>
                <span class="bg-white/20 px-4 py-2 rounded-lg text-white font-semibold">
                    {{ $consumptions->total() }} registros
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Unidad</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Factor</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Cantidad</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">CO₂ (kg)</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Registrado por</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($consumptions as $consumption)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                <div class="flex flex-col gap-1">
                                    <span>{{ $consumption->consumption_date->format('d/m/Y') }}</span>
                                    @if($consumption->isDelayFromAdminApproval())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800" title="Registro agregado en fecha distinta con permiso del Admin">
                                        <i class="fas fa-clock mr-1"></i> Retraso
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $consumption->productiveUnit->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $consumption->emissionFactor->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-right text-gray-900">
                                {{ $consumption->quantity }} {{ $consumption->emissionFactor->unit ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-right">
                                <span class="font-bold text-green-600">
                                    {{ number_format($consumption->co2_generated, 3) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-user-circle text-gray-400 mr-1"></i>
                                {{ $consumption->registeredBy->nickname ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <button type="button" onclick="openEditConsumptionModal({{ $consumption->id }}, this)" 
                                            class="text-blue-600 hover:text-blue-800 transition disabled:opacity-50 disabled:pointer-events-none"
                                            title="Editar">
                                        <i class="fas fa-edit text-lg"></i>
                                    </button>
                                    <button type="button" onclick="deleteConsumption({{ $consumption->id }}, this)" 
                                            class="text-slate-600 hover:text-slate-800 transition disabled:opacity-50 disabled:pointer-events-none"
                                            title="Eliminar">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg">No hay registros con los filtros aplicados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $consumptions->withQueryString()->links('huellacarbono::pagination.tailwind') }}
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="mt-8">
            <a href="{{ route('cefa.huellacarbono.admin.dashboard') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Modal Editar Consumo -->
<div id="editConsumptionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">
                <i class="fas fa-edit text-teal-600 mr-2"></i> Editar Registro
            </h3>
            <button type="button" onclick="closeEditConsumptionModal()" class="text-gray-400 hover:text-gray-600 p-1">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="editConsumptionForm" class="p-6">
            <input type="hidden" id="edit_consumption_id" name="id">
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600"><strong>Unidad:</strong> <span id="edit_unit_name"></span></p>
                <p class="text-sm text-gray-600 mt-1"><strong>Fecha:</strong> <span id="edit_date_display"></span></p>
                <p class="text-sm text-gray-600 mt-1"><strong>Variable:</strong> <span id="edit_factor_name"></span> <span id="edit_factor_unit" class="text-gray-500"></span></p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad <span id="edit_quantity_unit" class="text-green-600 font-semibold"></span></label>
                <input type="number" name="quantity" id="edit_quantity" step="0.001" min="0.001" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <div id="edit_nitrogen_wrap" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Porcentaje de Nitrógeno (%)</label>
                <input type="number" name="nitrogen_percentage" id="edit_nitrogen_percentage" step="0.01" min="0" max="100"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                <textarea name="observations" id="edit_observations" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white px-4 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-save mr-2"></i> Guardar
                </button>
                <button type="button" onclick="closeEditConsumptionModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
function deleteConsumption(id, btn) {
    showConfirm({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer. El registro se eliminará.',
        danger: true,
        confirmText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed && btn && !btn.disabled) {
            btn.disabled = true;
            btn.title = 'Eliminando...';
            fetch(`/huellacarbono/admin/consumos/${id}/eliminar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showToast('success', 'Registro eliminado');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    btn.disabled = false;
                    btn.title = 'Eliminar';
                }
            })
            .catch(function() { btn.disabled = false; btn.title = 'Eliminar'; });
        }
    });
}

function openEditConsumptionModal(id, btn) {
    if (btn && btn.disabled) return;
    if (btn) { btn.disabled = true; btn.title = 'Cargando...'; }
    fetch(`/huellacarbono/admin/consumos/${id}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (btn) { btn.disabled = false; btn.title = 'Editar'; }
        document.getElementById('edit_consumption_id').value = data.id;
        document.getElementById('edit_unit_name').textContent = data.productive_unit?.name || 'N/A';
        document.getElementById('edit_date_display').textContent = data.consumption_date;
        document.getElementById('edit_factor_name').textContent = data.emission_factor?.name || 'N/A';
        document.getElementById('edit_factor_unit').textContent = data.emission_factor?.unit ? '(' + data.emission_factor.unit + ')' : '';
        document.getElementById('edit_quantity_unit').textContent = data.emission_factor?.unit ? '(' + data.emission_factor.unit + ')' : '';
        document.getElementById('edit_quantity').value = data.quantity ?? '';
        document.getElementById('edit_observations').value = data.observations ?? '';
        var nitrogenWrap = document.getElementById('edit_nitrogen_wrap');
        var nitrogenInput = document.getElementById('edit_nitrogen_percentage');
        if (data.emission_factor?.requires_percentage) {
            nitrogenWrap.classList.remove('hidden');
            nitrogenInput.value = data.nitrogen_percentage != null ? data.nitrogen_percentage : '';
            nitrogenInput.removeAttribute('required');
        } else {
            nitrogenWrap.classList.add('hidden');
            nitrogenInput.value = '';
        }
        document.getElementById('editConsumptionModal').classList.remove('hidden');
    })
    .catch(function() {
        if (btn) { btn.disabled = false; btn.title = 'Editar'; }
        showToast('error', 'No se pudo cargar el registro');
    });
}

function closeEditConsumptionModal() {
    document.getElementById('editConsumptionModal').classList.add('hidden');
}

document.getElementById('editConsumptionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = this.querySelector('button[type=submit]');
    if (btn.disabled) return;
    var id = document.getElementById('edit_consumption_id').value;
    var payload = {
        quantity: parseFloat(document.getElementById('edit_quantity').value) || 0,
        observations: document.getElementById('edit_observations').value || '',
        _token: '{{ csrf_token() }}'
    };
    var nitrogenInput = document.getElementById('edit_nitrogen_percentage');
    if (!document.getElementById('edit_nitrogen_wrap').classList.contains('hidden')) {
        var v = nitrogenInput.value;
        payload.nitrogen_percentage = (v !== '' && v !== null) ? parseFloat(v) : null;
    }
    var origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Guardando...';
    fetch(`/huellacarbono/admin/consumos/${id}/editar`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            closeEditConsumptionModal();
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            btn.disabled = false;
            btn.innerHTML = origHtml;
            const msg = data.errors ? Object.values(data.errors).flat()[0] : (data.message || 'Error al actualizar');
            showToast('error', msg);
        }
    })
    .catch(function() {
        btn.disabled = false;
        btn.innerHTML = origHtml;
        showToast('error', 'Error al actualizar el registro');
    });
});
</script>
@endsection

