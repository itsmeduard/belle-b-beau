<?php
namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\{Appointment,Walkin};
use Maatwebsite\Excel\Facades\Excel;
use App\Export\{ExportAppointment, ExportWalkin, ExportInvoiceAppointment, ExportInvoiceWalkin};
use Carbon\Carbon;

class ALivewireReport extends Component
{
    /*Get Data in a safe way*/
    protected $appt;

    public $date_from='', $date_to='', $report_type='';

    public function fetchData()
    {
        /*For notifications*/
        $appoint = Appointment::leftjoin('appointment_status as apts','apts.appt_id','appointments.id')
            ->where('apts.status','Pending')
            ->latest()->get();
        $this->appt = $appoint;
    }

    public function export_excel()
    {
        $this->validate([
            'report_type'  => 'required',
            'date_from'    => 'required',
            'date_to'      => 'required',
        ],['required'      => 'The :attribute field is required']);

        if($this->report_type == 'Appointment'){
            return Excel::download(new ExportAppointment($this->date_from, $this->date_to), 'excelname.xlsx');
        }elseif($this->report_type == 'Walkin'){
            return Excel::download(new ExportWalkin($this->date_from, $this->date_to), 'excelname.xlsx');
        }elseif($this->report_type == 'Invoice Appointment'){
            return Excel::download(new ExportInvoiceAppointment($this->date_from, $this->date_to), 'excelname.xlsx');
        }elseif($this->report_type == 'Invoice Walkin'){
            return Excel::download(new ExportInvoiceWalkin($this->date_from, $this->date_to), 'excelname.xlsx');
        }
    }

    public function export_pdf()
    {
        $this->validate([
            'date_from'    => 'required',
            'date_to'    => 'required',
        ],['required'   => 'The :attribute field is required']);
        if($this->report_type == 'Appointment'){
            return Excel::download(new ExportAppointment($this->date_from, $this->date_to), 'excelname.pdf');
        }elseif($this->report_type == 'Walkin'){
            return Excel::download(new ExportWalkin($this->date_from, $this->date_to), 'excelname.pdf');
        }elseif($this->report_type == 'Invoice Appointment'){
            return Excel::download(new ExportInvoiceAppointment($this->date_from, $this->date_to), 'excelname.pdf');
        }elseif($this->report_type == 'Invoice Walkin'){
            return Excel::download(new ExportInvoiceWalkin($this->date_from, $this->date_to), 'excelname.pdf');
        }
    }

    public function render()
    {
        $this->fetchData();
        return view('admin.report',[
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3)
        ]);
    }
}
