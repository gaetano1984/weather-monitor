<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\ArrayToXml\ArrayToXml;

class convert_csv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert_csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'csv to xml invoices conversion';

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
        $path = storage_path('fatture/fatture.csv');
        $this->info("leggo il file da convertire in ".$path);
        $n_rows = count(file($path));
        $this->info("trovate ".$n_rows." fatture");

        $bar = $this->output->createProgressBar($n_rows);
        $bar->setOverWrite(true);
        

        $obj = [];

        $this->info("\nfase 1, converto il csv in un oggetto");
        $bar->start();
        $fh = fopen($path, 'r');        
        $header = fgetcsv($fh, 4096, ';');
        while($row = fgetcsv($fh, 4096, ';')){
            $row = array_combine($header, $row);
            array_push($obj, $row);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\noggetto pronto");

        $this->info("fase 2 converto le varie fatture nei singoli xml");
        $bar2 = $this->output->createProgressBar($n_rows);
        $bar2->setOverWrite(true);
        $bar2->start();
        foreach($obj as $fatt){
            $xml = ArrayToXml::convert($fatt, 'FATTURA');
            $xml_name = 'fattura_'.$fatt['ID_SOGEA_DOCUMENTO']."_".rand(1000,2000).".xml";
            $fhh = fopen(storage_path('fatture/xml/'.$xml_name), 'w');
            if(!$fhh){
                $this->error("impossibile scrivere il file xml");
                return false;
            }
            fwrite($fhh, $xml);
            fclose($fhh);
            $bar2->advance();
        }
        $bar2->finish();
        $this->info("\nfase 2 completata");       
        fclose($fh);
    }
}
