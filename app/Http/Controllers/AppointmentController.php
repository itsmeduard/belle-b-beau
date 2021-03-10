<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort_if($request->name === null ,404);
        $checkAvailability = Appointment::where('ipAddress', $request->ip())
            ->where('created_at','>=',now()->subMinutes(30 ))
            ->orderBy('created_at','desc')
            ->first();

        if( empty($checkAvailability) ) {
            $apt              = new Appointment;
            $apt->name        = $request->name;
            $apt->email       = $request->email;
            $apt->phone       = $request->phone;
            $apt->service     = $request->service;
            $apt->schedule    = $request->schedule;
            $apt->esthetician = $request->esthetician;
            $apt->note        = $request->note;
            $apt->ipAddress   = $request->ip();
            $apt->created_at  = now();
            $apt->save();

            return redirect()->back()->with(array('message' => 'Appointment Created! We will contact you as soon as possible.',
                'alert-type' =>
                'success'));

        }else{

            return redirect()->back()->with(array('message' => 'You already created appointment. Please, do not spam',
                'alert-type' =>
                'error'));

        }
    }
}

