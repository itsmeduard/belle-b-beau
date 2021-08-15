<div>
    <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top" style="background: rgb(255, 255, 255);">
        <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
            <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <div class="input-group-append"><button class="btn btn-primary border rounded-0 py-0" data-toggle="tooltip" data-bss-tooltip="" data-placement="right" id="sidebarToggle" type="button" title="Collapse/Expand" style="background: #fe7fe7;"><i class="fas fa-bars"></i></button></div>
                </div>
            </form>
            <ul class="navbar-nav flex-nowrap ml-auto">
                <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                    <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto navbar-search w-100">
                            <div class="input-group">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown no-arrow mx-1">
                    <div class="nav-item dropdown no-arrow">
                        <a class="dropdown-toggle swing animated infinite nav-link" aria-expanded="false" data-toggle="dropdown" href="#">
                            <span class="badge badge-danger badge-counter">{{ $notifCount }}</span>
                            <i class="fas fa-bell fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-list animated--grow-in" wire:poll.10s>
                            <h6 class="dropdown-header">Appointments</h6>
                            @forelse($appt as $appt)
                                <a class="dropdown-item d-flex align-items-center" href="{{route('admin.appointment')}}">
                                    <div class="mr-3">
                                        <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                    </div>
                                    <div><span class="small text-gray-500">{{ $appt->created_at }}</span>
                                        <p>{{ ucfirst($appt->name) }}, {{ $appt->service }}</p>
                                    </div>
                                </a>
                            @empty
                                No record found...
                            @endforelse
                            <a class="dropdown-item text-center small text-gray-500" href="{{route('admin.appointment')}}">Show All Appointment</a>
                        </div>
                    </div>
                </li>
                <div class="d-none d-sm-block topbar-divider"></div>
                <li class="nav-item dropdown no-arrow">
                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small" style="color: rgb(133, 135, 150);">{{ Auth::user()->name }}</span><img class="border rounded-circle img-profile" src="{{ asset('panelAssets/img/download.png') }}"></a>
                        <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="{{route('admin.profile')}}"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('log-out')}}"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    {{-- Profile Table --}}
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Report</h3>
        </div>
        <div class="row mb-3">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-bold">Date</p>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>
                                                    <strong>Report Type</strong>
                                                </label>
                                                <select class="form-control custom-select" wire:model="report_type">
                                                    <option value=''>--Select Category--</option>
                                                    <option value='Appointment'>Appointment</option>
                                                    <option value='Walkin'>Walkin</option>
                                                    <option value='Invoice Appointment'>Invoice Appointment</option>
                                                    <option value='Invoice Walkin'>Invoice Walkin</option>
                                                </select>
                                                @error('report_type') {{ $message }} @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>
                                                    <strong>Date From</strong>
                                                </label>
                                                <input class="form-control" type="date"
                                                       wire:model='date_from' name="date_from">
                                                @error('date_from') {{ $message }} @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>
                                                    <strong>Date To</strong>
                                                </label>
                                                <input class="form-control" type="date"
                                                       wire:model='date_to' name="date_to">
                                                @error('date_to') {{ $message }} @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" wire:click.prevent="export_excel()" class="btn btn-success">Export to Excel</button>
                                        <button type="button" wire:click.prevent="export_pdf()" class="btn btn-success">Export to PDF</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


