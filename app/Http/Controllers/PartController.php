<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PartController extends Controller
{
    public function index()
    {
        Log::info("PartController: index");
        $parts = DB::table('part')->get();

        return view('tables.parts', compact('parts'));
    }

    public function store(Request $request)
    {
        Log::info("PartController: store");
        $request->validate([
            'part_name' => ['required'],
            'part_number' => ['required',],
            'cost' => ['required']
        ]);

        DB::table('part')->insert([
            'part_name' => $request->part_name,
            'part_number' => $request->part_number,
            'cost' => $request->cost
        ]);

        Log::info("Part created: " . $request->part_name);
        return redirect()->route('parts.index')->with('success', 'Parts added successfully.');
    }

    public function update(Request $request, $part_id)
    {
        Log::info("PartController: update - " . $part_id);
        $request->validate([
            'part_name'  => ['required'],
            'part_number' => ['required', 'max:50'],
            'cost' => ['required']
        ]);

        DB::table('part')->where('part_id', $part_id)->update([
            'part_name' => $request->part_name,
            'part_number' => $request->part_number,
            'cost' => $request->cost
        ]);

        Log::info("Service Record updated: " . $part_id);
        return redirect()->route('parts.index')->with('success', 'Parts updated successfully.');
    }

    public function destroy($part_id)
    {
        Log::info("PartController: destroy - " . $part_id);
        DB::table('part')->where('part_id', $part_id)->delete();
        Log::info("Part deleted: " . $part_id);
        return redirect()->route('parts.index')->with('success', 'Part deleted successfully.');
    }
}
