@extends('template.main')
@section('title')
Parts
@endsection
@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Parts</h2>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Add Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPartsModal">
        Add Parts
    </button>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Part ID</th>
                        <th>Part Name</th>
                        <th>Part Number</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parts as $part)
                    <tr>
                        <td>{{ $part->part_id }}</td>
                        <td>{{ $part->part_name }}</td>
                        <td>{{ $part->part_number }}</td>
                        <td>{{ $part->cost }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editPartsModal{{ $part->part_id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('parts.destroy', $part->part_id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this service ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editPartsModal{{ $part->part_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Parts</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('parts.update', $part->part_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Part Name</label>
                                            <input type="text" name="part_name" class="form-control"
                                                value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Part Number</label>
                                            <input type="text" name="part_number" class="form-control"
                                                value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cost</label>
                                            <input type="number" name="cost" class="form-control"
                                                value="" required>
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
                        <td colspan="5" class="text-center text-muted">No parts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addPartsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Parts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('parts.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Part Name</label>
                            <input type="text" name="part_name" class="form-control"
                                value="" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Part Number</label>
                            <input type="text" name="part_number" class="form-control"
                                value="" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cost</label>
                            <input type="number" name="cost" class="form-control"
                                value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Parts</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection