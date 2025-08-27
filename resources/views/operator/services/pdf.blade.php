<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Servis PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            table-layout: fixed; /* biar kolom rata */
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th { background: #f3f4f6; }
        .muted { color: #6b7280; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Riwayat Servis Kendaraan</div>
        <div class="muted">Generated: {{ now()->format('d M Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:25px">No</th>
                <th style="width:80px">Kendaraan</th>
                <th style="width:70px">Plat</th>
                <th style="width:70px">Tanggal</th>
                <th style="width:70px">Jenis</th>
                <th style="width:80px">Pembayaran</th>
                <th style="width:90px">Bengkel</th>
                <th style="width:80px">Parts</th>
                <th style="width:80px">Pembuat</th>
                <th style="width:200px">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($services as $i => $service)
            @php
                $vehicleName = trim(($service->vehicle?->brand ?? $service->brand ?? '') . ' ' . ($service->vehicle?->model ?? $service->model ?? '')) ?: '-';
                $license = $service->vehicle?->license_plate ?? $service->license_plate ?? '-';
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $vehicleName }}</td>
                <td>{{ $license }}</td>
                <td>{{ $service->service_date?->format('d M Y') ?? '-' }}</td>
                <td>{{ $service->service_type }}</td>
                <td>{{ $service->payment_type ?? '-' }}</td>
                <td>{{ $service->garage_name ?? '-' }}</td>
                <td>{{ $service->parts_replaced ?? '-' }}</td>
                <td>{{ $service->user?->name ?? '-' }}</td>
                <td style="white-space:pre-wrap;">{{ $service->description ?? ($service->damage_description ?? '') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
