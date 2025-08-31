@php
// Ensure $service is available when a single item is passed as a collection.
// Controller may pass either $service or $services (collection). Normalize here.
$service = $service ?? (
    (isset($services) && (is_countable($services) ? count($services) : (is_iterable($services) ? iterator_count($services) : 0)) === 1)
        ? (is_iterable($services) ? collect($services)->first() : null)
        : null
);
\Carbon\Carbon::setLocale('id');
@endphp

@if($service)
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Service Report #{{ $service->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 30px;
            line-height: 1.6;
        }

        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1f2937;
        }
        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .header .meta {
            float: right;
            text-align: right;
            margin-top: -50px;
        }
        .service-id {
            font-size: 18px;
            font-weight: 700;
            color: #2563eb;
        }
        .service-date {
            color: #6b7280;
            font-size: 14px;
            margin-top: 2px;
        }

        .vehicle-section {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #2563eb;
        }
        .vehicle-name {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .license-plate {
            background: #1f2937;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 700;
            display: inline-block;
            letter-spacing: 1px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-table td:first-child {
            width: 150px;
            font-weight: 600;
            color: #374151;
        }
        .info-table td:last-child {
            color: #1f2937;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge.green { background: #dcfce7; color: #166534; }
        .badge.red { background: #fee2e2; color: #991b1b; }
        .badge.blue { background: #dbeafe; color: #1e40af; }
        .badge.yellow { background: #fef3c7; color: #92400e; }

        .section {
            margin-bottom: 20px;
            padding: 15px 0;
            border-top: 1px solid #e5e7eb;
        }
        .section:first-of-type {
            border-top: none;
        }
        .section-title {
            font-weight: 700;
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
        }
        .section-content {
            color: #4b5563;
            font-size: 13px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Service Kendaraan</h1>
        <p class="subtitle">Laporan service dan pemeliharaan kendaraan</p>
        <div class="meta">
            <div class="service-id">#{{ $service->id }}</div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="vehicle-section">
        <div class="vehicle-name">{{ $service->brand ?? ($service->vehicle?->brand ?? '-') }} {{ $service->model ?? ($service->vehicle?->model ?? '-') }}</div>
        <div class="license-plate">{{ $service->license_plate ?? ($service->vehicle?->license_plate ?? '-') }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td>Jenis Servis</td>
            <td>
                @php
                    $serviceTypeLabels = [
                        'service_rutin' => 'Service Rutin',
                        'kerusakan' => 'Kerusakan',
                        'perbaikan' => 'Perbaikan',
                        'penggantian_part' => 'Penggantian Part'
                    ];
                    $serviceTypeColors = [
                        'service_rutin' => 'green',
                        'kerusakan' => 'red',
                        'perbaikan' => 'yellow',
                        'penggantian_part' => 'blue'
                    ];
                    $stype = $service->service_type;
                @endphp
                <span class="badge {{ $serviceTypeColors[$stype] ?? 'blue' }}">{{ $serviceTypeLabels[$stype] ?? ($stype ?: '-') }}</span>
            </td>
        </tr>
        <tr>
            <td>Jenis Pembayaran</td>
            <td>
                @php $paymentTypeLabels = [ 'asuransi' => 'Asuransi', 'kantor' => 'Pembayaran Kantor' ]; @endphp
                <span class="badge blue">{{ $paymentTypeLabels[$service->payment_type] ?? ($service->payment_type ? ucfirst(str_replace('_', ' ', $service->payment_type)) : '-') }}</span>
            </td>
        </tr>
    </table>

    @if($service->description)
    <div class="section">
        <div class="section-title">Deskripsi</div>
        <div class="section-content">{{ $service->description }}</div>
    </div>
    @endif

    @if($service->damage_description)
    <div class="section">
        <div class="section-title">Kerusakan</div>
        <div class="section-content">{{ $service->damage_description }}</div>
    </div>
    @endif

    @if($service->repair_description)
    <div class="section">
        <div class="section-title">Perbaikan</div>
        <div class="section-content">{{ $service->repair_description }}</div>
    </div>
    @endif

    @if($service->parts_replaced)
    <div class="section">
        <div class="section-title">Part yang Diganti</div>
        <div class="section-content">{{ $service->parts_replaced }}</div>
    </div>
    @endif

    <div class="footer">
        Dihasilkan: {{ now()->translatedFormat('d F Y') }}
    </div>
</body>
</html>

@elseif(isset($services))
    <!doctype html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Riwayat Servis Kendaraan</title>
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
                color: #1f2937;
                margin: 0;
                padding: 25px;
                line-height: 1.5;
            }

            .header {
                border-bottom: 3px solid #2563eb;
                padding-bottom: 20px;
                margin-bottom: 25px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 22px;
                color: #1f2937;
            }
            .header .subtitle {
                color: #6b7280;
                font-size: 14px;
                margin: 8px 0;
            }
            .header .generated {
                color: #9ca3af;
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 11px;
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }

            th {
                background: #f8fafc;
                padding: 12px 8px;
                text-align: left;
                font-weight: 700;
                color: #374151;
                border-bottom: 2px solid #e5e7eb;
                font-size: 11px;
            }

            td {
                padding: 10px 8px;
                border-bottom: 1px solid #f3f4f6;
                vertical-align: top;
            }

            tbody tr:nth-child(even) {
                background: #f9fafb;
            }

            .license-plate {
                background: #1f2937;
                color: white;
                padding: 3px 6px;
                border-radius: 3px;
                font-weight: 700;
                font-size: 10px;
                letter-spacing: 1px;
            }

            .service-type {
                padding: 3px 8px;
                border-radius: 12px;
                font-size: 10px;
                font-weight: 600;
            }
            .service-rutin { background: #dcfce7; color: #166534; }
            .kerusakan { background: #fee2e2; color: #991b1b; }
            .perbaikan { background: #fef3c7; color: #92400e; }
            .penggantian_part { background: #dbeafe; color: #1e40af; }

            .payment-type {
                padding: 3px 8px;
                border-radius: 12px;
                font-size: 10px;
                font-weight: 500;
                background: #e0e7ff;
                color: #3730a3;
            }

            .footer {
                margin-top: 25px;
                text-align: center;
                color: #9ca3af;
                font-size: 11px;
                padding-top: 15px;
                border-top: 1px solid #e5e7eb;
            }

            .text-center { text-align: center; }
            .font-bold { font-weight: 700; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Riwayat Servis Kendaraan</h1>
            <p class="subtitle">Laporan riwayat service dan pemeliharaan</p>
            <p class="generated">Generated: {{ now()->translatedFormat('d F Y') }} WIB</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:25px;">No</th>
                    <th style="width:80px;">Kendaraan</th>
                    <th style="width:60px;">Plat</th>
                    <th style="width:70px;">Tanggal</th>
                    <th style="width:80px;">Jenis Servis</th>
                    <th style="width:80px;">Pembayaran</th>
                    <th style="width:80px;">Bengkel</th>
                    <th style="width:80px;">Parts</th>
                    <th style="width:70px;">Petugas</th>
                    <th style="width:200px;">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($services as $i => $s)
                @php
                    $vehicleName = trim(($s->vehicle?->brand ?? $s->brand ?? '') . ' ' . ($s->vehicle?->model ?? $s->model ?? '')) ?: '-';
                    $license = $s->vehicle?->license_plate ?? $s->license_plate ?? '-';
                @endphp
                <tr>
                    <td class="text-center font-bold">{{ $i + 1 }}</td>
                    <td>{{ $vehicleName }}</td>
                    <td class="text-center">
                        @if($license !== '-')
                            <span class="license-plate">{{ $license }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $s->service_date?->translatedFormat('d F Y') ?? '-' }}</td>
                    <td>
                        @if($s->service_type)
                            <span class="service-type {{ $s->service_type }}">{{ ucfirst(str_replace('_', ' ', $s->service_type)) }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($s->payment_type)
                            <span class="payment-type">{{ ucfirst(str_replace('_', ' ', $s->payment_type)) }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $s->garage_name ?? '-' }}</td>
                    <td>{{ $s->parts_replaced ?? '-' }}</td>
                    <td>{{ $s->user?->name ?? '-' }}</td>
                    <td>{{ $s->description ?? ($s->damage_description ?? '-') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="footer">
            Sistem Manajemen Kendaraan - {{ now()->translatedFormat('d F Y') }} WIB
        </div>
    </body>
    </html>

@else
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Service Report</title>
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
                background: #f9fafb;
            }
            .message {
                text-align: center;
                padding: 40px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
        </style>
    </head>
    <body>
        <div class="message">
            <h2>No Service Data</h2>
            <p>Tidak ada data service yang tersedia.</p>
        </div>
    </body>
    </html>
@endif
