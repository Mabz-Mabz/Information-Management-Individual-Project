<nav class="navbar navbar-expand-lg bg-dark sticky-top" data-bs-theme="dark">
    <div class="container-fluid">

        <a class="navbar-brand text-white fw-bold">
            Information Management
        </a>

        <li class="nav-item dropdown">
            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="{{ route('home')}}">home</a></li>
                <li><a class="dropdown-item" href="{{ route('users.index')}}">Users</a></li>
                <li><a class="dropdown-item" href="{{ route('cars.index')}}">Cars</a></li>
                <li><a class="dropdown-item" href="{{ route('customers.index')}}">Customers</a></li>
                <li><a class="dropdown-item" href="{{ route('mechanics.index')}}">Mechanics</a></li>
                <li><a class="dropdown-item" href="{{ route('salespersons.index')}}">Salespersons</a></li>
                <li><a class="dropdown-item" href="{{ route('service-records.index')}}">Service Records</a></li>
                <li><a class="dropdown-item" href="{{ route('service-tickets.index')}}">Service Tickets</a></li>
                <li><a class="dropdown-item" href="{{ route('parts.index')}}">Parts</a></li>
                <li><a class="dropdown-item" href="{{ route('invoices.index')}}">Invoice</a></li>
                <li><a class="dropdown-item" href="logs">Audit Logs</a></li>
            </ul>
        </li>

        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-light">Home</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>

    </div>
</nav>