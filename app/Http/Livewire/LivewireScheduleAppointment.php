<?php
namespace App\Http\Livewire;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\{Appointment, AppointmentStatus, Service};
use Session;

class LivewireScheduleAppointment extends Component
{
    public function store(Request $request)
    {
        abort_if($request->name == null ,404);
        $checkAvailability = Appointment::where('ipAddress', $request->ip())
            ->where('created_at','>=',now()->subMinutes(10 ))
            ->latest()
            ->first();
        if($checkAvailability == null) {
            Appointment::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'service'    => $request->service,
                'schedule'   => $request->schedule,
                'note'       => $request->note,
                'address'    => $request->address,
                'ipAddress'  => $request->ip(),
                'created_at' => now(),
            ]);

            AppointmentStatus::create([
                'status'   => 'Pending',
                'appt_id'  => Appointment::latest('id')->first()->id,
            ]);

            return redirect()->back()->with(array('message' => 'Appointment Created! We will contact you as soon as possible.',
                'alert-type' => 'success'));
        }else{
            return redirect()->back()->with(array('message' => 'You have already created appointment. Please, do not spam',
                'alert-type' => 'error'));
        }
    }

    public function render()
    {
        auth()->logout();
        Session::flush();
        return view('welcome', ['services' => Service::where('status','Active')->get()]);
    }
}
