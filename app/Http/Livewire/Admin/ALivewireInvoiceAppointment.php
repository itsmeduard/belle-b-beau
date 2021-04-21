<?php
namespace App\Http\Livewire\Admin;
use App\Models\{Appointment,InvoiceAppointment};
use Livewire\{Component,WithPagination};
class ALivewireInvoiceAppointment extends Component
{
    use WithPagination;/*User Livewire Pagination*/
    protected $paginationTheme = 'bootstrap';/*Use Bootstrap theme pagination*/

    /*Get Data in a safe way*/
    protected $invappt, $appt;

    public $sortBy = 'created_at';/*Sort With Column*/
    public $sortDirection = 'desc';/*Latest Item*/
    public $perPage = '10';/*Page Pagination*/

    /*For Searching Item*/
    public $search='';
    protected $queryString = ['search'];

    /*Item*/
    public $appt_id, $name, $email, $phone, $address, $service, $schedule, $note, $total;

    public $updateMode = false;

    public function fetchData()
    {
        /*Get Services Data to Tables*/
        $invoice = InvoiceAppointment::leftjoin('appointments as appt','appt.id','invoice_appointment.detail_id')
            ->leftjoin('appointment_status as appt_stat','appt_stat.appt_id','invoice_appointment.detail_id')
            ->where(fn($query) => $query
                ->where(  'appt.name',  'like', '%' . $this->search . '%')
                ->orWhere('invoice_appointment.total', 'like', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        $this->invappt = $invoice;

        /*For notifications*/
        $appoint = Appointment::leftjoin('appointment_status as apts','apts.appt_id','appointments.id')
            ->where('apts.status','Pending')
            ->latest()->get();
        $this->appt = $appoint;
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
        $this->address  = '';
        $this->service  = '';
        $this->note     = '';
        $this->total    = '';
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $invappt = InvoiceAppointment::leftjoin('appointments as appt','appt.id','invoice_appointment.detail_id')
            ->leftjoin('appointment_status as appt_stat','appt_stat.appt_id','invoice_appointment.detail_id')
            ->where('appt_stat','Accepted')
            ->where('appt.id',$id)->get();
        $this->appt_id = $id;
        $this->name     = $invappt->name;
        $this->email    = $invappt->email;
        $this->phone    = $invappt->phone;
        $this->address  = $invappt->address;
        $this->schedule = $invappt->schedule;
        $this->note     = $invappt->note;
        $this->total    = $invappt->total;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function show($id)
    {
        $this->updatedMode = true;
        $invappt = InvoiceAppointment::leftjoin('appointments as appt','appt.id','invoice_appointment.detail_id')
            ->leftjoin('appointment_status as appt_stat','appt_stat.appt_id','invoice_appointment.detail_id')
            ->where('appt_stat','Accepted')
            ->where('appt.id',$id)->get();
        $this->appt_id = $invappt->id;
    }

    public function render()
    {
        $this->fetchData();

        return view('admin.invoice_appointment',[
            'item'       => $this->invappt,
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3)
        ]);
    }
}
