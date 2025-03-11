<?php

namespace App\Imports;

use App\Models\Branch;
use Illuminate\Support\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class BranchImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info('branches',$row);
        return new Branch([
            'id' => $row[0] ,
            'branch_name' => [
                'uz' => $row[1] ?? '',
                'ru' => $row[2] ?? '',
                'en' => $row[3] ?? '',
                'qr' => $row[4] ?? '',
            ],
            'street' => [
                'uz' => $row[5] ?? '',
                'ru' => $row[6] ?? '',
                'en' => $row[7] ?? '',
                'qr' => $row[8] ?? '',
            ],
            'start_date'=>$row[9],
            'end_date'=>$row[10],
            'point_array'=>[$row[11],$row[11]]
        ]);
    }

    

    public function map($row): array
    {
        return $row;
    }
}
