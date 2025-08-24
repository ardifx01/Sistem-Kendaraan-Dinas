<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan History Peminjaman Kendaraan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }

        .report-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .report-info p {
            margin: 2px 0;
            font-size: 11px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tr:hover {
            background-color: #e9ecef;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN HISTORY PEMINJAMAN KENDARAAN</h1>
        <h2>Sistem Kendaraan Dinas</h2>
    </div>

    <!-- Report Info -->
    <div class="report-info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y, H:i:s') }}</p>
        @if($request->filled('start_date') || $request->filled('end_date'))
        <p><strong>Periode:</strong>
            @if($request->filled('start_date') && $request->filled('end_date'))
                {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
            @elseif($request->filled('start_date'))
                Mulai {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }}
            @elseif($request->filled('end_date'))
                Sampai {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
            @endif
        </p>
        @endif
        @if($request->filled('vehicle_id'))
        @php
            $vehicle = \App\Models\Vehicle::find($request->vehicle_id);
        @endphp
        <p><strong>Kendaraan:</strong> {{ $vehicle ? $vehicle->brand . ' ' . $vehicle->model . ' - ' . $vehicle->license_plate : 'Tidak ditemukan' }}</p>
        @endif
        @if($request->filled('user_id'))
        @php
            $user = \App\Models\User::find($request->user_id);
        @endphp
        <p><strong>Peminjam:</strong> {{ $user ? $user->name : 'Tidak ditemukan' }}</p>
        @endif
    </div>

    @if($borrowings->count() > 0)
    <!-- Data Table -->
    <table class="table">
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="18%">Tgl Pinjam</th>
                <th width="25%">Peminjam</th>
                <th width="25%">Kendaraan</th>
                <th width="24%">Tujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowings as $index => $borrowing)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $borrowing->start_date ? \Carbon\Carbon::parse($borrowing->start_date)->format('d/m/Y') : '-' }}</td>
                <td>
                    <strong>{{ $borrowing->borrower_name ?? $borrowing->user->name }}</strong><br>
                    <small>
                        @if($borrowing->borrower_contact)
                            {{ $borrowing->borrower_contact }}
                        @elseif($borrowing->user && $borrowing->user->email)
                            {{ $borrowing->user->email }}
                        @else
                            Kontak tidak tersedia
                        @endif
                    </small>
                </td>
                <td>
                    @php
                        $vehiclesData = is_string($borrowing->vehicles_data)
                            ? json_decode($borrowing->vehicles_data, true)
                            : $borrowing->vehicles_data;
                    @endphp
                    
                    @if($vehiclesData && is_array($vehiclesData) && count($vehiclesData) > 0)
                        {{-- Multiple vehicles from vehicles_data --}}
                        @foreach($vehiclesData as $vehicleIndex => $vehicleData)
                            @php
                                // Handle different data structures
                                $vehicleInfo = $vehicleData['vehicle_info'] ?? $vehicleData;
                                $brand = $vehicleInfo['brand'] ?? 'N/A';
                                $model = $vehicleInfo['model'] ?? '';
                                $licensePlate = $vehicleInfo['license_plate'] ?? null;
                            @endphp
                            @if($brand !== 'N/A' && $brand)
                                @if(count($vehiclesData) > 1)
                                    <strong>{{ $vehicleIndex + 1 }}. {{ $brand }} {{ $model }}</strong>
                                @else
                                    <strong>{{ $brand }} {{ $model }}</strong>
                                @endif
                                @if($licensePlate)
                                    <br><small>{{ $licensePlate }}</small>
                                @endif
                                @if(!$loop->last)<br><br>@endif
                            @endif
                        @endforeach
                    @elseif($borrowing->vehicle)
                        {{-- Single vehicle from vehicle relation --}}
                        <strong>{{ $borrowing->vehicle->brand }} {{ $borrowing->vehicle->model }}</strong><br>
                        <small>{{ $borrowing->vehicle->license_plate }}</small>
                    @else
                        <em>Kendaraan tidak tersedia</em>
                    @endif
                </td>
                <td>{{ Str::limit($borrowing->purpose ?? '-', 80) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <h3>Tidak Ada Data</h3>
        <p>Tidak ada data history peminjaman yang sesuai dengan filter yang diterapkan.</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan digenerate pada {{ now()->format('d F Y, H:i:s') }} | Sistem Kendaraan Dinas</p>
    </div>
</body>
</html>
