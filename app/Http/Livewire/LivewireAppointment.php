<?php
namespace App\Http\Livewire;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\{Appointment, AppointmentStatus, Service};

class LivewireAppointment extends Component
{
    public function store(Request $request)
    {
        abort_if($request->name === null ,404);
        $checkAvailability = Appointment::where(
            [ 'ipAddress', $request->ip() ],
            [ 'created_at','>=',now()->subMinutes(10 ) ])
            ->orderBy('created_at','desc')
            ->first();

        if( empty($checkAvailability) ) {
            $apt              = new Appointment;
            $apt->name        = $request->name;
            $apt->email       = $request->email;
            $apt->phone       = $request->phone;
            $apt->service     = $request->service;
            $apt->schedule    = $request->schedule;
            $apt->note        = $request->note;
            $apt->ipAddress   = $request->ip();
            $apt->created_at  = now();
            $apt->save();

            $aptStatus = new AppointmentStatus();
            $aptStatus->status  = 1;
            $aptStatus->appt_id = Appointment::latest('id')->first()->id;
            $aptStatus->save();

            return redirect()->back()->with(array('message' => 'Appointment Created! We will contact you as soon as possible.',
                'alert-type' => 'success'));

        }else{

            return redirect()->back()->with(array('message' => 'You already created appointment. Please, do not spam',
                'alert-type' => 'error'));

        }
    }

    public function render()
    {
        return view('welcome', ['services' => Service::where('status','Active')->get()]);
    }
}
