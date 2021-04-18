<?php
namespace App\Http\Livewire\Admin;
use App\Models\{Service, Walkin, Appointment};
use Livewire\{Component,WithPagination};
use Illuminate\Support\Str;
use Carbon\Carbon;

class ALivewireWalkin extends Component
{
    use WithPagination;/*User Livewire Pagination*/
    protected $paginationTheme = 'bootstrap';/*Use Bootstrap theme pagination*/

    /*Get Data in a safe way*/
    protected $walkin, $appt, $services;

    public $sortBy = 'created_at';/*Sort With Column*/
    public $sortDirection = 'desc';/*Latest Item*/
    public $perPage = '10';/*Page Pagination*/

    /*For Searching Item*/
    public $search='';
    protected $queryString = ['search'];

    /*Item*/
    public $walkin_id, $name, $email, $phone, $service, $schedule, $note, $address, $total;
    public $sampleinput;

    public $updateMode = false;

    public function fetchData()
    {
        /*Get Appointment Data to Tables*/
        $walkin = Walkin::where(fn($query) => $query
                ->where(  'name',    'like', '%' . $this->search . '%')
                ->orWhere('email',   'like', '%' . $this->search . '%')
                ->orWhere('service', 'like', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        $this->walkin = $walkin;

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

    public function store()
    {
        $this->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'phone'    => 'required',
            'service'  => 'required',
            'schedule' => 'required',
            'note'     => 'required',
            'address'  => 'required',
            'total'    => 'required|numeric',
        ], ['required' => 'The :attribute field is required']);

        Walkin::updateOrInsert([
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'service'    => $this->service,
            'schedule'   => $this->schedule,
            'address'    => $this->address,
            'note'       => $this->note,
            'created_at' => now(),
        ]);

        $latest = Walkin::latest()->first();

        $i = 0;
        do {
            $random = Str::random(10);
            $check  = Walkin::where('invoice_number', $random)->first();
            if ($check == true)
                $i = 0;/*Actually do nothing here*/
            else
                $i++;
            $getRandom = $random;
        }while ($i == 1);

        Invoice::create([
            'total'          => $this->total * 100,
            'type'           => 'walkin',
            'invoice_number' => $getRandom,
            'detail_id'      => $latest->id,
            'created_at'     => now(),
        ]);

        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Walkin Created',
            'timer'     =>  5000,
            'icon'      =>  'success',
            'toast'     =>  true,
            'position'  =>  'top-right'
        ]);

        $this->resetInputFields();
        $this->emit('modalStore');/*Close Modal*/
    }

    public function edit($id)
    {
        $this->updateMode = true;

        $walkin = Walkin::findOrFail($id);

        $this->walkin_id = $id;
        $this->name      = $walkin->name;
        $this->email     = $walkin->email;
        $this->phone     = $walkin->phone;
        $this->service   = $walkin->service;
        $this->schedule  = Carbon::parse($walkin->schedule)->format('Y-m-d\TH:i');
        $this->note      = $walkin->note;
        $this->address   = $walkin->address;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function viewInvoice()
    {
        return view('admin.dashboard');
    }

    public function show($id)
    {
        $this->updatedMode = true;
        $walkin = Walkin::findOrFail($id);
        $this->walkin_id = $walkin->id;
    }

    public function delete($id)
    {
        Walkin::findOrFail($id)->delete();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Walk-In Deleted',
            'timer'     =>  5000,
            'icon'      =>  'warning',
            'toast'     =>  true,
            'position'  =>  'top-right'
        ]);
        $this->resetInputFields();
        $this->emit('modalDelete');/*Close Modal*/
    }

    public function render()
    {
        $this->fetchData();
        return view('admin.walkin',[
            'item'       => $this->walkin,
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3),
            'services'   => $this->services
        ]);
    }
}
