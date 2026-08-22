<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TicketStatus;
use App\Notifications\PriorityQueueOverdueNotification;
use Carbon\Carbon;

class CheckPriorityQueueOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:prioritas-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengecekan tiket antrean prioritas yang belum selesai setelah 5 hari dan kirim notifikasi ke tim Support & Super Admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = self::checkAndNotify();
        $this->info("Pengecekan selesai. {$count} notifikasi tiket prioritas diproses.");
    }

    /**
     * Periksa tiket aktif yang sudah menunggu >= 5 hari dan kirim notifikasi.
     *
     * @return int Jumlah notifikasi yang dikirim
     */
    public static function checkAndNotify()
    {
        $fiveDaysAgo = Carbon::now()->subDays(5);

        // Ambil tiket aktif yang dibuat atau diinput >= 5 hari lalu
        $overdueTickets = Ticket::with(['pelapor.instansi'])
            ->whereNotIn('status', [TicketStatus::DONE->value, 'Done', 'Selesai'])
            ->where(function ($q) use ($fiveDaysAgo) {
                $q->where('created_at', '<=', $fiveDaysAgo)
                  ->orWhere('tanggal_input', '<=', $fiveDaysAgo);
            })
            ->get();

        if ($overdueTickets->isEmpty()) {
            return 0;
        }

        // Ambil semua user Support dan Super Admin
        $recipients = User::whereIn('role', [
            UserRole::SUPPORT->value,
            UserRole::SUPERADMIN->value,
            'Support',
            'Super Admin',
            'Superadmin'
        ])->get();

        if ($recipients->isEmpty()) {
            return 0;
        }

        $now = Carbon::now();
        $sentCount = 0;

        foreach ($overdueTickets as $ticket) {
            $created = $ticket->tanggal_input ?? $ticket->created_at;
            if (!$created) {
                continue;
            }

            $daysWaiting = (int) $created->diffInDays($now);
            if ($daysWaiting < 5) {
                continue;
            }

            foreach ($recipients as $user) {
                // Hindari duplikasi: cek apakah sudah dikirim notifikasi untuk tiket ini dalam 24 jam terakhir
                $alreadyNotified = $user->notifications()
                    ->where('type', PriorityQueueOverdueNotification::class)
                    ->where('data', 'like', '%"ticket_id":"' . $ticket->ticket_id . '"%')
                    ->where('created_at', '>=', Carbon::now()->subHours(24))
                    ->exists();

                if (!$alreadyNotified) {
                    $user->notify(new PriorityQueueOverdueNotification($ticket, $daysWaiting));
                    $sentCount++;
                }
            }
        }

        return $sentCount;
    }
}
