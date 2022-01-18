<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryCollectionReportExport implements FromArray
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $csvdata;

    public function __construct($csvdata)
    {
        $this->csvdata = $csvdata;
    }

    public function array(): array
    {
        return $this->csvdata;
    }


}