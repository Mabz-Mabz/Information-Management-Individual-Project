<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceRecordController extends Controller
{
    public function index()
    {
        Log::info("ServiceRecordController: index");
        $service_records = DB::table('service_record')->get();
        $cars = DB::table('car')->get();

        return view('tables.service-records', compact('service_records', 'cars'));
    }

    public function store(Request $request)
    {
        Log::info("ServiceRecordController: store");
        $request->validate([
            'service_date'         => ['required'],
            'car_serial'   => [
                'required',
                'exists:car,serial_number',
            ],
        ]);

        DB::table('service_record')->insert([
            'service_date'         => $request->service_date,
            'car_serial' => $request->car_serial,
        ]);

        Log::info("Service Record created: " . $request->car_serial);
        return redirect()->route('service-records.index')->with('success', 'Service Record added successfully.');
    }

    public function update(Request $request, $record_id)
    {
        Log::info("ServiceRecordController: update - " . $record_id);
        $request->validate([
            'service_date'         => ['required'],
            'car_serial' => ['required', 'max:50'],
        ]);

        DB::table('service_record')->where('record_id', $record_id)->update([
            'service_date' => $request->service_date,
            'car_serial' => $request->car_serial,
        ]);

        Log::info("Service Record updated: " . $record_id);
        return redirect()->route('service-records.index')->with('success', 'Service Record updated successfully.');
    }

    public function destroy($record_id)
    {
        Log::info("ServiceRecordController: destroy - " . $record_id);
        DB::table('service_record')->where('record_id', $record_id)->delete();
        Log::info("Service Record deleted: " . $record_id);
        return redirect()->route('service-records.index')->with('success', 'Service Record deleted successfully.');
    }
}
