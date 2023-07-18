<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="table" class="form-label mr-2">Table:</label>
                    <select wire:model="table" id="table"
                        class="form-control form-select select @error('table') is-invalid @enderror">
                        <option value="">All</option>
                        @foreach ($tables as $table)
                            <option value="{{ $table }}">{{ ucfirst(str_replace('_', ' ', $table)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="event" class="form-label mr-2">Event:</label>
                    <select wire:model="event" id="event"
                        class="form-control form-select select @error('event') is-invalid @enderror">
                        <option value="all">All</option>
                        <option value="login">Login</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                        <option value="logout">Logout</option>
                        <option value="lockout">Lockout</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="userId" class="form-label mr-2">Users:</label>
                    <select wire:model="userId" id="userId"
                        class="form-control form-select select @error('userId') is-invalid @enderror">
                        <option value="">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div wire:ignore class="form-group col col-md-3">
                    <label for="ua_daterange" class="form-lable mb-2">DateTime</label>
                    <div id="ua_daterange" class="form-control form-select">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>
                    </div>
                </div>

                <div class="form-group col-md-1 ms-auto">
                    <label for="perPage" class="form-label mr-2"></label>
                    <select wire:model="perPage" id="perPage"
                        class="form-control form-select @error('perPage') is-invalid @enderror">
                        <option value="all">All</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="250">250</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-secondary">
                        <tr>
                            <th>S.N</th>
                            <th>
                                <a href="#" wire:click="sortBy('table')" class="sort-link text-dark">
                                    Table
                                    @if ($sortField === 'table')
                                        @if ($sortDirection === 'asc')
                                            <i class="fa fa-sort-asc sort-icon"></i>
                                        @else
                                            <i class="fa fa-sort-desc sort-icon"></i>
                                        @endif
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click="sortBy('event')" class="sort-link text-dark">
                                    Event
                                    @if ($sortField === 'event')
                                        @if ($sortDirection === 'asc')
                                            <i class="fa fa-sort-asc sort-icon"></i>
                                        @else
                                            <i class="fa fa-sort-desc sort-icon"></i>
                                        @endif
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click="sortBy('users.name')" class="sort-link text-dark">
                                    User Name
                                    @if ($sortField === 'users.name')
                                        @if ($sortDirection === 'asc')
                                            <i class="fa fa-sort-asc sort-icon"></i>
                                        @else
                                            <i class="fa fa-sort-desc sort-icon"></i>
                                        @endif
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click="sortBy('ip_address')" class="sort-link text-dark">
                                    IP
                                    @if ($sortField === 'ip_address')
                                        @if ($sortDirection === 'asc')
                                            <i class="fa fa-sort-asc sort-icon"></i>
                                        @else
                                            <i class="fa fa-sort-desc sort-icon"></i>
                                        @endif
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click="sortBy('created_at')" class="sort-link text-dark">
                                    Timestamp
                                    @if ($sortField === 'created_at')
                                        @if ($sortDirection === 'asc')
                                            <i class="fa fa-sort-asc sort-icon"></i>
                                        @else
                                            <i class="fa fa-sort-desc sort-icon"></i>
                                        @endif
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($userActivities as $activity)
                            <tr>
                                <td scope="row">
                                    {{ ($userActivities->currentPage() - 1) * $userActivities->perPage() + $loop->index + 1 }}
                                </td>
                                <td>{{ ucfirst($activity->table) }}</td>
                                <td>{{ $activity->event }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{ $activity->ip_address }}</td>
                                <td>
                                    {{ $activity->created_at->format('Y-m-d H:i:s') }}
                                    ({{ $activity->created_at->diffForHumans() }})
                                </td>
                                <td>
                                    <button
                                        wire:click="getDialogContent({{ $activity->id }})"
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-toggle="modal" 
                                        data-target="#userActivityModal"
                                        data-bs-target="#userActivityModal">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $userActivities->links() }}
        </div>
    </div>
    <div class="modal fade" id="userActivityModal" aria-labelledby="userActivityDetails" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userActivityDetails">User Activity Details</h1>
                    <button type="button" class="btn-close close" data-dismiss="modal"  data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                @if ($viewActivity)
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Name</th>
                                            <th>{{ $viewActivity->name }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope="row">IP</td>
                                            <td>{{ $viewActivity->ip_address }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">User Agent</td>
                                            <td style="color: #030303">{{ $viewActivity->user_agent }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Event Table</td>
                                            <td>{{ $viewActivity->table }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Event</td>
                                            <td>{{ $viewActivity->event }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Event Time</td>
                                            <td>{{ $viewActivity->created_at }}
                                                ({{ $viewActivity->created_at->diffForHumans() }})</td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            {{ $this->diffrence }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- blade code --}}
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                var start = moment(@js($startDate));
                var end = moment(@js($endDate));

                function cb(start, end) {
                    @this.set('startDate', start.format('YYYY-MM-DD') + ' ' + start.format('HH:mm:ss'));
                    @this.set('endDate', end.format('YYYY-MM-DD') + ' ' + end.format('HH:mm:ss'));
                    $('#ua_daterange span').html(start.format('MM D, YYYY') + ' - ' + end.format('MM D, YYYY'));
                }

                $('#ua_daterange').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 5,
                    timePicker24Hour: true,
                    startDate: start,
                    endDate: end,
                    ranges: {
                        ' Today': [moment().startOf('day'), moment().endOf('day')],
                        ' Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                        ' Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                        ' This Month': [moment().startOf('month'), moment().endOf('month')],
                        ' Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    }
                }, cb);

                cb(start, end);
            });
        </script>
    @endpush
