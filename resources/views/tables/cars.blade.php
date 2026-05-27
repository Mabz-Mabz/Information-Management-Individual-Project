@extends('template.main')
@section('title')
Home
@endsection
@section('content')


<div class="container mt-5">

    <h2 class="mb-4">Cars</h2>

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

    {{-- Add Car Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCarModal">
        Add Car
    </button>

    {{-- Cars Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Serial Number</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Salesperson</th>
                        <th>Customer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    <tr>
                        <td>{{ $car->serial_number }}</td>
                        <td>{{ $car->make }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->year }}</td>
                        <td>{{ ucfirst($car->type) }}</td>
                        <td>
                            <span class="badge 
                                    @if($car->status === 'available') bg-success
                                    @elseif($car->status === 'sold') bg-secondary
                                    @else bg-warning text-dark
                                    @endif">
                                {{ ucfirst(str_replace('_', ' ', $car->status)) }}
                            </span>
                        </td>
                        <td>{{ $car->salesperson_name ?? '-' }}</td>
                        <td>{{ $car->customer_name ?? '-' }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editCarModal{{ $car->serial_number }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('cars.destroy', $car->serial_number) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this car?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal per row --}}
                    <div class="modal fade" id="editCarModal{{ $car->serial_number }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Car</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('cars.update', $car->serial_number) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Serial Number</label>
                                            <input type="text" class="form-control"
                                                value="{{ $car->serial_number }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Make</label>
                                            <input type="text" name="make" class="form-control"
                                                value="{{ $car->make }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Model</label>
                                            <input type="text" name="model" class="form-control"
                                                value="{{ $car->model }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Year</label>
                                            <input type="number" name="year" class="form-control"
                                                value="{{ $car->year }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select name="type" class="form-select" required>
                                                <option value="new" {{ $car->type === 'new' ? 'selected' : '' }}>New</option>
                                                <option value="used" {{ $car->type === 'used' ? 'selected' : '' }}>Used</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="available" {{ $car->status === 'available' ? 'selected' : '' }}>Available</option>
                                                <option value="sold" {{ $car->status === 'sold' ? 'selected' : '' }}>Sold</option>
                                                <option value="in_service" {{ $car->status === 'in_service' ? 'selected' : '' }}>In Service</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Salesperson</label>
                                            <select name="salesperson_id" class="form-select">
                                                <option value="">-- None --</option>
                                                @foreach($salespersons as $s)
                                                <option value="{{ $s->salesperson_id }}"
                                                    {{ $car->salesperson_id == $s->salesperson_id ? 'selected' : '' }}>
                                                    {{ $s->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <select name="customer_id" class="form-select">
                                                <option value="">-- None --</option>
                                                @foreach($customers as $c)
                                                <option value="{{ $c->customer_id }}"
                                                    {{ $car->customer_id == $c->customer_id ? 'selected' : '' }}>
                                                    {{ $c->name }}
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
                        <td colspan="9" class="text-center text-muted">No cars found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Car Modal --}}
    <div class="modal fade" id="addCarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('cars.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Make</label>
                            <input type="text" name="make" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year</label>
                            <input type="number" name="year" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                <option value="new">New</option>
                                <option value="used">Used</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Select Status --</option>
                                <option value="available">Available</option>
                                <option value="sold">Sold</option>
                                <option value="in_service">In Service</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salesperson</label>
                            <select name="salesperson_id" class="form-select">
                                <option value="">-- None --</option>
                                @foreach($salespersons as $s)
                                <option value="{{ $s->salesperson_id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-select">
                                <option value="">-- None --</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->customer_id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Car</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>



@endsection