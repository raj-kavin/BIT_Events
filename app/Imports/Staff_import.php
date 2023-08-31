<?php

namespace App\Imports;

use App\Models\staff_data;
use Maatwebsite\Excel\Concerns\ToModel;

class Staff_import implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(array_filter($row)){

            return new staff_data([
                'staff_id'=>isset($row[0]) ? $row[0] : 'empty',
                'firstname' => isset($row[1]) ? $row[1] : 'empty',
                'lastname' => isset($row[2]) ? $row[2] : 'empty',
                'dob' => isset($row[3]) ? $row[3] : 'empty',
                'email' => isset($row[4]) ? $row[4] : 'empty',
                'phone_number' => isset($row[5]) ? $row[5] : 'empty',
            ]);
        }

    }
}
