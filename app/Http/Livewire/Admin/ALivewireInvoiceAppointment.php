<?php
namespace App\Http\Livewire\Admin;
use App\Models\{Appointment,InvoiceAppointment};
use Livewire\{Component,WithPagination};

class ALivewireInvoiceAppointment extends Component
{
    use WithPagination;/*User Livewire Pagination*/
    protected $paginationTheme = 'bootstrap';/*Use Bootstrap theme pagination*/

    /*Get Data in a safe way*/
    protected $invoices, $appt;

    public $sortBy = 'created_at';/*Sort With Column*/
    public $sortDirection = 'desc';/*Latest Item*/
    public $perPage = '10';/*Page Pagination*/

    /*For Searching Item*/
    public $search='';
    protected $queryString = ['search'];

    /*Item*/
    public $invoice_id, $name, $email, $phone, $service, $schedule, $note, $address, $invoice_number, $detail_id, $total, $type;

    public function fetchData()
    {
        /*Get Services Data to Tables*/
        $invoice = InvoiceAppointment::leftjoin('appointments','appointments.id','invoice_appointment.detail_id')
        ->where(fn($query) => $query
                ->where(  'name',  'like', '%' . $this->search . '%')
                ->orWhere('invoice_number', 'like', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $this->invoices = $invoice;

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
        $this->service  = '';
        $this->schedule = '';
        $this->note     = '';
        $this->address  = '';
        $this->invoice_number  = '';
        $this->total  = '';
        $this->type  = '';
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $invoice = Invoice::findOrFail($id);
        $this->invoice_id       = $id;
        $this->name             = $invoice->name;
        $this->email            = $invoice->email;
        $this->phone            = $invoice->phone;
        $this->service          = $invoice->service;
        $this->schedule         = $invoice->schedule;
        $this->note             = $invoice->note;
        $this->address          = $invoice->address;
        $this->invoice_number   = $invoice->invoice_number;
        $this->type             = $invoice->type;
        $this->total            = number_format($invoice->total / 100, 2);
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function show($id)
    {
        $this->updatedMode = true;
        $invoice = Invoice::findOrFail($id);
        $this->invoice_id = $invoice->id;
    }

    public function render()
    {
        $this->fetchData();

        return view('admin.invoice_appointment',[
            'item'       => $this->invoices,
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3)
        ]);
    }
}
