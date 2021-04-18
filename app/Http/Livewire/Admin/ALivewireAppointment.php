<?php
namespace App\Http\Livewire\Admin;
use App\Models\{Appointment, AppointmentStatus, Service};
use Livewire\{Component,WithPagination};
use Carbon\Carbon;

class ALivewireAppointment extends Component
{
    use WithPagination;/*User Livewire Pagination*/
    protected $paginationTheme = 'bootstrap';/*Use Bootstrap theme pagination*/

    /*Get Data in a safe way*/
    protected $appointments, $appt, $services;

    public $sortBy = 'created_at';/*Sort With Column*/
    public $sortDirection = 'desc';/*Latest Item*/
    public $perPage = '10';/*Page Pagination*/

    /*For Searching Item*/
    public $search='';
    protected $queryString = ['search'];

    /*Item*/
    public $appt_id, $name, $email, $phone, $service, $schedule, $note, $address, $status;

    public $updateMode = false;

    public function fetchData()
    {
        /*Get Appointment Data to Tables*/
        $appt = Appointment::leftjoin('appointment_status as apts','apts.appt_id','appointments.id')
        ->where(fn($query) => $query
            ->where(  'name',    'like', '%' . $this->search . '%')
            ->orWhere('email',   'like', '%' . $this->search . '%')
            ->orWhere('service', 'like', '%' . $this->search . '%')
        )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        $this->appointments = $appt;

        /*For notifications*/
        $appoint = Appointment::leftjoin('appointment_status as apts','apts.appt_id','appointments.id')
            ->where('apts.status','Pending')
            ->latest()->get();
        $this->appt = $appoint;

        /*For Services*/
        $serv = Service::where('status','Active')->get();
        $this->services = $serv;
    }

    public function sortBy($field)
    {
        $this->sortDirection == 'asc' ? $this->sortDirection = 'desc' : $this->sortDirection = 'asc';
        return $this->sortBy = $field;
    }

    private function resetInputFields()
    {
        $this->name     = '';
        $this->email    = '';
        $this->phone    = '';
        $this->service  = '';
        $this->schedule = '';
        $this->status   = '';
        $this->note     = '';
        $this->address  = '';
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $appt = Appointment::findOrFail($id);
        $apptStatus = AppointmentStatus::where('appt_id',$id)->first();
        $this->appt_id = $id;
        $this->name     = $appt->name;
        $this->email    = $appt->email;
        $this->phone    = $appt->phone;
        $this->service  = $appt->service;
        $this->schedule = Carbon::parse($appt->schedule)->format('Y-m-d\TH:i');
        $this->status   = $apptStatus->status;
        $this->note     = $appt->note;
        $this->address  = $appt->address;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'service'   => 'required',
            'schedule'  => 'required',
            'note'      => 'required',
            'status'    => 'required',
            'address'   => 'required',
        ],['required'   => 'The :attribute field is required']);

        $appt = Appointment::findOrFail($this->appt_id);
        $appt->update([
            'name'     => $this->name,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'service'  => $this->service,
            'schedule' => $this->schedule,
            'note'     => $this->note,
            'address'  => $this->address,
        ]);

        $apptStatus = AppointmentStatus::where('appt_id',$this->appt_id);
        $apptStatus->update([
            'status'    => "Success",
        ]);
        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Service Updated',
            'timer'     =>  5000,
            'icon'      =>  'success',
            'toast'     =>  true,
            'position'  =>  'top-right'
        ]);
        $this->resetInputFields();
        $this->emit('modalStore');/*Close Modal*/

    }

    public function fail()
    {
        $apptStatus = AppointmentStatus::where('appt_id',$this->appt_id);
        $apptStatus->update([
            'status'    => "Failed",
        ]);
        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Walk In Updated',
            'timer'     =>  5000,
            'icon'      =>  'success',
            'toast'     =>  true,
            'position'  =>  'top-right'
        ]);
        $this->resetInputFields();
        $this->emit('modalStore');/*Close Modal*/
    }

    public function show($id)
    {
        $this->updatedMode = true;
        $appt = Appointment::findOrFail($id);
        $this->appt_id = $appt->id;
    }

    public function render()
    {
        $this->fetchData();
        return view('admin.appointment',[
            'item'       => $this->appointments,
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3),
            'services'   => $this->services
        ]);
    }
}
