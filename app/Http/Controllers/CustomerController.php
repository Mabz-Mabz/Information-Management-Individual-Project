<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        Log::info("CustomerController: index");
        $customers = DB::table('customer') 
            ->get();

        return view('tables.customers', compact('customers')); 
    }

    public function store(Request $request)
    {
        Log::info("CustomerController: store"); 
        $request->validate([
            'name'         => ['required', 'max:100'],
            'contact_info' => ['required', 'max:150'],
        ]);

        DB::table('customer')->insert([
            'name'         => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        Log::info("Customer created: " . $request->name);
        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function update(Request $request, $customer_id)
    {
        Log::info("CustomerController: update - " . $customer_id);
        $request->validate([
            'name'         => ['required', 'max:100'],
            'contact_info' => ['required', 'max:150'], 
        ]);

        DB::table('customer')->where('customer_id', $customer_id)->update([ 
            'name'         => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        Log::info("Customer updated: " . $customer_id);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.'); 
    }

    public function destroy($customer_id)
    {
        Log::info("CustomerController: destroy - " . $customer_id);
        DB::table('customer')->where('customer_id', $customer_id)->delete(); 
        Log::info("Customer deleted: " . $customer_id);
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.'); 
    }
}
