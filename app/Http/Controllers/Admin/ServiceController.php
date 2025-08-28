<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * Display the specified resource for admin.
     */
    public function show(Service $service)
    {
        $service->load(['vehicle', 'user']);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Download a PDF representation of the service record.
     */
    public function download(Service $service)
    {
        $service->load(['vehicle', 'user']);

        $pdf = Pdf::loadView('admin.services.pdf', compact('service'));

    $datePart = $service->service_date ? Carbon::parse($service->service_date)->format('Ymd') : now()->format('Ymd');
    $filename = sprintf('service-%d-%s.pdf', $service->id, $datePart);

        return $pdf->download($filename);
    }
}