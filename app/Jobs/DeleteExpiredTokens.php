<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class DeleteExpiredTokens implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function handle()
    {
        // Hozirgi vaqtdan eski bo‘lgan tokenlarni o‘chirish
        PersonalAccessToken::where('expires_at', '<', Carbon::now()->subMinutes(30))->delete();
    }
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
}
