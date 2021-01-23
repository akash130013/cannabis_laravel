<?php

namespace App\Imports;

use App\AdminDeliveryAddress;
use Maatwebsite\Excel\Concerns\ToModel;

class AdminAddressImport implements ToModel
{   

    const ACTIVE = 'active';
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
      
        return new AdminDeliveryAddress([
            'address' => $row[0],
            'city' => $row[1],
            'state' => $row[2],
            'zipcode' => $row[3],
            'country' => $row[4],
            'timezone' => $row[5],
            'status' => self::ACTIVE
        ]);
    }
}
