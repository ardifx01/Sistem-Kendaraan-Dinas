<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ServiceDueNotification extends Notification
{
    use Queueable;

    protected $vehicle;
    protected $daysSinceService;

    public function __construct($vehicle, int $daysSinceService)
    {
        $this->vehicle = $vehicle;
        $this->daysSinceService = $daysSinceService;
    }

    public function via($notifiable)
    {
        // database notification and mail (if mail configured)
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'vehicle_id' => $this->vehicle->id,
            'vehicle' => $this->vehicle->getFullNameAttribute(),
            'days_since_service' => $this->daysSinceService,
            'message' => "Kendaraan {$this->vehicle->getFullNameAttribute()} belum diservis selama {$this->daysSinceService} hari",
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Service Kendaraan')
            ->line("Kendaraan: {$this->vehicle->getFullNameAttribute()} sudah {$this->daysSinceService} hari sejak service terakhir.")
            ->action('Lihat Kendaraan', url('/admin/vehicles/'.$this->vehicle->id))
            ->line('Silakan jadwalkan service untuk kendaraan ini.');
    }
}
