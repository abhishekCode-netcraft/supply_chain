@extends('layouts.master')

@section('title', __('Roles'))

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">{{ __('Assign Permissions to Roles') }}</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('roles') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Index') }}</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">
                            {{ __('Assign Permissions to Roles') }}
                        </h4>

                        <!-- @can('Role create')
                            <a href="{{ route('roles.create') }}"
                                class="btn btn-primary float-right">{{ __('Create Role') }}</a>
                        @endcan -->
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Role Name') }}</th>
                                        <th>{{ __('Permissions') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $index => $permission)
                                                <span class="badge bg-primary">{{ $permission->name }}</span>
                                                @if (($index + 1) % 5 == 0)
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group"
                                                aria-label="{{ __('Actions') }}">
                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                    class="btn btn-primary">{{ __('EDIT') }}</a>

                                                <button type="button"
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}') ? document.getElementById('delete-role').submit() : false;"
                                                    class="btn btn-danger">{{ __('DELETE') }}</button>
                                                <form action="{{ route('roles.destroy', $role->id) }}" id="delete-role"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('No records found.') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection
