@extends('layouts.master')

@section('title', __('Listing Counts Report ( DB )'))

@push('css')
<style>
    hr {
        border: 1px solid #ccc;
        width: 104%;
        height: 0px !important;
        margin-top: 0px;
    }
    
    .pagination {
        justify-content:end;
    }
</style>
@endpush

@section('content')
<div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-column">
                    <div class="d-flex w-100 justify-content-between mb-4">
                        <h2 class="card-title">Listing Counts Report ( DB )</h2>
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <form action="{{ route('profile.listing') }}" method="GET" id='status_form'>
                                    <input type="hidden" name="status" value="{{ request()->status }}">
                                    <input type="hidden" name="user" value="{{ request()->user }}">
                                    <input type="hidden" name="from" value="{{ request()->from }}">
                                    <input type="hidden" name="to" value="{{ request()->to }}">
                                    <label>
                                        Newly Created
                                        <input type="radio" {{ request()->status_listing == 'Created' ? 'checked' : '' }} name="status_listing" class='status_listing' value="Created" />
                                    </label>
        
                                    <label>
                                        Old Updated 
                                        <input type="radio" {{ request()->status_listing == 'Edited' ? 'checked' : '' }} name="status_listing" value="Edited" class='status_listing' />
                                    </label>
                                </form>
                            </div>
                            <a href="{{ route('profile.listing', ['user' => request()->user, 'status' => 0, 'from' => request()->from, 'to' => request()->to, 'status_listing' => request()->status_listing]) }}" class="btn btn-sm btn-warning position-relative me-2 mb-2"> Pending
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $pending }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                            <a href="{{ route('profile.listing', ['user' => request()->user, 'status' => 1,'from' => request()->from, 'to' => request()->to, 'status_listing' => request()->status_listing]) }}" class="btn btn-sm btn-success position-relative me-2 mb-2"> Approved
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$approved}}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                            <a href="{{ route('profile.listing', ['user' => 'all', 'status' => 2,'from' => request()->from, 'to' => request()->to, 'status_listing' => request()->status_listing]) }}" class="btn btn-sm btn-danger position-relative mb-2"> Rejected
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$rejected}}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <hr />

                    <div class="d-flex w-100" style="grid-gap: 10px;;">
                        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Super Management'))
                        <form action="" method="get" id='form' class="d-flex align-items-center" style="width: 100%;grid-gap: 10px;">
                            <input type='hidden' name='status_listing' value='{{ request()->status_listing }}' />
                            <input type="hidden" name="status" value="">
                            <b class="text-end mr-2">User Filter - </b>
                            <select class="form-control w-25" name="user" id='user'>
                                <option value="all">All Users</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{ $user->id == request()->user ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group w-50">
                                <label class="m-2">Start Date</label>
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div><input class="form-control fc-datepicker" value="{{ request()->from }}" name="from" placeholder="DD/MM/YYYY" type="text">
                            </div>
                            <div class="input-group w-50">
                            <label class="m-2">End Date</label>
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div><input class="form-control fc-datepicker" value="{{ request()->to }}" name="to" placeholder="DD/MM/YYYY" type="text">
                            </div>
                            <button class="btn btn-primary w-15" type="submit">Filter</button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatable" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    @can('Inventory -> Counts Report -> Delete')
                                    <th><input type="checkbox" class="check-all" /></th>
                                    @endcan
                                    <th>{{ __('Sl') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Product Title') }}</th>
                                    <th>{{ __('Created by') }}</th>
                                    <th>{{ __('Created at') }}</th>
                                    <th>{{ __('Approved by') }}</th>
                                    <th>{{ __('Approved at') }}</th>
                                    <th>{{ __('Current Status') }}</th>
                                    @can('Inventory -> Counts Report -> Delete')
                                    <th>{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userListings as $key => $userListing)
                                <tr>
                                    @can('Inventory -> Counts Report -> Delete')
                                    <td>
                                        <input type="checkbox" name="ids" class="checkbox-update" value="{{$userListing->id}}" />
                                    </td>
                                    @endcan
                                    <td>{{ ++$key }}</td>
                                    <td><img onerror="this.onerror=null;this.src='/dummy.jpg';" src="{{ $userListing->image }}" alt="Product Image" width="50" /></td>
                                    <td>{{ $userListing->title }}</td>
                                    <td>{{ $userListing->create_user->name }}</td>
                                    <td>{{ date("d-m-Y h:i A", strtotime($userListing->created_at)) }}</td>
                                    <td>
                                        @if($userListing->approved_by)
                                        {{ $userListing?->approve?->name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($userListing->approved_at)
                                        {{ date("d-m-Y h:i A", strtotime($userListing->approved_at)) }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($userListing->status == "0")
                                        <button class="btn btn-warning btn-sm">Pending</button>
                                        @elseif($userListing->status == 1)
                                        <button class="btn btn-success btn-sm">Approved</button>
                                        @elseif($userListing->status == 2)
                                        <button class="btn btn-danger btn-sm">Rejected</button>
                                        @endif
                                    </td>
                                    @can('Inventory -> Counts Report -> Delete')
                                    <td><a href="{{ route('profile.listing.delete.single', $userListing->id) }}" class="btn btn-primary btn-sm">Delete</a></td>
                                    @endcan
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                        {{ $userListings->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
<script src="/assets/js/table-data.js"></script>

<script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- TIMEPICKER JS -->
<script src="/assets/plugins/time-picker/jquery.timepicker.js"></script>
<script src="/assets/plugins/time-picker/toggles.min.js"></script>

<!-- DATEPICKER JS -->
<script src="/assets/plugins/date-picker/date-picker.js"></script>
<script src="/assets/plugins/date-picker/jquery-ui.js"></script>

<!-- COLOR PICKER JS -->
<script src="/assets/plugins/pickr-master/pickr.es5.min.js"></script>

<!-- FORMELEMENTS JS -->
<script src="/assets/js/form-elements.js"></script>

<script>
    $(document).ready(function() {
        //______Basic Data Table
        $('#basic-datatable').DataTable({
            "paging": false,
        });

        $("#category").on("change", function() {
            $("#form").submit();
        });

        // $("#user").change(function() {
        //     $("#form").submit();
        // });

        $("#basic-datatable_wrapper .col-sm-12:first").html('<form id="update-status" action="" method="GET"><div class="d-flex"><select class="form-control w-50" name="status"><option>Select</option><option value=1>Delete</option></select><button class="btn btn-primary update-status" style="margin-left:10px;">Update</button></div></form>');

        var ids = [];
        $(".checkbox-update").click(function() {
            if ($(this).prop('checked')) {
                ids.push($(this).val());
            } else {
                var index = ids.indexOf($(this).val());
                if (index !== -1) {
                    ids.splice(index, 1);
                }
            }
        });

        $(".table-responsive").on('click', '.update-status', function(e) {
            e.preventDefault();
            var formData = $('#update-status').serializeArray();
            formData.push(ids);

            if (ids.length <= 0) {
                alert('Please select any item')
                return true;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('profile.listing.delete') }}",
                data: {
                    formData: formData
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    if (result) {
                        window.location.href = location.href;
                    }
                },
            });
        });

        $('.check-all').click(function() {
            $(".checkbox-update").each(function() {
                if ($('.check-all').prop('checked') == true) {
                    $(this).prop('checked', true);
                    ids.push($(this).val());
                } else {
                    $(this).prop('checked', false);
                    var index = ids.indexOf($(this).val());
                    if (index !== -1) {
                        ids.splice(index, 1);
                    }
                }
            });
        });
        
        $(".status_listing").click(function(){
            $('#status_form').submit();
        })
    })
</script>

@endpush