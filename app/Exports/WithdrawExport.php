<?php

namespace App\Exports;

use App\Models\Withdraw;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WithdrawExport implements FromQuery, WithHeadings, WithColumnFormatting
{
    use Exportable;
    public function headings(): array
    {
        return [
            'id', 'investor', 'middle_name', 'last_name','country', 'city', 'email', 'phone' ,'facility', 'specialty', 'sub_specialty', 'status', 'register_at', 'type'
        ];
    }

    private $investor;
    private $date_from;
    private $date_to;
    private $status;

    public function __construct( $investor=null,  $date_from=null,  $date_to=null,  $status=-1)
    {
        $this->investor = $investor;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->status = $status;
    }


    public function query()
    {
        $invo = $this->investor;
        $data = Withdraw::with(['userDetail' => function($query) use ($invo){
            $query->where('name', 'like', '%'.$invo.'%');
        }]);

        if ($this->status > -1) {
            $data->where('status', $this->status);
        }
        if ($this->date_from) {
            $data->whereDate('created_at', '>=',  $this->date_from);
        }
        if ($this->date_to) {
            $data->whereDate('created_at', '<=',  $this->date_to);
        }

        return $data->orderBy('created_at', 'desc');
    }

    public function columnFormats(): array
    {
        return [
//            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
