<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HighJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

//    public $backoff = 12; // numero di secondi che devono passare fra un tentativo di esecuzioni e l'altro

    public $timeout = 10;

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
        1/0;
    }

    public function tries()
    {
        return 10; // o un valore dinamico calcolato
    }

    public function backoff()
    {
//        return 12;
        return [1, 3, 5, 10];
        // 1 secondo fra 1° e 2° tentativo
        // 3 secondo fra 2° e 3° tentativo
        // 5 secondo fra 3° e 4° tentativo
        // 10 secondo fra 4° e tutti i tentativi a seguire
    }
}
