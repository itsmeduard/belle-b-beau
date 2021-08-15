<?php
namespace App\Export;
use App\Models\{InvoiceAppointment};
use Maatwebsite\Excel\Concerns\{FromCollection,WithHeadings};

class ExportInvoiceAppointment implements FromCollection, WithHeadings
{
    protected $date_from;
    protected $date_to;

    function __construct($date_from,$date_to) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        return  InvoiceAppointment::leftjoin('appointment_status as appt_stat','appt_stat.appt_id','invoice_appointment.detail_id')
            ->leftjoin('appointments as appt','appt.id','appt_stat.appt_id')
            ->whereBetween('invoice_appointment.created_at',[ $this->date_from,$this->date_to])
            ->where('appt_stat.status','Accepted')
            ->select('appt.name','appt.email','appt.phone','appt.address','appt.service','appt.schedule','invoice_appointment.total')
            ->latest('invoice_appointment.created_at')
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
