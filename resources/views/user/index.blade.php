@extends('layouts.master')

@section('title', __("Dashboard"))

@can('Manage User')
@section('content')

<div class="card shadow-sm">
  <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold m-0">Users</h2>
      <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
    </div>

    <form class="row g-2 mb-3" method="GET">
      <div class="col-auto">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
          placeholder="Search name/email/mobile">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-secondary">Search</button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Name / Email</th>
            <th>Mobile</th>
            <th>Business Name/ Email</th>
            <th>Business Address</th>
            <th>Email Verified</th>
             <th>OTP Features</th>
            <th>Active</th>
            <th>Role</th>
            <th width="220">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
            <td>
              <div class="fw-semibold">{{ $u->name }}</div>
              <div class="text-muted small">{{ $u->email }}</div>
            </td>
            <td>{{ $u->mobile }}</td>
            <td>
              <div class="fw-semibold">{{ $u->business_name }}</div>
              <div class="text-muted small">{{ $u->business_email }}</div>
            </td>
            <td>
              <div class="fw-semibold">{{ Str::limit($u->business_address, 40) }}</div>
            </td>
            <td>
              @if($u->email_verified_at)
              <span class="badge bg-success">Verified</span>
              @else
              <span class="badge bg-warning text-dark">Pending</span>
              @endif
            </td>
               <td>{{ $u->otp_feature ? 'Yes' : 'No' }}</td>
            <td>
              <form method="POST" action="{{ route('users.updateStatus', $u->id) }}" class="d-flex align-items-center" style="margin-left: 10px;">
                @csrf
                <div class="form-check form-switch">
                  <input type="hidden" name="is_active" value="0">
                  <input class="form-check-input" type="checkbox" name="is_active" value="1"
                    onchange="this.form.submit()" {{ $u->is_active ? 'checked' : '' }}>
                  <label class="form-check-label">
                    {{ $u->is_active ? 'Active' : 'Inactive' }}
                  </label>
                </div>
              </form>
            </td>
            <td>
                <form method="POST" action="{{ route('users.update.role', $u->id) }}" class="d-flex align-items-center" >
                    @csrf
                    @method('PUT')
                    
                    <select name="role_id" id='role' class="form-control" onchange="this.form.submit()">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $u->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </td>
            <td>
              <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('users.edit',$u->id) }}"
                  class="btn btn-sm btn-primary d-flex align-items-center gap-1 px-3">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form method="POST" action="{{ route('users.destroy',$u->id) }}"
                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger d-flex align-items-center gap-1 px-3">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center text-muted">No users found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div>
      {{ $users->links() }}
    </div>

  </div>
</div>

@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
        $("#role").change(function() {
            $(this).closest("form").submit();
        });
    });
  </script>
@endpush
@endcan