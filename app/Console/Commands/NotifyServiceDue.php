<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Models\User;
use App\Notifications\ServiceDueNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotifyServiceDue extends Command
{
    protected $signature = 'service:notify-due {--days=90 : Days threshold}';
    protected $description = 'Notify admins about vehicles not serviced for given days (default 90)';

    public function handle()
    {
        $days = (int) $this->option('days');
        $threshold = Carbon::now()->subDays($days)->startOfDay();

        $this->info("Checking vehicles with last service on or before {$threshold->toDateString()}...");

        $vehicles = Vehicle::with(['latestService'])->get();

        $admins = User::where('role', 'admin')->get();
        if ($admins->isEmpty()) {
            $this->warn('No admin users found to notify.');
        }

        $notifiedCount = 0;

        foreach ($vehicles as $vehicle) {
            $latest = $vehicle->latestService()->first();

            if (!$latest) {
                // skip vehicles with no service records for now
                continue;
            }

            $serviceDate = Carbon::parse($latest->service_date)->startOfDay();

            if ($serviceDate->lessThanOrEqualTo($threshold)) {
                $daysSince = Carbon::now()->diffInDays($serviceDate);
                foreach ($admins as $admin) {
                    try {
                        $admin->notify(new ServiceDueNotification($vehicle, $daysSince));
                    } catch (\Exception $e) {
                        Log::error('Failed to notify user '.$admin->id.': '.$e->getMessage());
                    }
                }
                $notifiedCount++;
                $this->line("Notified for vehicle {$vehicle->id} ({$vehicle->getFullNameAttribute()}) - last service: {$serviceDate->toDateString()} ({$daysSince} days)");
            }
        }

        $this->info("Done. Vehicles flagged: {$notifiedCount}");
        return 0;
    }
}
