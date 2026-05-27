@extends('template.main')
@section('title')
Service Ticket
@endsection
@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Service Ticket</h2>

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
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addServiceTicketModal">
        Add Service Ticket
    </button>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Ticket ID</th>
                        <th>Opened Date</th>
                        <th>Car Serial</th>
                        <th>Customer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($service_tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->ticket_id }}</td>
                        <td>{{ $ticket->date_opened }}</td>
                        <td>{{ $ticket->car_serial }}</td>
                        <td>{{ $ticket->customer_id }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editServiceTicketModal{{ $ticket->ticket_id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('service-tickets.destroy', $ticket->ticket_id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this service ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editServiceTicketModal{{ $ticket->ticket_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Service Ticket</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('service-tickets.update', $ticket->ticket_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Date Opened</label>
                                            <input type="date" name="date_opened" class="form-control"
                                                value="{{ $ticket->date_opened }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Car Serial</label>
                                            <select name="car_serial" class="form-select" required>
                                                <option value="">-- Select Car --</option>
                                                @foreach($cars as $car)
                                                <option value="{{ $car->serial_number }}"
                                                    {{ $ticket->car_serial == $car->serial_number ? 'selected' : '' }}>
                                                    {{ $car->serial_number }} — {{ $car->make }} {{ $car->model }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- Added customer dropdown --}}
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <select name="customer_id" class="form-select" required>
                                                <option value="">-- Select Customer --</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->customer_id }}"
                                                    {{ $ticket->customer_id == $customer->customer_id ? 'selected' : '' }}>
                                                    {{ $customer->customer_id }} — {{ $customer->name }}
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
                        <td colspan="5" class="text-center text-muted">No service ticket found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addServiceTicketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Service Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('service-tickets.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date Opened</label>
                            <input type="date" name="date_opened" class="form-control" required>
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
                        {{-- Added customer dropdown --}}
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->customer_id }}">
                                    {{ $customer->customer_id }} — {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Service Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection 