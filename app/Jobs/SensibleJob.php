<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SensibleJob implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $medicalInfo;

    /**
     * Create a new job instance.
     */
    public function __construct($medicalInfo)
    {
        $medicalInfo['user'] = $medicalInfo['user']->withoutRelations();
        $this->medicalInfo = $medicalInfo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
