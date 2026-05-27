@extends('template.main')
@section('title')
Users & Roles
@endsection
@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Users & Roles</h2>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Add User Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Add User
    </button>

    {{-- Users Table --}}
    <div class="card mb-5">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge
                                @if($user->role === 'admin') bg-danger
                                @elseif($user->role === 'salesperson') bg-primary
                                @elseif($user->role === 'mechanic') bg-warning text-dark
                                @elseif($user->role === 'service_staff') bg-info text-dark
                                @else bg-secondary
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            @if(auth()->id() != $user->id)
                            <form method="POST"
                                action="{{ route('users.destroy', $user->id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @else
                            <span class="text-muted" style="font-size:0.8rem;">Current User</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $user->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">
                                                New Password
                                                <small class="text-muted">(leave blank to keep current)</small>
                                            </label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <select name="role" class="form-select" required>
                                                @foreach($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ $user->role === $role ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Permissions Matrix --}}
    <h4 class="mb-3">Roles & Permissions</h4>
    <div class="card mb-5">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Permission</th>
                        @foreach($roles as $role)
                        <th class="text-center">{{ ucfirst(str_replace('_', ' ', $role)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach(array_keys($permissions['admin']) as $permission)
                    <tr>
                        <td>{{ $permission }}</td>
                        @foreach($roles as $role)
                        <td class="text-center">
                            @if($permissions[$role][$permission])
                            <span class="text-success fw-bold">✓</span>
                            @else
                            <span class="text-danger">✗</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add User Modal --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                <option value="{{ $role }}">
                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection