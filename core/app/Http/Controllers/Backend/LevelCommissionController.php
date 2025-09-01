<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LevelCommission;

class LevelCommissionController extends Controller
{
    public function index()
    {
        $commissions = LevelCommission::all();
        return view('backend.pages.level-commission.index', compact('commissions'));
    }

    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'level_name' => 'required|string|max:255',
            'commission' => 'required|numeric|min:0',
        ]);

        // create commission record
        LevelCommission::create([
            'level_name' => $request->level_name,
            'commission' => $request->commission,
        ]);

        return redirect()->route('admin.level.commission')
            ->with('success', 'Level Commission created successfully!');
    }

    public function edit($id)
    {
        $commissions = LevelCommission::all();
        $commission = LevelCommission::findOrFail($id);

        return view('backend.pages.level-commission.index', compact('commissions', 'commission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_name'  => 'required|string|max:255',
            'commission'  => 'required|numeric|min:0|max:100',
        ]);

        $commission = LevelCommission::findOrFail($id);
        $commission->level_name = $request->level_name;
        $commission->commission = $request->commission;
        $commission->save();

        $commissions = LevelCommission::all();

        return view('backend.pages.level-commission.index', compact('commissions'))
                ->with('success', 'Commission updated successfully.');
    }

    public function destroy($id)
    {
        $commission = LevelCommission::findOrFail($id);
        $commission->delete();

        $commissions = LevelCommission::all();

        return view('backend.pages.level-commission.index', compact('commissions'))
                ->with('success', 'Commission deleted successfully.');
    }

}
