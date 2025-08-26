<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::paginate(10);
        return view('backend.pages.vendors.index', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'primary_contact_name' => 'required|string|max:255',
            'company_name'         => 'nullable|string|max:255',
            'email'                => 'nullable|email|unique:vendors,email',
            'phone'                => 'nullable|string|max:20',
            'website'              => 'nullable|url|max:255',
            'opening_balance'      => 'nullable|numeric',
            'currency'             => 'nullable|string|max:10',
            'billing_address'      => 'nullable|string',
            'shipping_address'     => 'nullable|string',
        ]);

        try {
            $vendor = Vendor::create([
                'primary_contact_name' => $request->primary_contact_name,
                'company_name'         => $request->company_name,
                'email'                => $request->email,
                'phone'                => $request->phone,
                'website'              => $request->website,
                'opening_balance'      => $request->opening_balance ?? 0.00,
                'currency'             => $request->currency ?? 'INR',
                'billing_address'      => $request->billing_address,
                'shipping_address'     => $request->shipping_address,
            ]);

            return redirect()->route('admin.vendors')
                ->with('success', 'Vendor created successfully.')
                ->with('debug', [
                    'action'    => 'store',
                    'status'    => 'success',
                    'vendor_id' => $vendor->id,
                    'data'      => $vendor->toArray()
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Vendor creation failed: ' . $e->getMessage())
                ->with('debug', [
                    'action'  => 'store',
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'data'    => $request->all()
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'primary_contact_name' => 'required|string|max:255',
            'company_name'         => 'nullable|string|max:255',
            'email'                => 'nullable|email|unique:vendors,email,' . $id,
            'phone'                => 'nullable|string|max:20',
            'website'              => 'nullable|url|max:255',
            'opening_balance'      => 'nullable|numeric',
            'currency'             => 'nullable|string|max:10',
            'billing_address'      => 'nullable|string',
            'shipping_address'     => 'nullable|string',
        ]);

        try {
            $vendor = Vendor::findOrFail($id);

            $data = [
                'primary_contact_name' => $request->primary_contact_name,
                'company_name'         => $request->company_name,
                'email'                => $request->email,
                'phone'                => $request->phone,
                'website'              => $request->website,
                'opening_balance'      => $request->opening_balance ?? 0.00,
                'currency'             => $request->currency ?? 'INR',
                'billing_address'      => $request->billing_address,
                'shipping_address'     => $request->shipping_address,
            ];

            $vendor->update($data);

            return redirect()->route('admin.vendors')
                ->with('success', 'Vendor updated successfully.')
                ->with('debug', [
                    'action'    => 'update',
                    'status'    => 'success',
                    'vendor_id' => $vendor->id,
                    'data'      => $vendor->toArray()
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Vendor update failed: ' . $e->getMessage())
                ->with('debug', [
                    'action'  => 'update',
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'data'    => $request->all()
                ]);
        }
    }

    public function destroy($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            $vendorData = $vendor->toArray();
            $vendor->delete();

            return redirect()->route('admin.vendors')
                ->with('success', 'Vendor deleted successfully.')
                ->with('debug', [
                    'action'    => 'destroy',
                    'status'    => 'success',
                    'vendor_id' => $id,
                    'data'      => $vendorData
                ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Vendor deletion failed: ' . $e->getMessage())
                ->with('debug', [
                    'action'  => 'destroy',
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'vendor_id'=> $id
                ]);
        }
    }
}
