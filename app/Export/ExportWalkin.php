<?php
namespace App\Export;
use App\Models\{Walkin};
use Maatwebsite\Excel\Concerns\{FromCollection,WithHeadings};

class ExportWalkin implements FromCollection, WithHeadings
{
    protected $date_from;
    protected $date_to;

    function __construct($date_from,$date_to) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        return  Walkin::whereBetween('created_at',[ $this->date_from,$this->date_to])
            ->select('name','email','phone','address','service','schedule')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Mobile Number',
            'Address',
            'Service',
            'Schedule',
        ];
    }
}
