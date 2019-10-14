<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class weather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'weather statistics';

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
    public function handle(WeatherService $ws)
    {
        //
        echo "previsioni meteo\n";
        $output = nl2br(shell_exec('weather limc'));
        $arr = explode('<br />', $output);
        var_dump($arr);

        $temp = preg_match("/Temperature: ([0-9]{1,}) ([CF]{1}) \(([0-9]{1,}) ([CF]{1})\)/", $arr[2], $found);

        $temp_c = $found[3];
        $temp_f = $found[1];

        $humidity = preg_match("/Relative Humidity: ([0-9]{1,})/", $arr[3], $found);

        $humidity = $found[1];

        $ws->saveStats($temp_f, $temp_c, $humidity);

        \Log::channel('weather')->info('weather info: temperature celsius '.$temp_c.' farenheit '.$temp_f.' humidity '.$humidity);
    }
}
