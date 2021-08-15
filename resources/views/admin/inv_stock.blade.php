<div>
    {{-- Top Navbar --}}
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
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('log-out') }}"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Service Table --}}
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Services</h3>
            <a class="btn btn-primary btn-icon-split" role="button" data-toggle="modal" data-target="#exampleModal">
                <span class="text-white-50 icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text-white text">New Service</span>
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Services Table</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div class="dataTables_length" aria-controls="dataTable">
                            <label>Show&nbsp;
                                <select wire:model="perPage" class="form-control form-control-sm custom-select custom-select-sm">
                                    <option value="10" selected="">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right">
                            <label>
                                <input class="form-control form-control-sm" wire:model="search" type="search" placeholder="Search Service...">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table mt-2">
                    <table class="table table-hover my-0">
                        <thead>
                            <th style="cursor: pointer;" scope="col" wire:click="sortBy('service')"><i data-mdb-sort="field_1" class="datatable-sort-icon fas fa-arrow-up" style="transform: rotate(0deg);"></i> Service</th>
                            <th style="cursor: pointer;" scope="col" wire:click="sortBy('category')"><i data-mdb-sort="field_1" class="datatable-sort-icon fas fa-arrow-up" style="transform: rotate(0deg);"></i> Category</th>
                            <th style="cursor: pointer;" scope="col" wire:click="sortBy('price')"><i data-mdb-sort="field_1" class="datatable-sort-icon fas fa-arrow-up" style="transform: rotate(0deg);"></i> Price</th>
                            <th style="cursor: pointer;" scope="col" wire:click="sortBy('status')"><i data-mdb-sort="field_1" class="datatable-sort-icon fas fa-arrow-up" style="transform: rotate(0deg);"></i> Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @forelse($item as $serv)
                            <tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $serv->id }}">
                                <td>{{$serv->service}}</td>
                                <td>{{$serv->category}}</td>
                                <td>₱{{number_format($serv->price / 100, 2)}}</td>
                                @if($serv->status == 'Active')<td><span class="alert-success">{{$serv->status}}</span></td>
                                @elseif($serv->status == 'Disable')<td><span class="alert-danger">{{$serv->status}}</span></td>
                                @endif
                                <td>
                                    <a class="btn btn-success btn-icon-split" role="button" data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $serv->id }})">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text-white text">Edit</span>
                                    </a>
                                    <a class="btn btn-danger btn-icon-split" role="button" data-toggle="modal" data-target="#deleteModal" wire:click="show({{ $serv->id }})">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text-white text">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            No Record Found...
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing {{ $item->firstItem() }} to  {{ $item->lastItem() }} out of  {{ $item->total() }}</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                {{ $item->onEachSide(4)->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Service Modal --}}
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Service</label>
                            <input type="text" class="form-control" wire:model="service" placeholder="Enter Service" maxlength='50'>
                            @error('service') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control custom-select" wire:model="category">
                                <option value=''>--Select Category--</option>
                                <option value='Face'>Face</option>
                                <option value='Nails'>Nails</option>
                                <option value='Cautery'>Cautery</option>
                                <option value='Waxing'>Waxing</option>
                                <option value='RF Cavitation'>RF Cavitation</option>
                                <option value='Eyelashes Extension'>Eyelashes Extension</option>
                                <option value='Hair'>Hair</option>
                                <option value='Hair & Make Up'>Hair & Make Up</option>
                            </select>
                            @error('category') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control number" name='price' wire:model="price" placeholder='Enter Price' maxlength='6' autocomplete='off'>
                            @error('price') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control custom-select" wire:model="status">
                                <option value=''>--Select Status--</option>
                                <option value='Active'>Active</option>
                                <option value='Disable'>Disable</option>
                            </select>
                            @error('status') {{ $message }} @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-up"></i> Close</button>
                    <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal"><i class="fa fa-plus"></i> Add service</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Service Modal --}}
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Service</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" wire:model="service_id">
                            <label>Service</label>
                            <input type="text" class="form-control" wire:model="service" placeholder="Enter Service" maxlength='50'>
                            @error('service') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control custom-select" wire:model="category">
                                <option value='Face'>Face</option>
                                <option value='Nails'>Nails</option>
                                <option value='Cautery'>Cautery</option>
                                <option value='Waxing'>Waxing</option>
                                <option value='RF Cavitation'>RF Cavitation</option>
                                <option value='Eyelashes Extension'>Eyelashes Extension</option>
                                <option value='Hair'>Hair</option>
                                <option value='Hair & Make Up'>Hair & Make Up</option>
                            </select>
                            @error('category') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control number" name='price' wire:model="price" placeholder='Enter Price' maxlength='6' autocomplete='off'>
                            @error('price') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control custom-select" wire:model="status">
                                <option value='Active'>Active</option>
                                <option value='Disable'>Disable</option>
                            </select>
                            @error('status') {{ $message }} @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-up"></i> Close</button>
                    <button type="button" wire:click.prevent="update()" class="btn btn-success close-modal"><i class="fa fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Service Modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash"></i> Delete Service</h5>
             </div>
             <div class="modal-body">
              <div class="alert alert-danger" role="alert">
                 <p>Are you sure you? This action is irreversible.</p>
              </div>
             </div>
             <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-up"></i> Close</button>
                <button type="button" wire:click.prevent="delete({{ $service_id}})" class="btn btn-danger close-modal"><i class="fa fa-trash"></i> Delete</button>
             </div>
          </div>
       </div>
    </div>
</div>


