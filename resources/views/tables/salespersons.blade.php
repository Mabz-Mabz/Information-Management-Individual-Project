@extends('template.main')
@section('title')
Salesperson
@endsection
@section('content')



<div class="container mt-5">

    <h2 class="mb-4">Salesperson</h2>

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

    {{-- Add Salesperson Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSalespersonModal">
        Add Salesperson
    </button>

    {{-- Salesperson Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Salesperson ID</th>
                        <th>Salesperson Name</th>
                        <th>Contact Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salespersons as $salesperson)
                    <tr>
                        <td>{{ $salesperson->salesperson_id }}</td>
                        <td>{{ $salesperson->name }}</td>
                        <td>{{ $salesperson->contact_info }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editSalespersonModal{{ $salesperson->salesperson_id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('salespersons.destroy', $salesperson->salesperson_id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this salesperson?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal per row --}}
                    <div class="modal fade" id="editSalespersonModal{{ $salesperson->salesperson_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Salesperson</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('salespersons.update', $salesperson->salesperson_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $salesperson->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Info</label>
                                            <input type="text" name="contact_info" class="form-control"
                                                value="{{ $salesperson->contact_info }}" required>
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
                        <td colspan="9" class="text-center text-muted">No Salesperson found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Salesperson Modal --}}
    <div class="modal fade" id="addSalespersonModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add salesperson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('salespersons.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Salesperson Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Info</label>
                            <input type="text" name="contact_info" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Salesperson</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>



@endsection