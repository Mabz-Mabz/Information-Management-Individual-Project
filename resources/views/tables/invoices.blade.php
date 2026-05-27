@extends('template.main')
@section('title')
Invoices
@endsection
@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Invoices</h2>

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
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addInvoiceModal">
        Add Invoice
    </button>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Salesperson ID</th>
                        <th>Car Serial</th>
                        <th>Customer ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_id }}</td>
                        <td>{{ $invoice->date }}</td>
                        <td>{{ number_format($invoice->amount, 2) }}</td>
                        <td>{{ $invoice->salesperson_id }}</td>
                        <td>{{ $invoice->car_serial }}</td>
                        <td>{{ $invoice->customer_id }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editInvoiceModal{{ $invoice->invoice_id }}">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form method="POST"
                                action="{{ route('invoices.destroy', $invoice->invoice_id) }}"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editInvoiceModal{{ $invoice->invoice_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Invoice</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('invoices.update', $invoice->invoice_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Date</label>
                                            <input type="date" name="date" class="form-control"
                                                value="{{ $invoice->date }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Amount</label>
                                            <input type="number" name="amount" step="0.01" class="form-control"
                                                value="{{ $invoice->amount }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Salesperson</label>
                                            <select name="salesperson_id" class="form-select" required>
                                                <option value="">-- Select Salesperson --</option>
                                                @foreach($salespersons as $salesperson)
                                                <option value="{{ $salesperson->salesperson_id }}"
                                                    {{ $invoice->salesperson_id == $salesperson->salesperson_id ? 'selected' : '' }}>
                                                    {{ $salesperson->salesperson_id }} — {{ $salesperson->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Car Serial</label>
                                            <select name="car_serial" class="form-select" required>
                                                <option value="">-- Select Car --</option>
                                                @foreach($cars as $car)
                                                <option value="{{ $car->serial_number }}"
                                                    {{ $invoice->car_serial == $car->serial_number ? 'selected' : '' }}>
                                                    {{ $car->serial_number }} — {{ $car->make }} {{ $car->model }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Customer</label>
                                            <select name="customer_id" class="form-select" required>
                                                <option value="">-- Select Customer --</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->customer_id }}"
                                                    {{ $invoice->customer_id == $customer->customer_id ? 'selected' : '' }}>
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
                        <td colspan="7" class="text-center text-muted">No invoices found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addInvoiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('invoices.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" name="amount" step="0.01" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salesperson</label>
                            <select name="salesperson_id" class="form-select" required>
                                <option value="">-- Select Salesperson --</option>
                                @foreach($salespersons as $salesperson)
                                <option value="{{ $salesperson->salesperson_id }}">
                                    {{ $salesperson->salesperson_id }} — {{ $salesperson->name }}
                                </option>
                                @endforeach
                            </select>
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
                        <button type="submit" class="btn btn-primary">Add Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection