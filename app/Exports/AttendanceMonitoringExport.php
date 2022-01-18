<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceMonitoringExport implements FromArray
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

/*    public function headings():array
    {
        return [
            'Date',
            'Sign In',
            'Sign Out',
            'Status',
            'W. Hour',
            'Late',
            'E. Leave',
            'Comments'
        ];
    }*/
}
