<?php
namespace App\Http\Livewire\Employee;
use Livewire\Component;
use App\Models\User;

class ELivewireDashboard extends Component
{
    public function render()
    {
        return view('employee.dashboard');
    }
}
