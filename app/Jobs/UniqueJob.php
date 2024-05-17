<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


// ShoudBeUnique valuta l'unicità del job rispetto a quelli in stato "in coda", "in esecuzione", "fallito"
// ShoudBeUniqueUntileProcessing valuta l'unicità del job rispetto a quelli in stato "in coda" soltanto
class UniqueJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $id;

    // intervallo temporale (in secondi) per il quale rifiutare job duplicati
    public $uniqueFor = 20;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->id = rand(0,1);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }

    // chiave identificativa per valutare se il job è duplicato
    public function uniqueId()
    {
        return $this->id;
    }
}
