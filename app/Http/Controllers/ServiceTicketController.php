<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceTicketController extends Controller
{
    public function index()
    {
        Log::info("ServiceTicketController: index");
        $service_tickets = DB::table('service_ticket')->get();
        $cars = DB::table('car')->get();
        $customers = DB::table('customer')->get();

        return view('tables.service-ticket', compact('service_tickets', 'cars', 'customers'));
    }

    public function store(Request $request)
    {
        Log::info("ServiceTicketController: store");
        $request->validate([
            'date_opened'         => ['required'],
            'car_serial'   => [
                'required',
                'exists:car,serial_number',
            ],
            'customer_id' => ['required']
        ]);

        DB::table('service_ticket')->insert([
            'date_opened'         => $request->date_opened,
            'car_serial' => $request->car_serial,
            'customer_id' => $request->customer_id
        ]);

        Log::info("Service Ticket created: " . $request->car_serial);
        return redirect()->route('service-tickets.index')->with('success', 'Service Ticket added successfully.');
    }

    public function update(Request $request, $ticket_id)
    {
        Log::info("ServiceTicketController: update - " . $ticket_id);
        $request->validate([
            'date_opened'         => ['required'],
            'car_serial' => ['required', 'max:50'],
            'customer_id' => ['required']
        ]);

        DB::table('service_ticket')->where('ticket_id', $ticket_id)->update([
            'date_opened' => $request->date_opened,
            'car_serial' => $request->car_serial,
            'customer_id' => $request->customer_id
        ]);

        Log::info("Service Record updated: " . $ticket_id);
        return redirect()->route('service-tickets.index')->with('success', 'Service Ticket updated successfully.');
    }

    public function destroy($ticket_id)
    {
        Log::info("ServiceTicketController: destroy - " . $ticket_id);
        DB::table('service_ticket')->where('ticket_id', $ticket_id)->delete();
        Log::info("Service Ticket deleted: " . $ticket_id);
        return redirect()->route('service-tickets.index')->with('success', 'Service Ticket deleted successfully.');
    }
}
