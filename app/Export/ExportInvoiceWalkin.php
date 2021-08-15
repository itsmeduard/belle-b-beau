<?php
namespace App\Export;
use App\Models\{InvoiceAppointment};
use Maatwebsite\Excel\Concerns\{FromCollection,WithHeadings};

class ExportInvoiceWalkin implements FromCollection, WithHeadings
{
    protected $date_from;
    protected $date_to;

    function __construct($date_from,$date_to) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        return  InvoiceWalkin::leftjoin('walkin','walkin.id','invoice_walkin.detail_id')
            ->whereBetween('invoice_walkin.created_at',[ $this->date_from,$this->date_to])
            ->select('appt.name','appt.email','appt.phone','appt.address','appt.service','appt.schedule','invoice_appointment.total')
            ->latest('invoice_walkin.created_at')
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
            'Customer Paid',
        ];
    }
}
