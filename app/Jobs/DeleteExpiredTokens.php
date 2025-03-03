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
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $deleted = PersonalAccessToken::where('created_at', '<', Carbon::now()->subMinutes(2))->delete();

        \Log::info("O'chirilgan API tokenlar soni: " . $deleted);
    }
}
