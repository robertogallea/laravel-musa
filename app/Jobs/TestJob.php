<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $value;

    /**
     * Create a new job instance.
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Job processato ' . $this->value);
    }
}
