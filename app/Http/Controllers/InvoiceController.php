<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function index()
    {
        Log::info("InvoiceController: index");
        $invoices     = DB::table('invoice')->get();
        $salespersons = DB::table('salesperson')->get();
        $cars         = DB::table('car')->get();
        $customers    = DB::table('customer')->get();

        return view('tables.invoices', compact('invoices', 'salespersons', 'cars', 'customers'));
    }

    public function store(Request $request)
    {
        Log::info("InvoiceController: store");
        $request->validate([
            'date'           => ['required', 'date'],
            'amount'         => ['required', 'numeric', 'min:0'],
            'salesperson_id' => ['required', 'exists:salesperson,salesperson_id'],
            'car_serial'     => ['required', 'exists:car,serial_number'],
            'customer_id'    => ['required', 'exists:customer,customer_id'],
        ]);

        DB::table('invoice')->insert([
            'date'           => $request->date,
            'amount'         => $request->amount,
            'salesperson_id' => $request->salesperson_id,
            'car_serial'     => $request->car_serial,
            'customer_id'    => $request->customer_id,
        ]);

        Log::info("Invoice created for car: " . $request->car_serial);
        return redirect()->route('invoices.index')->with('success', 'Invoice added successfully.');
    }

    public function update(Request $request, $invoice_id)
    {
        Log::info("InvoiceController: update - " . $invoice_id);
        $request->validate([
            'date'           => ['required', 'date'],
            'amount'         => ['required', 'numeric', 'min:0'],
            'salesperson_id' => ['required', 'exists:salesperson,salesperson_id'],
            'car_serial'     => ['required', 'exists:car,serial_number'],
            'customer_id'    => ['required', 'exists:customer,customer_id'],
        ]);

        DB::table('invoice')->where('invoice_id', $invoice_id)->update([
            'date'           => $request->date,
            'amount'         => $request->amount,
            'salesperson_id' => $request->salesperson_id,
            'car_serial'     => $request->car_serial,
            'customer_id'    => $request->customer_id,
        ]);

        Log::info("Invoice updated: " . $invoice_id);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($invoice_id)
    {
        Log::info("InvoiceController: destroy - " . $invoice_id);
        DB::table('invoice')->where('invoice_id', $invoice_id)->delete();
        Log::info("Invoice deleted: " . $invoice_id);
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}