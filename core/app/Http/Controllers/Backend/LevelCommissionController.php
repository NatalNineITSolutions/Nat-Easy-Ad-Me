<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IncomePayoutManage;
use App\Models\LevelBasedCommissionPayout;
use App\Models\LevelCommissionHistory;
use App\Models\UsersBV;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\LevelCommission;
use Illuminate\Support\Facades\Validator;

class LevelCommissionController extends Controller
{
    public function index()
    {
        $commissions = LevelCommission::all();
        return view('backend.pages.level-commission.index', compact('commissions'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'level_name' => 'required|string|max:255',
            'commission' => 'required|numeric|min:0',
        ]);

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
            'level_name' => 'required|string|max:255',
            'commission' => 'required|numeric|min:0|max:100',
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

    public function levelbvcommission()
    {
        $histories = LevelCommissionHistory::with([
            'purchaser:id,partner_name',
            'upline:id,partner_name',
            'order:id'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('backend.pages.commission-manage.index', compact('histories'));
    }

    public function levelbasedpayout(Request $request)
    {
        $query = LevelBasedCommissionPayout::with(['user:id,first_name,last_name'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('payout_date', $request->date);
        }

        $payouts = $query->paginate(20);

        return view('backend.pages.commission-manage.commission-payout', compact('payouts'));
    }

    public function downloadPdf(Request $request)
    {
        $query = LevelBasedCommissionPayout::with('user');

        if ($request->has('date') && $request->date) {
            $query->whereDate('payout_date', $request->date);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $payouts = $query->get();

        $pdf = Pdf::loadView('backend.pages.commission-manage.pdf', compact('payouts'));

        return $pdf->download('level_commission_payouts.pdf');
    }

}