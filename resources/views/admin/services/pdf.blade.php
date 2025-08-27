@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Service #{{ $service->id }}</title>
    <style>
        /* General */
        body { font-family: DejaVu Sans, sans-serif; color: #0f172a; margin: 0; padding: 0; }
        .page { width: 100%; padding: 20px 28px; box-sizing: border-box; }

        /* Header */
        .header { display: table; width: 100%; margin-bottom: 14px; }
        .brand { display: table-cell; vertical-align: middle; }
        .meta { display: table-cell; text-align: right; vertical-align: middle; }
        .brand h1 { margin: 0; font-size: 20px; }
        .brand p { margin: 2px 0 0; color: #475569; font-size: 12px; }

        .card { border: 1px solid #e6edf3; padding: 12px; border-radius: 6px; background: #ffffff; }

        /* Info grid */
        .info { width: 100%; margin-top: 10px; margin-bottom: 12px; }
        .info td.label { width: 160px; padding: 8px 6px; font-weight: 700; color: #0f172a; vertical-align: top; }
        .info td.value { padding: 8px 6px; vertical-align: top; color: #0f172a; }

        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge.green { background:#ecfdf5; color:#064e3b; }
        .badge.red { background:#fff1f2; color:#9f1239; }
        .badge.blue { background:#eef2ff; color:#3730a3; }
        .badge.yellow { background:#fffbeb; color:#92400e; }

        .section { margin-top: 12px; }
        .section-title { font-weight: 700; margin-bottom: 6px; font-size: 13px; }
        .muted { color: #64748b; font-size: 12px; }

        ul.docs { margin: 6px 0 0 0; padding-left: 18px; }
        ul.docs li { margin-bottom: 4px; }

        .footer { margin-top: 18px; font-size: 11px; color: #64748b; text-align: right; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="brand">
                <h1>Detail Service Kendaraan (Admin)</h1>
                <p class="muted">Rekam layanan kendaraan dan catatan teknis</p>
            </div>
            <div class="meta">
                <div class="muted">#{{ $service->id }}</div>
                <div class="muted">{{ $service->service_date?->format('d F Y') ?? $service->created_at->format('d F Y') }}</div>
            </div>
        </div>

        <div class="card">
            <table class="info" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="label">Kendaraan</td>
                    <td class="value">{{ $service->license_plate ?? ($service->vehicle?->license_plate ?? '-') }} — {{ $service->brand ?? ($service->vehicle?->brand ?? '-') }} {{ $service->model ?? ($service->vehicle?->model ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Servis</td>
                    <td class="value">
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
                    <td class="label">Jenis Pembayaran</td>
                    <td class="value">
                        @php $paymentTypeLabels = [ 'asuransi' => 'Asuransi', 'kantor' => 'Pembayaran Kantor' ]; @endphp
                        <span class="badge blue">{{ $paymentTypeLabels[$service->payment_type] ?? ($service->payment_type ? ucfirst(str_replace('_', ' ', $service->payment_type)) : '-') }}</span>
                    </td>
                </tr>
            </table>

            <div class="section">
                <div class="section-title">Deskripsi Ringkas</div>
                <div class="small">{{ $service->description ?? '-' }}</div>
            </div>

            @if($service->damage_description)
            <div class="section">
                <div class="section-title">Deskripsi Kerusakan</div>
                <div class="small">{{ $service->damage_description }}</div>
            </div>
            @endif

            @if($service->repair_description)
            <div class="section">
                <div class="section-title">Deskripsi Perbaikan</div>
                <div class="small">{{ $service->repair_description }}</div>
            </div>
            @endif

            @if($service->parts_replaced)
            <div class="section">
                <div class="section-title">Part yang Diganti</div>
                <div class="small">{{ $service->parts_replaced }}</div>
            </div>
            @endif

            <div class="footer">Dihasilkan: {{ now()->format('d F Y H:i') }}</div>
        </div>
    </div>
</body>
</html>
