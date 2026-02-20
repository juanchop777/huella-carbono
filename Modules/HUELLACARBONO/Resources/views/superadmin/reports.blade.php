@extends('huellacarbono::layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <i class="fas fa-file-pdf text-teal-600"></i> Reportes y Exportaciones
            </h1>
            <p class="text-gray-600">Genera y descarga reportes en PDF o Excel</p>
        </div>

        <!-- Opciones de Reporte -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Reporte General -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-teal-100 w-16 h-16 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-file-pdf text-3xl text-teal-600"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Reporte General</h3>
                        <p class="text-sm text-gray-600">PDF con todas las unidades</p>
                    </div>
                </div>
                
                <form id="generalReportForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Período</label>
                        <select name="period" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            <option value="current_month">Mes Actual</option>
                            <option value="last_month">Mes Anterior</option>
                            <option value="current_quarter">Trimestre Actual</option>
                            <option value="last_quarter">Trimestre Anterior</option>
                            <option value="current_year">Año Actual</option>
                            <option value="last_year">Año Anterior</option>
                            <option value="custom">Personalizado</option>
                        </select>
                    </div>
                    
                    <div id="customDates" class="hidden mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                                <input type="date" name="start_date" min="{{ $dateMin }}" max="{{ $dateMax }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" title="Solo hay registros entre {{ $dateMin }} y {{ $dateMax }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                                <input type="date" name="end_date" min="{{ $dateMin }}" max="{{ $dateMax }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" title="Solo hay registros entre {{ $dateMin }} y {{ $dateMax }}">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg">
                        <i class="fas fa-file-pdf mr-2"></i>Generar PDF
                    </button>
                </form>
            </div>

            <!-- Reporte Excel -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 w-16 h-16 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-file-excel text-3xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Reporte Excel</h3>
                        <p class="text-sm text-gray-600">Datos para análisis</p>
                    </div>
                </div>
                
                <form id="excelReportForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Datos</label>
                        <select name="data_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="all_consumptions">Todos los Consumos</option>
                            <option value="by_unit">Por Unidad Productiva</option>
                            <option value="by_factor">Por Factor de Emisión</option>
                            <option value="summary">Resumen Mensual</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Período</label>
                        <select name="period" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="current_year">Año Actual</option>
                            <option value="last_year">Año Anterior</option>
                            <option value="all">Todo el Histórico</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg">
                        <i class="fas fa-file-excel mr-2"></i>Generar Excel
                    </button>
                </form>
            </div>
        </div>

        <!-- Reportes por Unidad -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-industry text-teal-600 mr-3"></i>
                Reporte por Unidad Específica
            </h3>
            
            <form id="unitReportForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidad Productiva</label>
                        <select name="unit_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Seleccione --</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Formato</label>
                        <select name="format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Período</label>
                        <select name="period" id="unitReportPeriod" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="current_month">Mes Actual</option>
                            <option value="last_month">Mes Anterior</option>
                            <option value="current_quarter">Trimestre Actual</option>
                            <option value="last_quarter">Trimestre Anterior</option>
                            <option value="current_year">Año Actual</option>
                            <option value="last_year">Año Anterior</option>
                            <option value="all" selected>Todo el Histórico</option>
                            <option value="custom">Personalizado</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold transition">
                            <i class="fas fa-download mr-2"></i>Descargar
                        </button>
                    </div>
                </div>
                
                <div id="unitCustomDates" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                        <input type="date" name="start_date" min="{{ $dateMin }}" max="{{ $dateMax }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" title="Solo hay registros entre {{ $dateMin }} y {{ $dateMax }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                        <input type="date" name="end_date" min="{{ $dateMin }}" max="{{ $dateMax }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" title="Solo hay registros entre {{ $dateMin }} y {{ $dateMax }}">
                    </div>
                </div>
            </form>
        </div>

        <!-- Estadísticas de Exportaciones -->
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl shadow-xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información de Reportes
                    </h3>
                    <p class="opacity-90">Datos disponibles para exportación</p>
                </div>
                <div class="text-right">
                    <p class="text-5xl font-bold">{{ number_format($totalRecords) }}</p>
                    <p class="text-sm opacity-90">registros totales</p>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-3 gap-4">
                <div class="bg-white/20 rounded-lg p-4">
                    <p class="text-sm opacity-90">Total CO₂</p>
                    <p class="text-2xl font-bold">{{ number_format($totalCO2, 0) }} kg</p>
                </div>
                <div class="bg-white/20 rounded-lg p-4">
                    <p class="text-sm opacity-90">Unidades</p>
                    <p class="text-2xl font-bold">{{ $totalUnits }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-4">
                    <p class="text-sm opacity-90">Período</p>
                    <p class="text-2xl font-bold">2022-2024</p>
                </div>
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
@endsection

@section('script')
<script>
// Mostrar/ocultar fechas personalizadas (Reporte General)
$('#generalReportForm select[name="period"]').on('change', function() {
    if ($(this).val() === 'custom') {
        $('#customDates').removeClass('hidden');
    } else {
        $('#customDates').addClass('hidden');
    }
});

// Mostrar/ocultar fechas personalizadas (Reporte por Unidad)
$('#unitReportPeriod').on('change', function() {
    if ($(this).val() === 'custom') {
        $('#unitCustomDates').removeClass('hidden');
    } else {
        $('#unitCustomDates').addClass('hidden');
    }
});

// Descarga en la misma página: fetch + blob + link, sin abrir otra pestaña
function downloadReportInPage(url, buttonEl, successMessage) {
    var btn = buttonEl && (buttonEl.jquery ? buttonEl[0] : buttonEl);
    var origHtml = btn ? btn.innerHTML : '';
    var origDisabled = btn ? btn.disabled : false;
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generando...';
    }
    if (typeof showToast === 'function') showToast('info', 'Generando reporte... No cierre esta página.');
    fetch(url, { method: 'GET', credentials: 'same-origin' })
        .then(function(res) {
            var ct = (res.headers.get('content-type') || '').toLowerCase();
            if (!res.ok) {
                if (typeof showToast === 'function') showToast('error', 'Error al generar el reporte');
                return;
            }
            if (ct.indexOf('application/pdf') !== -1 || ct.indexOf('application/vnd.openxmlformats') !== -1 || ct.indexOf('application/vnd.ms-excel') !== -1) {
                return res.blob().then(function(blob) {
                    var disp = res.headers.get('content-disposition') || '';
                    var match = disp.match(/filename[*]?=(?:UTF-8'')?["']?([^"'\s]+)["']?/i) || disp.match(/filename=([^;]+)/);
                    var filename = (match && match[1]) ? match[1].trim() : (ct.indexOf('pdf') !== -1 ? 'reporte.pdf' : 'reporte.xlsx');
                    var a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(a.href);
                    if (typeof showToast === 'function') showToast('success', successMessage || 'Descarga iniciada');
                });
            }
            if (typeof showToast === 'function') showToast('warning', 'No hay datos para el período seleccionado');
        })
        .catch(function() {
            if (typeof showToast === 'function') showToast('error', 'Error de conexión al generar el reporte');
        })
        .finally(function() {
            if (btn) {
                btn.disabled = origDisabled;
                btn.innerHTML = origHtml;
            }
        });
}

// Form reporte general PDF
$('#generalReportForm').on('submit', function(e) {
    e.preventDefault();
    var $btn = $(this).find('button[type=submit]');
    if ($btn.prop('disabled')) return;
    var formData = $(this).serialize();
    var url = '{{ url("/huellacarbono/admin/reportes/exportar-pdf") }}?' + formData;
    downloadReportInPage(url, $btn, 'PDF descargado');
});

// Form reporte Excel
$('#excelReportForm').on('submit', function(e) {
    e.preventDefault();
    var $btn = $(this).find('button[type=submit]');
    if ($btn.prop('disabled')) return;
    var formData = $(this).serialize();
    var url = "{{ url('/huellacarbono/admin/reportes/exportar-excel') }}?" + formData;
    downloadReportInPage(url, $btn, 'Excel descargado');
});

// Form reporte por unidad
(function() {
    var form = document.getElementById('unitReportForm');
    if (!form) return;
    var basePdf = "{{ url('/huellacarbono/admin/reportes/exportar-pdf') }}";
    var baseExcel = "{{ url('/huellacarbono/admin/reportes/exportar-excel') }}";
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = form.querySelector('button[type=submit]');
        if (btn && btn.disabled) return;
        var unitSelect = form.querySelector('select[name="unit_id"]');
        var formatSelect = form.querySelector('select[name="format"]');
        var periodSelect = form.querySelector('select[name="period"]');
        var unitId = unitSelect ? unitSelect.value : '';
        var format = formatSelect ? formatSelect.value : 'pdf';
        var period = periodSelect ? periodSelect.value : 'all';
        if (!unitId) {
            if (typeof showToast === 'function') showToast('error', 'Selecciona una unidad productiva');
            return;
        }
        if (period === 'custom') {
            var startInput = form.querySelector('input[name="start_date"]');
            var endInput = form.querySelector('input[name="end_date"]');
            if (!startInput || !endInput || !startInput.value || !endInput.value) {
                if (typeof showToast === 'function') showToast('error', 'Indica las fechas Desde y Hasta para período personalizado');
                return;
            }
        }
        var params = new URLSearchParams({ unit_id: unitId, period: period });
        if (period === 'custom') {
            params.set('start_date', form.querySelector('input[name="start_date"]').value);
            params.set('end_date', form.querySelector('input[name="end_date"]').value);
        }
        var url = (format === 'pdf' ? basePdf : baseExcel) + '?' + params.toString();
        downloadReportInPage(url, btn, (format === 'pdf' ? 'PDF' : 'Excel') + ' descargado');
    });
})();
</script>
@endsection





