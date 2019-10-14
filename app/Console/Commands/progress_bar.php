<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class progress_bar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'progress_bar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Progress Bar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $l = 13;
        $l2 = 25;

        $this->info("scrivo le fatture");

        $bar = $this->output->createProgressBar($l);
        $bar->setOverWrite(true);
        $bar->start();

        for($i=0; $i<$l; $i++){
            $bar->advance();
            sleep(1);
        }
        $bar->finish();

        $this->info("\nfase 1 finita, inizio la 2");
        $bar2 = $this->output->createProgressBar($l2);
        $bar2->setOverWrite(true);
        $bar2->start();

        for($i=0; $i<$l2; $i++){
            $bar2->advance();
            sleep(1);
        }        

        $bar2->finish();

        $this->info("\nfatture scritte");
    }
}
