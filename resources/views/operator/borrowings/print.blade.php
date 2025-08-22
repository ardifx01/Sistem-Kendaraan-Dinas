<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman Kendaraan - {{ $borrowing->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        .print-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 20px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 11px;
            color: #9ca3af;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0;
        }

        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-approved { background-color: #dcfce7; color: #166534; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .status-in_use { background-color: #dbeafe; color: #1e40af; }
        .status-returned { background-color: #f3f4f6; color: #374151; }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-section {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
        }

        .info-section h3 {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 12px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            min-width: 120px;
            flex-shrink: 0;
        }

        .info-value {
            color: #1f2937;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }

        /* Vehicle Section */
        .vehicle-section {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .vehicle-section h3 {
            font-size: 14px;
            font-weight: bold;
            color: #0369a1;
            margin-bottom: 12px;
        }

        .vehicle-card {
            background: white;
            border: 1px solid #e0e7ff;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .vehicle-card:last-child {
            margin-bottom: 0;
        }

        .vehicle-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .vehicle-title {
            font-weight: bold;
            color: #1e40af;
            font-size: 13px;
        }

        .vehicle-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        /* Destination */
        .destination-card {
            background: linear-gradient(135deg, #f3e8ff 0%, #ddd6fe 100%);
            border: 1px solid #c4b5fd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .destination-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .destination-icon {
            width: 24px;
            height: 24px;
            background: #8b5cf6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
            font-size: 12px;
        }

        .destination-title {
            font-weight: bold;
            color: #5b21b6;
        }

        .destination-content {
            color: #6b21a8;
            font-weight: 500;
        }

        /* Purpose Section */
        .purpose-section {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .purpose-section h3 {
            font-size: 14px;
            font-weight: bold;
            color: #15803d;
            margin-bottom: 8px;
        }

        .purpose-text {
            color: #166534;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
        }

        .footer-info {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }

        .signature-box {
            text-align: center;
            padding: 15px;
        }

        .signature-title {
            font-weight: bold;
            color: #374151;
            margin-bottom: 40px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 11px;
            color: #6b7280;
        }

        /* Print styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .print-container {
                max-width: none;
                margin: 0;
                padding: 15px;
            }

            .info-grid {
                page-break-inside: avoid;
            }

            .vehicle-section {
                page-break-inside: avoid;
            }

            @page {
                margin: 15mm;
                size: A4;
            }
        }

        /* Utility classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Header -->
        <div class="header">
            <h2>Detail Peminjaman Kendaraan</h2>
            <p>Nomor Peminjaman: #{{ str_pad($borrowing->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Main Information Grid -->
        <div class="info-grid">
            <!-- Peminjam Information -->
            <div class="info-section">
                <h3>🧑‍💼 Informasi Peminjam</h3>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value font-bold">{{ $borrowing->borrower_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipe:</span>
                    <span class="info-value">{{ $borrowing->borrower_type == 'internal' ? 'Internal (Pegawai)' : 'Eksternal (Tamu)' }}</span>
                </div>
                @if($borrowing->borrower_type == 'internal' && $borrowing->borrower_nip)
                <div class="info-row">
                    <span class="info-label">NIP:</span>
                    <span class="info-value">{{ $borrowing->borrower_nip }}</span>
                </div>
                @endif
                @if($borrowing->borrower_type == 'eksternal' && $borrowing->borrower_institution)
                <div class="info-row">
                    <span class="info-label">Instansi:</span>
                    <span class="info-value">{{ $borrowing->borrower_institution }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Kontak:</span>
                    <span class="info-value">{{ $borrowing->borrower_contact }}</span>
                </div>
            </div>

            <!-- Period Information -->
            <div class="info-section">
                <h3>📅 Periode & Lokasi</h3>
                <div class="info-row">
                    <span class="info-label">Tanggal Mulai:</span>
                    <span class="info-value font-bold">{{ $borrowing->start_date->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Selesai:</span>
                    <span class="info-value font-bold">{{ $borrowing->end_date->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Durasi:</span>
                    <span class="info-value">{{ $borrowing->start_date->diffInDays($borrowing->end_date) + 1 }} Hari</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipe Lokasi:</span>
                    <span class="info-value">{{ $borrowing->location_type == 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota' }}</span>
                </div>
            </div>
        </div>

        <!-- Destination (if applicable) -->
        @if($borrowing->location_type == 'luar_kota' && $borrowing->destination)
            @php
                $destinationData = $borrowing->destination;
                $province = null;
                $city = null;

                if (is_array($destinationData)) {
                    $province = $destinationData['province'] ?? null;
                    $city = $destinationData['city'] ?? null;
                } elseif (is_string($destinationData)) {
                    $decoded = json_decode($destinationData, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $province = $decoded['province'] ?? null;
                        $city = $decoded['city'] ?? null;
                    }
                }
            @endphp

            <div class="destination-card">
                <div class="destination-header">
                    <div class="destination-icon">📍</div>
                    <div class="destination-title">Destinasi Tujuan</div>
                </div>
                <div class="destination-content">
                    @if($province && $city)
                        <strong>{{ $city }}</strong>, {{ $province }}
                    @elseif($province || $city)
                        {{ $province ?: $city }}
                    @else
                        {{ is_string($borrowing->destination) ? $borrowing->destination : 'Destinasi tidak tersedia' }}
                    @endif
                </div>
            </div>
        @endif

        <!-- Vehicle Information -->
        <div class="vehicle-section">
            <h3>🚗 Informasi Kendaraan ({{ $borrowing->unit_count }} Unit)</h3>

            @php
                $vehiclesData = null;
                if ($borrowing->vehicles_data) {
                    if (is_string($borrowing->vehicles_data)) {
                        $vehiclesData = json_decode($borrowing->vehicles_data, true);
                    } elseif (is_array($borrowing->vehicles_data)) {
                        $vehiclesData = $borrowing->vehicles_data;
                    }
                }
            @endphp

            @if($vehiclesData && is_array($vehiclesData) && count($vehiclesData) > 0)
                @foreach($vehiclesData as $index => $vehicleData)
                    @php
                        $vehicle = \App\Models\Vehicle::find($vehicleData['vehicle_id'] ?? null);
                    @endphp
                    <div class="vehicle-card">
                        <div class="vehicle-header">
                            <span class="vehicle-title">
                                Kendaraan {{ $index + 1 }}
                                @if(isset($vehicleData['unit_number']))
                                    (Unit {{ $vehicleData['unit_number'] }})
                                @endif
                            </span>
                        </div>

                        @if($vehicle)
                            <div class="vehicle-details">
                                <div class="info-row">
                                    <span class="info-label">Brand/Model:</span>
                                    <span class="info-value font-bold">{{ $vehicle->brand }} {{ $vehicle->model }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Plat Nomor:</span>
                                    <span class="info-value font-bold">{{ $vehicle->license_plate }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Jenis & Tahun:</span>
                                    <span class="info-value">{{ ucfirst($vehicle->type) }} {{ $vehicle->year }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Warna:</span>
                                    <span class="info-value">{{ $vehicle->color }}</span>
                                </div>
                            </div>
                        @elseif(isset($vehicleData['vehicle_info']))
                            <div class="vehicle-details">
                                <div class="info-row">
                                    <span class="info-label">Brand/Model:</span>
                                    <span class="info-value font-bold">
                                        {{ $vehicleData['vehicle_info']['brand'] ?? 'N/A' }}
                                        {{ $vehicleData['vehicle_info']['model'] ?? 'N/A' }}
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Plat Nomor:</span>
                                    <span class="info-value font-bold">{{ $vehicleData['vehicle_info']['license_plate'] ?? 'N/A' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Tahun:</span>
                                    <span class="info-value">{{ $vehicleData['vehicle_info']['year'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <p style="color: #f59e0b; font-size: 11px; margin-top: 5px;">⚠️ Data arsip - Kendaraan telah dihapus</p>
                        @else
                            <p style="color: #ef4444;">❌ Kendaraan tidak ditemukan (ID: {{ $vehicleData['vehicle_id'] ?? 'N/A' }})</p>
                        @endif
                    </div>
                @endforeach
            @elseif($borrowing->vehicle_id)
                @php
                    $singleVehicle = \App\Models\Vehicle::find($borrowing->vehicle_id);
                @endphp
                @if($singleVehicle)
                    @for($i = 1; $i <= $borrowing->unit_count; $i++)
                        <div class="vehicle-card">
                            <div class="vehicle-header">
                                <span class="vehicle-title">Kendaraan {{ $i }} (Unit {{ $i }})</span>
                            </div>
                            <div class="vehicle-details">
                                <div class="info-row">
                                    <span class="info-label">Brand/Model:</span>
                                    <span class="info-value font-bold">{{ $singleVehicle->brand }} {{ $singleVehicle->model }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Plat Nomor:</span>
                                    <span class="info-value font-bold">{{ $singleVehicle->license_plate }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Jenis & Tahun:</span>
                                    <span class="info-value">{{ ucfirst($singleVehicle->type) }} {{ $singleVehicle->year }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Warna:</span>
                                    <span class="info-value">{{ $singleVehicle->color }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <p style="color: #f59e0b; font-size: 11px; margin-top: 10px;">⚠️ Format data lama - Semua unit menggunakan kendaraan yang sama</p>
                @else
                    <div class="vehicle-card">
                        <p style="color: #ef4444;">❌ Kendaraan tidak ditemukan (ID: {{ $borrowing->vehicle_id }})</p>
                    </div>
                @endif
            @else
                <div class="vehicle-card">
                    <p style="color: #6b7280;">ℹ️ Data kendaraan tidak tersedia</p>
                </div>
            @endif
        </div>

        <!-- Purpose -->
        <div class="purpose-section">
            <h3>📝 Keperluan Penggunaan</h3>
            <div class="purpose-text">{{ $borrowing->purpose }}</div>
        </div>

        @if($borrowing->notes)
        <!-- Notes -->
        <div class="purpose-section" style="background-color: #fefce8; border-color: #fde047;">
            <h3 style="color: #a16207;">💬 Catatan Tambahan</h3>
            <div class="purpose-text" style="color: #a16207;">{{ $borrowing->notes }}</div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-info">
                <div class="signature-box">
                    <div class="signature-title">Pemohon</div>
                    <div class="signature-line">{{ $borrowing->borrower_name }}</div>
                </div>
                <div class="signature-box">
                    <div class="signature-title">Operator</div>
                    <div class="signature-line">{{ $borrowing->user->name ?? 'N/A' }}</div>
                </div>
                <div class="signature-box">
                    <div class="signature-title">Admin/Atasan</div>
                    <div class="signature-line">(.....................................)</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
