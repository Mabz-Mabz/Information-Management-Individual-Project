@extends('template.main')
@section('title')
Logs
@endsection
@section('content')
@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif

<div class="container mt-5">

    <h2 class="mb-4">Audit Logs</h2>

    <div class="card">
        <div class="card-header bg-dark text-white">
            Last 100 Log Entries
        </div>
        <div class="card-body p-0">
            <div style="height: 600px; overflow-y: auto; background-color: #1e1e1e;">
                <table class="table table-dark table-sm table-hover mb-0">
                    <thead class="sticky-top">
                        <tr>
                            <th style="width: 250px;">Timestamp</th>
                            <th style="width: 100px;">Level</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent as $line)
                        @php
                        // Extract timestamp
                        preg_match('/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $timeMatch);
                        $timestamp = $timeMatch[1] ?? '-';

                        // Extract level
                        preg_match('/local\.(\w+):/', $line, $levelMatch);
                        $level = strtolower($levelMatch[1] ?? 'info');

                        // Extract message
                        preg_match('/local\.\w+: (.+)/', $line, $msgMatch);
                        $message = $msgMatch[1] ?? $line;

                        // Color per level
                        $color = match($level) {
                        'error' => 'text-danger',
                        'warning' => 'text-warning',
                        'info' => 'text-info',
                        'debug' => 'text-secondary',
                        default => 'text-light',
                        };
                        @endphp
                        <tr>
                            <td class="text-secondary" style="font-size: 0.8rem;">
                                {{ $timestamp }}
                            </td>
                            <td>
                                <span class="badge 
                                        @if($level === 'error') bg-danger
                                        @elseif($level === 'warning') bg-warning text-dark
                                        @elseif($level === 'info') bg-info text-dark
                                        @else bg-secondary
                                        @endif">
                                    {{ strtoupper($level) }}
                                </span>
                            </td>
                            <td class="{{ $color }}" style="font-size: 0.85rem; word-break: break-all;">
                                {{ $message }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-secondary">
                                No logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted" style="font-size: 0.8rem;">
            Showing last {{ count($recent) }} log entries
        </div>
    </div>

</div>


@endsection