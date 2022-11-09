<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Pengerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // jika queri database
        // return User::all();
        // return Pengerjaan::all();


        // jika manual input di collectionnya
        $col = collect([
            [10,'ia'],
            [20,'as'],
            [40,'ka'],
            [10,'po'],
        ]);
        return $col;
    }
}
