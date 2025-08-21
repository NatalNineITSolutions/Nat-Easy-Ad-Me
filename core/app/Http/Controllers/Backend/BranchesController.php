<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branch::paginate(10);
        return view('backend.pages.branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:branches,email',
            'phone_number'    => 'required|string|max:20',
            'password'        => 'required|string|min:8|confirmed',
            'branch_location' => 'required|string|max:255',
        ]);

        Branch::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'phone_number'    => $request->phone_number,
            'password'        => Hash::make($request->password),
            'branch_location' => $request->branch_location,
        ]);

        return redirect()->route('admin.branches')
            ->with('success', 'Branch created successfully.');
    }

    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branchData = $branch->toArray();
            $branch->delete();
            

            return redirect()->route('admin.branches')
                ->with('success', 'Branch deleted successfully.')
                ->with('debug', [
                    'action' => 'destroy',
                    'status' => 'success',
                    'branch_id' => $id,
                    'data' => $branchData
                ]);

        } catch (\Exception $e) {
            // Debug: Log error            
            return redirect()->back()
                ->with('error', 'Branch deletion failed: ' . $e->getMessage())
                ->with('debug', [
                    'action' => 'destroy',
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'branch_id' => $id
                ]);
        }
    }
    
    public function update(Request $request, $id)
    {
        // Debug: Log the incoming request        
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:branches,email,' . $id,
            'phone_number'    => 'required|string|max:20',
            'password'        => 'nullable|string|min:8|confirmed',
            'branch_location' => 'required|string|max:255',
        ]);

        try {
            $branch = Branch::findOrFail($id);
            
            $data = [
                'name'            => $request->name,
                'email'           => $request->email,
                'phone_number'    => $request->phone_number,
                'branch_location' => $request->branch_location,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $branch->update($data);

            return redirect()->route('admin.branches')
                ->with('success', 'Branch updated successfully.')
                ->with('debug', [
                    'action' => 'update',
                    'status' => 'success',
                    'branch_id' => $branch->id,
                    'data' => $branch->toArray()
                ]);

        } catch (\Exception $e) {
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Branch update failed: ' . $e->getMessage())
                ->with('debug', [
                    'action' => 'update',
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => $request->all()
                ]);
        }
    }
}
    

