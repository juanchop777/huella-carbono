<!-- jQuery (necesario para algunas funcionalidades) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 para alertas modernas -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Notificaciones Toast (estilo único para todas las alertas) -->
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    // Función global: todas las notificaciones (éxito, error, info) usan el mismo toast
    window.showToast = function(type, message) {
        Toast.fire({
            icon: type,
            title: message
        });
    };

    // Confirmaciones (mismo estilo en todo el módulo): título, botones y colores unificados
    window.showConfirm = function(options) {
        return Swal.fire({
            title: options.title || '¿Estás seguro?',
            text: options.text || '',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.danger ? '#ef4444' : '#0d9488',
            cancelButtonColor: '#64748b',
            confirmButtonText: options.confirmText || 'Sí',
            cancelButtonText: options.cancelText || 'Cancelar'
        });
    };

    // Manejar mensajes de sesión
    @if (Session::get('message'))
        @if (Session::get('icon') == 'success')
            showToast('success', "{{ Session::get('message') }}");
        @elseif (Session::get('icon') == 'error')
            showToast('error', "{{ Session::get('message') }}");
        @endif
    @endif

    // Bloqueo global de botones en el módulo (admin, líder, público): al iniciar una tarea (fetch o jQuery AJAX) se deshabilitan el resto hasta que termine
    (function() {
        var busyCount = 0;
        function setBusy(delta) {
            busyCount = Math.max(0, busyCount + delta);
            document.body.classList.toggle('global-busy', busyCount > 0);
        }
        $(document).ajaxSend(function() { setBusy(1); });
        $(document).ajaxComplete(function() { setBusy(-1); });
        var origFetch = window.fetch;
        if (typeof origFetch === 'function') {
            window.fetch = function() {
                setBusy(1);
                return origFetch.apply(this, arguments).finally(function() { setBusy(-1); });
            };
        }
    })();
</script>

