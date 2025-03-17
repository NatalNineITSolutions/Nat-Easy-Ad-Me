<?php

namespace Modules\Membership\app\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Membership\app\Models\Enquiry;

class EnquiryFormController extends Controller
{
    public function enquiry_form_submit(Request $request)
    {    
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required',
                'listing_id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required',
                'resume' => 'nullable|file|mimes:pdf|max:2048', // Validate the file (PDF, max 2MB)
            ]);
    
            // Handle file upload
            $resumePath = null;
            if ($request->hasFile('resume')) {
                // Define the custom directory path
                $customDirectory = 'C:/laragon/www/Nat-Easy-Ad-Me/assets/uploads/media-uploader/resume';
            
                // Ensure the directory exists, create it if it doesn't
                if (!file_exists($customDirectory)) {
                    mkdir($customDirectory, 0777, true);
                }
            
                // Get the uploaded file
                $file = $request->file('resume');
            
                // Generate a unique file name
                $fileName = time() . '_' . $file->getClientOriginalName();
            
                // Move the file to the custom directory
                $file->move($customDirectory, $fileName);
            
                // Set the resume path for database storage
                $resumePath = 'assets/uploads/media-uploader/resume/' . $fileName;
            }

            // Create the enquiry record
            $submit_form = Enquiry::create([
                'user_id' => $request->user_id,
                'listing_id' => $request->listing_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'resume' => $resumePath, // Store the file path in the database
            ]);
    
            if ($submit_form) {
                return response()->json([
                    'status' => 'add_success',
                    'message' => __('Your message has been successfully submitted')
                ]);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ]);
        }
    }
}

