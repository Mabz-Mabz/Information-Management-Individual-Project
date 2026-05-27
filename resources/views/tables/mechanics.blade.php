@extends('template.main')
@section('title')
Mechanics
@endsection
@section('content')


<div class="container mt-5">

    <h2 class="mb-4">Mechanics</h2>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Add Mechanic Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMechanicModal">
        Add Mechanic
    </button>

    {{-- Mechanic Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Mechanic ID</th>
                        <th>Mechanic Name</th>
                        <th>Contact Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mechanics as $mechanic)
                    <tr>
                        <td>{{ $mechanic->mechanic_id }}</td>
                        <td>{{ $mechanic->name }}</td>
                        <td>{{ $mechanic->contact_info }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editMechanicModal{{ $mechanic->mechanic_id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('mechanics.destroy', $mechanic->mechanic_id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this mechanic?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal per row --}}
                    <div class="modal fade" id="editMechanicModal{{ $mechanic->mechanic_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Mechanic</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('mechanics.update', $mechanic->mechanic_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $mechanic->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Info</label>
                                            <input type="text" name="contact_info" class="form-control"
                                                value="{{ $mechanic->contact_info }}" required>
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
                        <td colspan="9" class="text-center text-muted">No Mechanics found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Mechanic Modal --}}
    <div class="modal fade" id="addMechanicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Mechanic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('mechanics.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mechanic Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Info</label>
                            <input type="text" name="contact_info" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add mechanic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>



@endsection