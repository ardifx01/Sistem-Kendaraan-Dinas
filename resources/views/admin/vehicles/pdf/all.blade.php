<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan Dinas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 15px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 6px 0 0 0;
            font-size: 13px;
            color: #64748b;
            font-weight: normal;
        }

        .header p {
            margin: 4px 0 0 0;
            font-size: 9px;
            color: #64748b;
        }

        .filters-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8fafc;
            border-left: 4px solid #2563eb;
            border-radius: 4px;
        }

        .filters-info h3 {
            margin: 0 0 8px 0;
            font-size: 11px;
            color: #1e40af;
            font-weight: bold;
        }

        .filters-info p {
            margin: 2px 0;
            font-size: 9px;
            color: #475569;
        }

        .summary {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #eff6ff;
            border-radius: 6px;
            border: 1px solid #bfdbfe;
        }

        .summary h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #1e40af;
            font-weight: bold;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .summary-item {
            text-align: center;
            padding: 6px;
            background-color: white;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }

        .summary-item .number {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            display: block;
        }

        .summary-item .label {
            font-size: 8px;
            color: #64748b;
            margin-top: 2px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background-color: white;
        }

        .table th {
            background-color: #2563eb;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #1d4ed8;
        }

        .table td {
            padding: 6px 4px;
            border: 1px solid #e2e8f0;
            font-size: 9px;
            vertical-align: top;
        }

        .table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .table tr:hover {
            background-color: #f1f5f9;
        }

        .vehicle-photo {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }

        .no-photo {
            width: 35px;
            height: 35px;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 6px;
        }

        .vehicle-name {
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 1px;
            font-size: 9px;
        }

        .vehicle-details {
            color: #64748b;
            font-size: 8px;
        }

        .tax-warning {
            color: #dc2626;
            font-weight: bold;
            font-size: 7px;
        }

        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 8px;
            color: #64748b;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        .no-data h3 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #374151;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                margin: 10px;
                font-size: 9px;
            }
            .header {
                margin-bottom: 15px;
                padding-bottom: 10px;
            }
            .filters-info {
                margin-bottom: 10px;
                padding: 8px;
            }
            .summary {
                margin-bottom: 10px;
                padding: 8px;
            }
            .table th {
                padding: 6px 4px;
                font-size: 8px;
            }
            .table td {
                padding: 4px 3px;
                font-size: 8px;
            }
            .footer {
                margin-top: 10px;
                padding-top: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Data Kendaraan Dinas</h1>
        <h2>Sistem Kendaraan Dinas</h2>
    </div>

    <!-- Filter Information -->
    @if($request && ($request->filled('search') || $request->filled('type')))
    <div class="filters-info">
        <h3>Filter yang Diterapkan:</h3>
        @if($request->filled('search'))
        <p><strong>Pencarian:</strong> "{{ $request->search }}"</p>
        @endif
        @if($request->filled('type'))
        <p><strong>Jenis Kendaraan:</strong> {{ ucfirst($request->type) }}</p>
        @endif
        <p><strong>Tanggal Export:</strong> {{ now()->format('d F Y') }}</p>
    </div>
    @endif

    <!-- Main Table -->
    @if($vehicles->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th width="6%">No</th>
                <th width="10%">Foto</th>
                <th width="26%">Kendaraan</th>
                <th width="14%">Plat Nomor</th>
                <th width="14%">Pajak Kendaraan</th>
                <th width="14%">Driver</th>
                <th width="12%">Pengguna</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $index => $vehicle)
            <tr>
                <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                <td style="text-align: center;">
                    @if($vehicle->photo && \Storage::disk('public')->exists($vehicle->photo))
                        <img src="{{ public_path('storage/' . $vehicle->photo) }}"
                             alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}"
                             class="vehicle-photo">
                    @else
                        <div class="no-photo">
                            NO<br>IMAGE
                        </div>
                    @endif
                </td>
                <td>
                    <div class="vehicle-name">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                    <div class="vehicle-details">
                        <strong>Jenis:</strong> {{ ucfirst($vehicle->type) }}<br>
                        <strong>Tahun:</strong> {{ $vehicle->year }}<br>
                        <strong>Warna:</strong> {{ $vehicle->color }}
                    </div>
                </td>
                <td>
                    <strong>{{ $vehicle->license_plate }}</strong>
                </td>
                <td style="text-align: center;">
                    @if($vehicle->tax_expiry_date)
                        <strong>{{ $vehicle->tax_expiry_date->format('d/m/Y') }}</strong>
                        @if($vehicle->isTaxExpiringSoon())
                            <br><span class="tax-warning">Segera Expired!</span>
                        @endif
                    @else
                        <div style="padding: 8px;">
                            <em style="color: #94a3b8; font-size: 10px;">— Tidak ada data —</em>
                        </div>
                    @endif
                </td>
                <td>
                    @if($vehicle->driver_name)
                        <strong>{{ $vehicle->driver_name }}</strong>
                    @else
                        <div style="text-align: center; padding: 8px;">
                            <em style="color: #94a3b8; font-size: 10px;">— Tidak ada driver —</em>
                        </div>
                    @endif
                </td>
                <td>
                    @if($vehicle->user_name)
                        <strong>{{ $vehicle->user_name }}</strong>
                    @else
                        <div style="text-align: center; padding: 8px;">
                            <em style="color: #94a3b8; font-size: 10px;">— Tidak ada pengguna —</em>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <h3>Tidak Ada Data Kendaraan</h3>
        <p>Tidak ada data kendaraan yang sesuai dengan filter yang diterapkan.</p>
    </div>
    @endif
</body>
</html>
