<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Maquila #{{ $order->id }} - Café Molina</title>
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
            border-bottom: 2px solid #556B2F;
            padding-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .company-title {
            font-size: 22px;
            font-weight: bold;
            color: #556B2F;
            letter-spacing: 1px;
            margin: 0;
        }

        .company-sub {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }

        .doc-badge {
            background-color: #556B2F;
            color: white;
            padding: 8px 12px;
            text-align: right;
            border-radius: 4px;
        }

        .doc-badge h2 {
            margin: 0;
            font-size: 15px;
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
            border: 1px solid #dfe4d4;
            background-color: #fafbf9;
            padding: 8px 10px;
            border-radius: 4px;
        }

        .box-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #556B2F;
            border-bottom: 1px solid #dfe4d4;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .data-table th {
            background-color: #556B2F;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 5px 8px;
            text-align: left;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #e5e5e5;
            font-size: 10.5px;
        }

        .data-table tr:nth-child(even) td {
            background-color: #fcfcfc;
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
            margin-top: 35px;
        }

        .signatures-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 30px;
        }

        .sig-line {
            border-top: 1px solid #333;
            margin-top: 45px;
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
                    Planta de Beneficio, Trillado, Curvas de Tostión y Servicios de Maquila<br>
                    Email: info@cafemolina.com • Tel: +57 (6) 745-0000
                </div>
            </td>
            <td style="width: 40%; text-align: right;">
                <div class="doc-badge">
                    <h2>ORDEN DE MAQUILA</h2>
                    <span>N° {{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Info Box: Cliente y Pedido -->
    <table class="info-table">
        <tr>
            <td style="width: 50%; padding-right: 6px; vertical-align: top;">
                <div class="info-box">
                    <div class="box-title">Datos del Caficultor / Cliente</div>
                    <strong>Nombre:</strong> {{ $order->costumer->name ?? 'N/A' }}<br>
                    <strong>Cédula / NIT:</strong> {{ $order->costumer->cedula ?? 'N/A' }}<br>
                    <strong>Teléfono:</strong> {{ $order->costumer->phone ?? 'N/A' }}<br>
                    <strong>Finca / Ubicación:</strong> {{ $order->costumer->farm ?: 'No especificada' }}
                </div>
            </td>
            <td style="width: 50%; padding-left: 6px; vertical-align: top;">
                <div class="info-box">
                    <div class="box-title">Detalles de la Orden</div>
                    <strong>Fecha de Entrada:</strong> {{ $order->entry_date ? \Carbon\Carbon::parse($order->entry_date)->format('d/m/Y') : '—' }}<br>
                    <strong>Fecha Est. Salida:</strong> {{ $order->departure_date ? \Carbon\Carbon::parse($order->departure_date)->format('d/m/Y') : 'Calculando' }}<br>
                    <strong>Operario a Cargo:</strong> {{ $order->user->name ?? 'N/A' }}<br>
                    <strong>Prioridad:</strong> 
                    @if($order->urgent_order === 'yes')
                        <span class="badge-urgent">URGENTE</span>
                    @else
                        <span class="badge-normal">NORMAL</span>
                    @endif
                    @if($order->management_criteria === 'yes')
                        <span style="background: #f0ad4e; color:white; padding: 2px 5px; border-radius: 3px; font-size: 9px; font-weight:bold;">CRITERIO GERENCIAL</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Especificaciones Técnicas del Café Recibido -->
    <div class="box-title" style="margin-top: 10px;">Especificaciones del Café en Recepción</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tipo de Café</th>
                <th>Calidad</th>
                <th>Tostión Deseada</th>
                <th>Kilos Recibidos</th>
                <th>Empaque (Tara)</th>
                <th>Kilos Netos</th>
                <th>Densidad Verde</th>
                <th>Humedad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ ucfirst($order->coffe_type ?: 'Estándar') }}</td>
                <td>{{ $order->quality_type ?: 'N/A' }}</td>
                <td>{{ ucfirst($order->toast_type ?: 'Media') }}</td>
                <td><strong>{{ number_format((float)$order->recieved_kilograms, 2) }} kg</strong></td>
                <td>{{ $order->packaging_quantity }} × {{ ucfirst($order->packaging_type ?: 'Bulto') }}</td>
                <td><strong style="color: #556B2F;">{{ number_format((float)$order->net_weight, 2) }} kg</strong></td>
                <td>{{ $order->green_density ?: '—' }}</td>
                <td>{{ $order->green_humidity ? $order->green_humidity . '%' : '—' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Servicios Solicitados y Clasificación por Mallas -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
        <tr>
            <!-- Servicios -->
            <td style="width: 50%; vertical-align: top; padding-right: 6px;">
                <div class="box-title">Servicios de Maquila Contratados</div>
                <table class="data-table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th style="width: 30%; text-align: center;">Selección</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->maquila_services as $s)
                            <tr>
                                <td>{{ $s->service->service_type ?? 'Servicio' }}</td>
                                <td style="text-align: center;">
                                    @if($s->selection === 'yes')
                                        <strong style="color: #556B2F;">✓ SÍ</strong>
                                    @else
                                        <span style="color: #999;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align: center; color: #888;">Sin servicios seleccionados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>

            <!-- Mallas -->
            <td style="width: 50%; vertical-align: top; padding-left: 6px;">
                <div class="box-title">Clasificación Granulométrica (Mallas)</div>
                <table class="data-table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th>Malla / Tamiz</th>
                            <th style="width: 35%; text-align: right;">Peso Clasificado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->maquila_meshes as $m)
                            <tr>
                                <td>{{ $m->mesh->meshe_type ?? 'Malla' }}</td>
                                <td style="text-align: right;"><strong>{{ number_format((float)$m->weight, 2) }} kg</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align: center; color: #888;">Sin mallas registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- Empaque Final -->
    @if($order->maquila_packages->isNotEmpty())
        <div class="box-title">Especificaciones de Empaque Final</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tipo de Paquete</th>
                    <th>Malla Origen</th>
                    <th>Presentación</th>
                    <th style="text-align: right;">Kilos Asignados</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->maquila_packages as $pkg)
                    <tr>
                        <td>{{ $pkg->package->package_type ?? 'Estándar' }}</td>
                        <td>{{ $pkg->mesh ?: 'Mezcla' }}</td>
                        <td>{{ $pkg->presentation ?: 'N/A' }}g</td>
                        <td style="text-align: right;"><strong>{{ number_format((float)$pkg->kilograms, 2) }} kg</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Tostiones Registradas -->
    @if($order->toasts->isNotEmpty())
        <div class="box-title">Registro de Batches de Tostión & Mermas</div>
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
                @foreach($order->toasts as $t)
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

    <!-- Observaciones -->
    @if(!empty($order->observations))
        <div class="info-box" style="margin-top: 10px;">
            <div class="box-title">Observaciones / Notas Especiales</div>
            {{ $order->observations }}
        </div>
    @endif

    <!-- Firmas -->
    <table class="signatures-table">
        <tr>
            <td>
                <div class="sig-line">{{ $order->user->name ?? 'Operario de Planta' }}</div>
                <div class="sig-sub">Responsable de Planta • Café Molina</div>
            </td>
            <td>
                <div class="sig-line">{{ $order->costumer->name ?? 'Cliente / Caficultor' }}</div>
                <div class="sig-sub">Recibido a Conformidad • C.C. / NIT: {{ $order->costumer->cedula ?? '' }}</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Este documento certifica el procesamiento del lote de café en las instalaciones de Café Molina. Documento interno generado el {{ date('d/m/Y H:i:s') }}.
    </div>

</body>
</html>
