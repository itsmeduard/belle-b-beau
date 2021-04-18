<?php
namespace App\Http\Livewire\Admin;
use Livewire\{Component, WithPagination, WithFileUploads};
use Illuminate\Support\Facades\Storage;
use App\Models\{Appointment, Employee};
use Carbon\Carbon,File;


class ALivewireEmployee extends Component
{
    use WithPagination, WithFileUploads;/*User Livewire Pagination*/
    protected $paginationTheme = 'bootstrap';/*Use Bootstrap theme pagination*/

    /*Get Data in a safe way*/
    protected $employees, $appt;

    public $sortBy = 'created_at';/*Sort With Column*/
    public $sortDirection = 'desc';/*Latest Item*/
    public $perPage = '10';/*Page Pagination*/

    /*For Searching Item*/
    public $search='';
    protected $queryString = ['search'];

    /*Item*/
    public $emp_id, $name, $email, $address, $mobile, $photo, $newPhoto, $editPhoto, $status, $hidden_image;

    public $updateMode = false;

    public function fetchData()
    {
        /*Get Employees Data to Tables*/
        $employee = Employee::where(fn($query) => $query
            ->where(  'name',  'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('mobile', 'like', '%' . $this->search . '%')
            ->orWhere('address', 'like', '%' . $this->search . '%')
        )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        $this->employees = $employee;

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
        $this->name    = '';
        $this->email   = '';
        $this->address = '';
        $this->mobile  = '';
        $this->status  = '';
        $this->photo   = '';
        $this->newPhoto  = '';
        $this->editPhoto = '';
    }

    public function store()
    {
        $this->validate([
            'name'    => 'required',
            'email'   => 'required',
            'address' => 'required',
            'mobile'  => 'required',
            'status'  => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], ['required'  => 'The :attribute field is required']);

        $photo = Carbon::now()->timestamp. '.' . $this->photo->extension();
        Employee::updateOrInsert([
            'name'   => ucfirst($this->name),
            'email'  => $this->email,
        ], [
            'address' => $this->address,
            'mobile'  => $this->mobile,
            'photo'   => $this->photo->storeAs('public/photo', $photo),
            'status'  => $this->status,
            'deleted_at' => null,
        ]);/* Retrieve record if exist via deleted_at */
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Employee Created',
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
        $employee = Employee::findOrFail($id);
        $this->emp_id     = $id;
        $this->name       = $employee->name;
        $this->email      = $employee->email;
        $this->address    = $employee->address;
        $this->mobile     = $employee->mobile;
        $this->editPhoto  = $employee->photo;
        $this->status     = $employee->status;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update($id)
    {
        $this->validate([
            'name'    => 'required',
            'email'   => 'required',
            'address' => 'required',
            'mobile'  => 'required',
            'status'  => 'required',
            'newPhoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ],['required' => 'The :attribute field is required']);

        $employee = Employee::findOrFail($id);

        /*Delete old image here*/
        Storage::delete($employee->photo);
        if(file_exists(Storage::url($employee->photo))){
            unlink(Storage::url($employee->photo));
        }

        $newPhoto = Carbon::now()->timestamp. '.' . $this->newPhoto->extension();

        $employee->update([
            'name'    => ucfirst($this->name),
            'email'   => $this->email,
            'address' => $this->address,
            'mobile'  => $this->mobile,
            'photo'   => $this->newPhoto->storeAs('public/photo', $newPhoto),
            'status'  => $this->status,
        ]);
        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Employee Updated',
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
        $employee = Employee::findOrFail($id);
        $this->emp_id = $employee->id;
    }

    public function delete($id)
    {
        /*Apply SoftDelete Here*/
        Employee::findOrFail($id)->delete();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('swal', [
            'title'     =>  'Employee Deleted',
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

        return view('admin.employee',[
            'item'       => $this->employees,
            'notifCount' => count($this->appt),
            'appt'       => $this->appt->take(3)
        ]);
    }
}
