<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class WeatherMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        weather:monitor {--a|age=1} {--h : statistiche orarie} {--hourly : statistiche orarie} {--d : statistiche giornaliere} {--daily : statistiche giornaliere} {--w : statistiche settimanali}{--weekly : statistiche settimanali} {--m : statistiche mensili} {--monthly : statistiche mensili}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weather statistics';

    public $weatherService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        if($this->option('h') || $this->option('hourly')){
            $this->info("raccolgo le stats per ora");    
            $this->perHour();
        }
        if($this->option('d') || $this->option('daily')){
            $this->info("raccolgo le stats per giorno");   
            $this->perDay(); 
        }
        if($this->option('w') || $this->option('weekly')){
            $this->info("raccolo le stats per settimana");
            $this->perWeek();
        }
        if($this->option('m') || $this->option('monthly')){
            $this->info("raccolgo le stats per mese");
            $this->perMonth();
        }     
    }

    public function getHeader($t){
        $time = $this->getTimeHeader($t);
        $header = [$time, 'minima', 'media', 'massima', 'minima', 'media', 'massima'];
        return $header;
    }

    public function getTimeHeader($t){
        $s = '';
        switch ($t) {
            case 'h':
                $s = 'ora';
                break;
            case 'd':
                $s = 'giorno';
                break;
            case 'm':
                $s = 'mese';
                break;
            case 'w':
                $s = 'settimana';
                break;
        }
        return $s;
    }

    public function perHour(){
        $header = $this->getHeader('h');
        $stats = $this->weatherService->hourly();
        $this->table($header, $stats);
    }

    public function perDay(){
        $header = $this->getHeader('d');
        $stats = $this->weatherService->daily();
        $this->table($header, $stats);   
    }

    public function perMonth(){
        $header = $this->getHeader('m');
        $stats = $this->weatherService->monthly();
        $this->table($header, $stats);   
    }

    public function perWeek(){
        $header = $this->getHeader('w');
        $stats = $this->weatherService->weekly();
        $this->table($header, $stats);
    }
}
