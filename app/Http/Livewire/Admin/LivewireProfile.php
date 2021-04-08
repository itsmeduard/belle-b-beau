<?php
namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\{Appointment, User};

class LivewireProfile extends Component
{
    public $old_pass, $new_pass, $repeat_pass, $user_id;

    private function resetInputFields()
    {
        $this->old_pass    = '';
        $this->new_pass    = '';
        $this->repeat_pass = '';
    }

    public function change()
    {
        $this->validate([
            'old_pass'    => 'required',
            'new_pass'    => 'required',
            'repeat_pass' => 'same:new_pass',
        ],['required'   => 'The :attribute field is required']);

        $user = User::findOrFail(auth()->user()->id);

        if( (!\Hash::check($this->old_pass, $user->password) ) ) {
            $this->dispatchBrowserEvent('swal', [
                'title'     =>  'Incorrect Password',
                'timer'     =>  5000,
                'icon'      =>  'warning',
                'toast'     =>  true,
                'position'  =>  'top-right'
            ]);
        }else{
            $user->update([
                'password'   => bcrypt($this->new_pass),
            ]);
            $this->dispatchBrowserEvent('swal', [
                'title'     =>  'Password Updated',
                'timer'     =>  5000,
                'icon'      =>  'success',
                'toast'     =>  true,
                'position'  =>  'top-right'
            ]);
        }
        $this->resetInputFields();
    }

    public function render()
    {
        $appt = Appointment::latest()->get();
        return view('admin.profile', [
            'notifCount' => count($appt),
            'appt'       => $appt->take(3)
        ]);
    }
}
