<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $userIp = $request->ip();
        dd($userIp);
    }

    public function store(Request $request)
    {
        $checkAvailability = Appointment::where('ipAddress', $request->ip())
            ->where('created_at','<',now()->subMinutes(30 ))
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

            return redirect()->back()->with(array('message' => 'Appointment Created!', 'alert-type' => 'success'));

        }else{

            return redirect()->back()->with(array('message' => 'Please do not spam', 'alert-type' => 'error'));

        }
    }
}

