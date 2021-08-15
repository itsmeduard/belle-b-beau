<?php
namespace App\Export;
use App\Models\{Appointment};
use Maatwebsite\Excel\Concerns\{FromCollection,WithHeadings};

class ExportAppointment implements FromCollection, WithHeadings
{
    protected $date_from;
    protected $date_to;

    function __construct($date_from,$date_to) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        return  Appointment::leftjoin('appointment_status as appt_stat','appt_stat.appt_id','appointments.id')
            ->whereBetween('created_at',[ $this->date_from,$this->date_to])
            ->where('status','Accepted')
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
