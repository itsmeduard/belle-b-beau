<?php
namespace App\Http\Livewire\Admin;

use App\Models\{Appointment,Service};
use Livewire\{Component,WithPagination};

class LivewireService extends Component
{
    use WithPagination;/*User Livewire Pagination*/
    protected $paginationTheme = 'bootstrap';/*Use Bootstrap theme pagination*/

    /*Get Data in a safe way*/
    protected $services, $appt;

    public $sortBy = 'created_at';/*Sort With Column*/
    public $sortDirection = 'desc';/*Latest Item*/
    public $perPage = '10';/*Page Pagination*/

    /*For Searching Item*/
    public $search='';
    protected $queryString = ['search'];

    /*Item*/
    public $service_id, $service, $category, $price, $status;

    public $updateMode = false;

    public function fetchData()
    {
        /*Get Services Data to Tables*/
        $service = Service::where(fn($query) => $query
                ->where(  'service',  'like', '%' . $this->search . '%')
                ->orWhere('category', 'like', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        $this->services = $service;

        /*For notifications*/
        $appoint = Appointment::leftjoin('appointment_status as apts','apts.appt_id','appointments.id')
            ->where('apts.status','1')
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
        $this->service  = '';
        $this->category = '';
        $this->price    = '';
        $this->status   = '';
    }

    public function store()
    {
        $this->validate([
            'service'   => 'required',
            'category'  => 'required',
            'price'     => 'required',
            'status'    => 'required',
        ], ['required'  => 'The :attribute field is required']);
        Service::updateOrInsert([
            'service'   => $this->service,
            'category'  => $this->category,
        ],
        [
            'price'     => $this->price * 100,
            'status'    => $this->status,
            'deleted_at' => null,
        ]);/* Retrieve record if exist via deleted_at */
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Service Created',
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
        $service = Service::findOrFail($id);
        $this->service_id = $id;
        $this->service    = $service->service;
        $this->category   = $service->category;
        $this->price      = number_format($service->price / 100, 2);
        $this->status     = $service->status;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate([
            'service'   => 'required',
            'category'  => 'required',
            'price'     => 'required',
            'status'    => 'required',
        ],['required'   => 'The :attribute field is required']);

        $service = Service::findOrFail($this->service_id);
        $price = str_replace(",","", $this->price );
        $service->update([
            'service'   => $this->service,
            'category'  => $this->category,
            'price'     => $price * 100,
            'status'    => $this->status,
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

    public function show($id)
    {
        $this->updatedMode = true;
        $service = Service::findOrFail($id);
        $this->service_id = $service->id;
    }

    public function delete($id)
    {
        /*Apply SoftDelete Here*/
        Service::findOrFail($id)->delete();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Service Deleted',
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

        return view('admin.service',[
            'item'       => $this->services,
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3)
        ]);
    }
}
