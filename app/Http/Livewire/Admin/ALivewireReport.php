<?php
namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\Appointment;

class ALivewireReport extends Component
{
    /*Get Data in a safe way*/
    protected $appt;

    public function fetchData()
    {
        /*For notifications*/
        $appoint = Appointment::leftjoin('appointment_status as apts','apts.appt_id','appointments.id')
            ->where('apts.status','Pending')
            ->latest()->get();
        $this->appt = $appoint;
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
