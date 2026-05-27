@extends('template.main')
@section('title')
Service Records
@endsection
@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Service Records</h2>

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
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addServiceRecordModal">
        Add Service Record
    </button>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Record ID</th>
                        <th>Service Date</th>
                        <th>Car Serial</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($service_records as $record)
                    <tr>
                        <td>{{ $record->record_id }}</td>
                        <td>{{ $record->service_date }}</td>
                        <td>{{ $record->car_serial }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editServiceRecordModal{{ $record->record_id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('service-records.destroy', $record->record_id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this service record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editServiceRecordModal{{ $record->record_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Service Record</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('service-records.update', $record->record_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Service Date</label>
                                            <input type="date" name="service_date" class="form-control"
                                                value="{{ $record->service_date }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Car Serial</label>
                                            <select name="car_serial" class="form-select" required>
                                                <option value="">-- Select Car --</option>
                                                @foreach($cars as $car)
                                                <option value="{{ $car->serial_number }}"
                                                    {{ $record->car_serial == $car->serial_number ? 'selected' : '' }}>
                                                    {{ $car->serial_number }} — {{ $car->make }} {{ $car->model }}
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
                        <td colspan="4" class="text-center text-muted">No service records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addServiceRecordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Service Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('service-records.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Service Date</label>
                            <input type="date" name="service_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Car Serial</label>
                            <select name="car_serial" class="form-select" required>
                                <option value="">-- Select Car --</option>
                                @foreach($cars as $car)
                                <option value="{{ $car->serial_number }}">
                                    {{ $car->serial_number }} — {{ $car->make }} {{ $car->model }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Service Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@endsection