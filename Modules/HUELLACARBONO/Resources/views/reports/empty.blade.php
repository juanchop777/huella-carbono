<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin datos - Reporte Huella de Carbono</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 2rem 2.5rem;
            max-width: 480px;
            text-align: center;
            border-left: 4px solid #10b981;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 1rem;
            color: #9ca3af;
        }
        h1 {
            font-size: 1.25rem;
            color: #374151;
            margin-bottom: 0.75rem;
        }
        p {
            color: #6b7280;
            margin-bottom: 1.25rem;
        }
        .back {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
        }
        .back:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon" aria-hidden="true">📋</div>
        <h1>Reporte sin datos</h1>
        <p>{{ $message ?? 'No hay datos para el período seleccionado.' }}</p>
        @if(!empty($startDate) && !empty($endDate))
        <p style="margin-top: 0.75rem; font-size: 13px;">Período consultado: <strong>{{ $startDate }}</strong> – <strong>{{ $endDate }}</strong>.</p>
        <p style="font-size: 12px; color: #6b7280; margin-top: 0.5rem;">Prueba seleccionando <strong>«Todo el Histórico»</strong> en el reporte por unidad si tus registros son de años anteriores.</p>
        @endif
        <a href="javascript:window.close()" class="back">Cerrar esta ventana</a>
    </div>
</body>
</html>
