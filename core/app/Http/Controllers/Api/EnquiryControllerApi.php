<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EnquiryControllerApi extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id' => 'required|integer',
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf|max:2048', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('resumes', $filename, 'public'); 
            $data['resume'] = $path;
        }

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();

        DB::table('enquiries')->insert($data);

        return response()->json([
            'status' => 'add_success',
            'message' => 'Enquiry submitted successfully.',
        ]);
    }
}
