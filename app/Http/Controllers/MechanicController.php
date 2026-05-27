<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MechanicController extends Controller
{
    public function index()
    {
        Log::info("MechanicController: index");
        $mechanics = DB::table('mechanic')
            ->get();

        return view('tables.mechanics', compact('mechanics'));
    }

    public function store(Request $request)
    {
        Log::info("MechanicController: store");
        $request->validate([
            'name'         => ['required', 'max:100'],
            'contact_info' => ['required', 'max:150'],
        ]);

        DB::table('mechanic')->insert([
            'name'         => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        Log::info("Mechanic created: " . $request->name);
        return redirect()->route('mechanics.index')->with('success', 'Mechanic   added successfully.');
    }

    public function update(Request $request, $mechanic_id)
    {
        Log::info("MechanicController: update - " . $mechanic_id);
        $request->validate([
            'name'         => ['required', 'max:100'],
            'contact_info' => ['required', 'max:150'],
        ]);

        DB::table('mechanic')->where('mechanic_id', $mechanic_id)->update([
            'name'         => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        Log::info("Mechanic updated: " . $mechanic_id);
        return redirect()->route('mechanics.index')->with('success', 'Mechanic updated successfully.');
    }

    public function destroy($mechanic_id)
    {
        Log::info("MechanicController: destroy - " . $mechanic_id);
        DB::table('mechanic')->where('mechanic_id', $mechanic_id)->delete();
        Log::info("Mechanic deleted: " . $mechanic_id);
        return redirect()->route('mechanics.index')->with('success', 'Mechanic deleted successfully.');
    }
}
