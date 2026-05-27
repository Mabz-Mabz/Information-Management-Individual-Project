<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalespersonController extends Controller
{
    public function index()
    {
        Log::info("SalespersonController: index");
        $salespersons = DB::table('salesperson')
            ->get();

        return view('tables.salespersons', compact('salespersons'));
    }

    public function store(Request $request)
    {
        Log::info("SalespersonController: store");
        $request->validate([
            'name'         => ['required', 'max:100'],
            'contact_info' => ['required', 'max:150'],
        ]);

        DB::table('salesperson')->insert([
            'name'         => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        Log::info("Salesperson created: " . $request->name);
        return redirect()->route('salespersons.index')->with('success', 'Salesperson   added successfully.');
    }

    public function update(Request $request, $salesperson_id)
    {
        Log::info("SalespersonController: update - " . $salesperson_id);
        $request->validate([
            'name'         => ['required', 'max:100'],
            'contact_info' => ['required', 'max:150'],
        ]);

        DB::table('salesperson')->where('salesperson_id', $salesperson_id)->update([
            'name'         => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        Log::info("Salesperson updated: " . $salesperson_id);
        return redirect()->route('salespersons.index')->with('success', 'Salesperson updated successfully.');
    }

    public function destroy($salesperson_id)
    {
        Log::info("SalespersonController: destroy - " . $salesperson_id);
        DB::table('salesperson')->where('salesperson_id', $salesperson_id)->delete();
        Log::info("Salesperson deleted: " . $salesperson_id);
        return redirect()->route('salespersons.index')->with('success', 'Salesperson deleted successfully.');
    }
}
