<?php
namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\Appointment;

class LivewireDashboard extends Component
{
    public function render()
    {
        $appt = Appointment::latest()->get();
        return view('admin.dashboard', [
            'notifCount' => count($appt),
            'appt'       => $appt->take(3)
        ]);
    }
}
