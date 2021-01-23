<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AdminDeliveryAddress;

class ImportAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:address';

    const ACTIVE = 'active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to import chunk of delivery addresses';

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
          //set the path for the csv files
          $folderPath = config('constants.TEMP_IMPORTING_FOLDER_PATH');
                
          $path = public_path() . $folderPath.'*.csv';
    
    //run 3 loops at a time 
    foreach (array_slice(glob($path),0,3) as $file) {
        
        //read the data into an array
        $data = array_map('str_getcsv', file($file));
        //loop over the data
        foreach($data as $row) {

            AdminDeliveryAddress::updateOrCreate([
                'zipcode' => $row[3]
            ],[
                'address' => $row[0],
                'city' => $row[1],
                'state' => $row[2],
                'zipcode' => $row[3],
                'country' => $row[4],
                'timezone' => $row[5],
                'status' => self::ACTIVE
            ]);
        }

        //delete the file
        unlink($file);
    }
    }
}
