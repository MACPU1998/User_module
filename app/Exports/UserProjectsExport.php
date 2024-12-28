<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class UserProjectsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;
    public function __construct($query)
    {
        $this->query = $query;
    }

//    public function query()
//    {
//        return $this->query;
//    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            "عنوان",
            "مجری",
            "مشتری",
            "شماره مشتری",
            "استان",
            "شهرستان",
            "پلاسکوین",
            "وضعیت",
            "تاریخ ثبت",
        ];
    }


    /**
     * @param $invoice
     */
    public function map($row): array
    {
        return [
            $row->title,
            $row->user->first_name.' '.$row->user->last_name,
            $row->client_first_name.' '.$row->client_last_name,
            $row->client_phone,
            $row->province_name,
            $row->city_name,
            $row->credit,
            $row->status,
            $row->jalali_created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
