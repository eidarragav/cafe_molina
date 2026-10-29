<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden Pedido Propio #{{ $ownOrder->id }} - Café Molina</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #2b2b2b;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            border-bottom: 2px solid #6f4e37;
            padding-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .company-title {
            font-size: 22px;
            font-weight: bold;
            color: #6f4e37;
            letter-spacing: 1px;
            margin: 0;
        }

        .company-sub {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }

        .doc-badge {
            background-color: #6f4e37;
            color: white;
            padding: 8px 12px;
            text-align: right;
            border-radius: 4px;
        }

        .doc-badge h2 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .doc-badge span {
            font-size: 13px;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .info-box {
            border: 1px solid #e0d5ce;
            background-color: #fbf9f8;
            padding: 8px 10px;
            border-radius: 4px;
        }

        .box-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6f4e37;
            border-bottom: 1px solid #e0d5ce;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .data-table th {
            background-color: #6f4e37;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 6px 8px;
            text-align: left;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e5e5;
            font-size: 10.5px;
        }

        .data-table tr:nth-child(even) td {
            background-color: #faf8f7;
        }

        .data-table tfoot td {
            font-weight: bold;
            background-color: #f0ebe8;
            border-top: 2px solid #6f4e37;
            border-bottom: none;
        }

        .badge-urgent {
            background-color: #d9534f;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }

        .badge-normal {
            background-color: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }

        .signatures-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        .signatures-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 30px;
        }

        .sig-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 4px;
            font-weight: bold;
            font-size: 10px;
        }

        .sig-sub {
            font-size: 9px;
            color: #777;
        }

        .footer-note {
            margin-top: 25px;
            padding: 6px 10px;
            background-color: #f4f6f8;
            font-size: 8.5px;
            color: #666;
            border-radius: 3px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <div class="company-title">CAFÉ MOLINA</div>
                <div class="company-sub">
                    Línea de Cafés Especiales de Origen & Tostión Propia<br>
                    Email: ventas@cafemolina.com • Tel: +57 (6) 745-0000
                </div>
            </td>
            <td style="width: 40%; text-align: right;">
                <div class="doc-badge">
                    <h2>ORDEN PEDIDO PROPIO</h2>
                    <span>N° {{ str_pad($ownOrder->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Info Box: Cliente y Pedido -->
    <table class="info-table">
        <tr>
            <td style="width: 50%; padding-right: 6px; vertical-align: top;">
                <div class="info-box">
                    <div class="box-title">Datos del Destinatario / Cliente</div>
                    <strong>Nombre:</strong> {{ $ownOrder->costumer->name ?? 'N/A' }}<br>
                    <strong>Cédula / NIT:</strong> {{ $ownOrder->costumer->cedula ?? 'N/A' }}<br>
                    <strong>Teléfono:</strong> {{ $ownOrder->costumer->phone ?? 'N/A' }}<br>
                    <strong>Finca / Dirección:</strong> {{ $ownOrder->costumer->farm ?: 'No especificada' }}
                </div>
            </td>
            <td style="width: 50%; padding-left: 6px; vertical-align: top;">
                <div class="info-box">
                    <div class="box-title">Detalles del Despacho</div>
                    <strong>Fecha de Entrada:</strong> {{ $ownOrder->entry_date ? \Carbon\Carbon::parse($ownOrder->entry_date)->format('d/m/Y') : '—' }}<br>
                    <strong>Fecha Est. Salida:</strong> {{ $ownOrder->departure_date ? \Carbon\Carbon::parse($ownOrder->departure_date)->format('d/m/Y') : 'Calculando' }}<br>
                    <strong>Operario Responsable:</strong> {{ $ownOrder->user->name ?? 'N/A' }}<br>
                    <strong>Prioridad:</strong>
                    @if($ownOrder->urgent_order === 'yes')
                        <span class="badge-urgent">URGENTE</span>
                    @else
                        <span class="badge-normal">NORMAL</span>
                    @endif
                    @if($ownOrder->management_criteria === 'yes')
                        <span style="background: #f0ad4e; color:white; padding: 2px 5px; border-radius: 3px; font-size: 9px; font-weight:bold;">CRITERIO GERENCIAL</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Tabla de Productos Solicitados -->
    <div class="box-title">Detalle de Productos & Presentaciones Solicitadas</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">Producto</th>
                <th style="width: 20%;">Tipo</th>
                <th style="width: 15%;">Presentación</th>
                <th style="width: 10%; text-align: center;">Cantidad</th>
                <th style="width: 15%; text-align: right;">Kilos Tostión Est.</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalQty = 0;
                $totalKilos = 0;
            @endphp
            @forelse($ownOrder->own_order_product as $idx => $p)
                @php
                    $qty = (int)($p->quantity ?? 1);
                    $kilos = (float)($p->weight_toast ?? 0);
                    $totalQty += $qty;
                    $totalKilos += $kilos;
                @endphp
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td><strong>{{ optional($p->product)->name ?? 'Producto' }}</strong></td>
                    <td>{{ ucfirst($p->type ?? 'Grano') }}</td>
                    <td>{{ optional($p->weight)->presentation ?? 'Estándar' }}</td>
                    <td style="text-align: center;"><strong>{{ $qty }}</strong></td>
                    <td style="text-align: right;">{{ number_format($kilos, 2) }} kg</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888;">Sin productos registrados</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">TOTALES:</td>
                <td style="text-align: center;">{{ $totalQty }} uds</td>
                <td style="text-align: right; color: #6f4e37;">{{ number_format($totalKilos, 2) }} kg</td>
            </tr>
        </tfoot>
    </table>

    <!-- Tostiones Registradas para este Pedido -->
    @if($ownOrder->toasts->isNotEmpty())
        <div class="box-title" style="margin-top: 15px;">Registro de Batches de Tostión</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Fecha Batch</th>
                    <th>Peso Inicial (Verde)</th>
                    <th>Peso Final (Tostado)</th>
                    <th>Merma</th>
                    <th>% Pérdida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ownOrder->toasts as $t)
                    @php
                        $loss = (float)$t->start_weight > 0 ? round(((float)$t->decrease / (float)$t->start_weight) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format((float)$t->start_weight, 2) }} kg</td>
                        <td>{{ number_format((float)$t->final_weight, 2) }} kg</td>
                        <td style="color: #d9534f;">-{{ number_format((float)$t->decrease, 2) }} kg</td>
                        <td><strong>{{ $loss }}%</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Firmas -->
    <table class="signatures-table">
        <tr>
            <td>
                <div class="sig-line">{{ $ownOrder->user->name ?? 'Despachador' }}</div>
                <div class="sig-sub">Despachador / Planta • Café Molina</div>
            </td>
            <td>
                <div class="sig-line">{{ $ownOrder->costumer->name ?? 'Destinatario' }}</div>
                <div class="sig-sub">Recibido a Conformidad • C.C. / NIT: {{ $ownOrder->costumer->cedula ?? '' }}</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Orden de despacho interna para la línea Café Molina. Generado automáticamente el {{ date('d/m/Y H:i:s') }}.
    </div>

</body>
</html>
