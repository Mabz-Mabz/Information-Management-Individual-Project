<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    // Display all cars
    public function index()
    {
        Log::info("CarController: index");
        $cars = DB::table('car')
            ->leftJoin('salesperson', 'car.salesperson_id', '=', 'salesperson.salesperson_id')
            ->leftJoin('customer', 'car.customer_id', '=', 'customer.customer_id')
            ->select(
                'car.*',
                'salesperson.name as salesperson_name',
                'customer.name as customer_name'
            )
            ->get();

        $salespersons = DB::table('salesperson')->get();
        $customers    = DB::table('customer')->get();

        return view('tables.cars', compact('cars', 'salespersons', 'customers'));
    }

    // Store new car
    public function store(Request $request)
    {
        Log::info("CarController: store");
        $request->validate([
            'serial_number' => ['required', 'unique:car,serial_number', 'max:50'],
            'make'          => ['required', 'max:50'],
            'model'         => ['required', 'max:50'],
            'year'          => ['required', 'digits:4', 'integer'],
            'type'          => ['required', 'in:new,used'],
            'status'        => ['required', 'in:available,sold,in_service'],
            'salesperson_id' => ['nullable', 'exists:salesperson,salesperson_id'],
            'customer_id'   => ['nullable', 'exists:customer,customer_id'],
        ]);

        DB::table('car')->insert([
            'serial_number'  => $request->serial_number,
            'make'           => $request->make,
            'model'          => $request->model,
            'year'           => $request->year,
            'type'           => $request->type,
            'status'         => $request->status,
            'salesperson_id' => $request->salesperson_id,
            'customer_id'    => $request->customer_id,
        ]);

        Log::info("Car created: " . $request->serial_number);
        return redirect()->route('cars.index')->with('success', 'Car added successfully.');
    }

    // Update car
    public function update(Request $request, $serial_number)
    {
        Log::info("CarController: update - " . $serial_number);
        $request->validate([
            'make'          => ['required', 'max:50'],
            'model'         => ['required', 'max:50'],
            'year'          => ['required', 'digits:4', 'integer'],
            'type'          => ['required', 'in:new,used'],
            'status'        => ['required', 'in:available,sold,in_service'],
            'salesperson_id' => ['nullable', 'exists:salesperson,salesperson_id'],
            'customer_id'   => ['nullable', 'exists:customer,customer_id'],
        ]);

        DB::table('car')->where('serial_number', $serial_number)->update([
            'make'           => $request->make,
            'model'          => $request->model,
            'year'           => $request->year,
            'type'           => $request->type,
            'status'         => $request->status,
            'salesperson_id' => $request->salesperson_id,
            'customer_id'    => $request->customer_id,
        ]);

        Log::info("Car updated: " . $serial_number);
        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    // Delete car
    public function destroy($serial_number)
    {
        Log::info("CarController: destroy - " . $serial_number);
        DB::table('car')->where('serial_number', $serial_number)->delete();
        Log::info("Car deleted: " . $serial_number);
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
    }
}
