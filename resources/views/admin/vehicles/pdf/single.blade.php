<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kendaraan - {{ $vehicle->license_plate }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 10px;
            color: #333;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: #64748b;
            font-weight: normal;
        }

        .header p {
            margin: 2px 0 0 0;
            font-size: 9px;
            color: #64748b;
        }

        .vehicle-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

        .vehicle-header h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .vehicle-header .license-plate {
            font-size: 16px;
            font-weight: bold;
            margin: 4px 0;
            letter-spacing: 1px;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .photo-section {
            text-align: center;
        }

        .vehicle-photo {
            max-width: 100%;
            max-height: 200px;
            border-radius: 6px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .no-photo {
            width: 200px;
            height: 150px;
            background-color: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 12px;
            margin: 0 auto;
        }

        .details-section {
            background-color: #f8fafc;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #374151;
            min-width: 120px;
            font-size: 10px;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 500;
            text-align: right;
            flex: 1;
            font-size: 10px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-tersedia {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-dipinjam {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-service {
            background-color: #fecaca;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

    .status-digunakan_pejabat {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .document-status {
            margin-top: 12px;
            padding: 10px;
            background-color: #eff6ff;
            border-radius: 6px;
            border-left: 3px solid #2563eb;
        }

        .document-status h4 {
            margin: 0 0 8px 0;
            color: #1e40af;
            font-size: 11px;
        }

        .doc-complete {
            color: #166534;
            font-weight: bold;
            background-color: #dcfce7;
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #bbf7d0;
            font-size: 9px;
        }

        .doc-incomplete {
            color: #dc2626;
            font-weight: bold;
            background-color: #fee2e2;
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #fca5a5;
            font-size: 9px;
        }

        .tax-warning {
            background-color: #fef2f2;
            border: 1.5px solid #dc2626;
            border-radius: 4px;
            padding: 8px;
            margin-top: 8px;
        }

        .tax-warning .warning-icon {
            color: #dc2626;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .additional-info {
            margin-top: 12px;
            padding: 10px;
            background-color: #fafafa;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .additional-info h4 {
            margin: 0 0 8px 0;
            color: #374151;
            font-size: 11px;
        }

        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 8px;
            color: #64748b;
        }

        @media print {
            body {
                margin: 5px;
                font-size: 9px;
                line-height: 1.1;
            }
            .content {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .vehicle-photo {
                max-height: 150px;
            }
            .header {
                margin-bottom: 10px;
                padding-bottom: 8px;
            }
            .vehicle-header {
                margin-bottom: 10px;
                padding: 8px;
            }
            .document-status, .additional-info {
                margin-top: 8px;
                padding: 8px;
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
        <h1>Detail Kendaraan Dinas</h1>
        <h2>Sistem Kendaraan Dinas</h2>
    </div>

    <!-- Vehicle Header -->
    <div class="vehicle-header">
        <h3>{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
        <div class="license-plate">{{ $vehicle->license_plate }}</div>
        <div style="font-size: 10px; opacity: 0.9;">
            {{ ucfirst($vehicle->type) }} • {{ $vehicle->year }} • {{ $vehicle->color }}
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Photo Section -->
        <div class="photo-section">
            @if($vehicle->photo && \Storage::disk('public')->exists($vehicle->photo))
                <img src="{{ public_path('storage/' . $vehicle->photo) }}"
                     alt="Foto {{ $vehicle->brand }} {{ $vehicle->model }}"
                     class="vehicle-photo">
            @else
                <div class="no-photo">
                    <div>
                        <div style="font-size: 24px; margin-bottom: 10px;">📷</div>
                        <div>Tidak ada foto</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Details Section -->
        <div class="details-section">
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Jenis Kendaraan:</span>
                    <span class="detail-value">{{ ucfirst($vehicle->type) }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Merek:</span>
                    <span class="detail-value">{{ $vehicle->brand }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Model:</span>
                    <span class="detail-value">{{ $vehicle->model }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Tahun:</span>
                    <span class="detail-value">{{ $vehicle->year }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Warna:</span>
                    <span class="detail-value">{{ $vehicle->color }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Plat Nomor:</span>
                    <span class="detail-value" style="font-weight: bold;">{{ $vehicle->license_plate }}</span>
                </div>

                    <div class="detail-item">
                        <span class="detail-label">No. BPKB:</span>
                        <span class="detail-value">{{ $vehicle->bpkb_number }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">No. Rangka:</span>
                        <span class="detail-value">{{ $vehicle->chassis_number }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">No. Mesin:</span>
                        <span class="detail-value">{{ $vehicle->engine_number }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jml CC:</span>
                        <span class="detail-value">{{ $vehicle->cc_amount }}</span>
                    </div>

                <div class="detail-item">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        @php
                            $statusClasses = [
                                'tersedia' => 'status-tersedia',
                                'dipinjam' => 'status-dipinjam',
                                'service' => 'status-service',
                                'digunakan_pejabat' => 'status-digunakan_pejabat'
                            ];
                            $statusTexts = [
                                'tersedia' => 'Tersedia',
                                'dipinjam' => 'Dipinjam',
                                'service' => 'Service',
                                'digunakan_pejabat' => 'Digunakan Pejabat/Operasional'
                            ];
                        @endphp
                        <span class="status-badge {{ $statusClasses[$vehicle->availability_status] ?? 'status-digunakan_pejabat' }}">
                            {{ $statusTexts[$vehicle->availability_status] ?? $vehicle->availability_status }}
                        </span>
                    </span>
                </div>

                @if($vehicle->tax_expiry_date)
                <div class="detail-item">
                    <span class="detail-label">Pajak Kendaraan:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($vehicle->tax_expiry_date)->format('d F Y') }}</span>
                </div>
                @endif

                @if($vehicle->driver_name)
                <div class="detail-item">
                    <span class="detail-label">Driver:</span>
                    <span class="detail-value">{{ $vehicle->driver_name }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Document Status -->
    <div class="document-status">
        <h4>Status Dokumen Kendaraan</h4>
        <div class="detail-item" style="border: none; padding: 5px 0;">
            <span class="detail-label">Status Kelengkapan:</span>
            <span class="detail-value">
                @if($vehicle->document_status === 'lengkap')
                    <span class="doc-complete">Lengkap</span>
                @else
                    <span class="doc-incomplete">Tidak Lengkap</span>
                @endif
            </span>
        </div>

        @if($vehicle->document_notes)
        <div style="margin-top: 8px;">
            <span class="detail-label">Catatan Dokumen:</span>
            <div style="margin-top: 4px; padding: 6px; background-color: white; border-radius: 4px; border: 1px solid #e2e8f0; font-size: 9px;">
                {{ $vehicle->document_notes }}
            </div>
        </div>
        @endif
    </div>

    <!-- Tax Warning -->
    @if($vehicle->tax_expiry_date && $vehicle->isTaxExpiringSoon())
    <div class="tax-warning">
        <div class="warning-icon">PERINGATAN PAJAK KENDARAAN</div>
        <div style="margin-top: 6px; font-size: 9px;">
            Pajak kendaraan <strong>{{ $vehicle->license_plate }}</strong> akan expired pada
            <strong>{{ \Carbon\Carbon::parse($vehicle->tax_expiry_date)->format('d F Y') }}</strong>.
            Segera lakukan perpanjangan pajak kendaraan.
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>
            Laporan digenerate pada {{ now()->format('d F Y') }}
        </p>
        <p style="margin-top: 5px;">
            Data kendaraan: {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})
        </p>
    </div>
</body>
</html>
