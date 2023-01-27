<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
// use Intervention\Image\Facades\Image;
use Image;

class AboutController extends Controller
{
    //create function edit_about
    public function edit_about()
    {
        return About::orderBy('id', 'desc')->first();
    }

    public function update_about(Request $request)
    {
        // Find the latest record in the "about" table
        $about = About::orderBy('id', 'desc')->first();
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        // Check if the CV has been updated
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            // Check if the file size is less than 2MB
            if ($file->getSize() <= 2097152) {
                $strpos = strpos($file->getMimeType(), '/');
                $sub = substr($file->getMimeType(), $strpos + 1);
                $namecv = time() . "." . $sub;
                // Upload the file to the "img/upload" directory
                $file->move(public_path('img/upload'), $namecv);
                // Check if the previous CV file exists and delete it
                if (file_exists(public_path('img/upload/' . $about->cv))) {
                    unlink(public_path('img/upload/' . $about->cv));
                }
                $about->cv = $namecv;
            } else {
                // Return error message if file size is too large
                return redirect()->back()->withErrors(['cv' => 'File size is too large']);
            }
        }
        // Update the "about" record
        $about->name = $request->name;
        $about->email = $request->email;
        $about->phone = $request->phone;
        $about->address = $request->address;
        $about->description = $request->description;
        $about->tagline = $request->tagline;
        $about->photo = $request->photo;
        $about->save();
        return redirect()->back()->with('success', 'About updated successfully');
    }
    public function create_about(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'description' => 'required',
            'tagline' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            // Check if the file size is less than 2MB
            if ($file->getSize() <= 2097152) {
                $strpos = strpos($file->getMimeType(), '/');
                $sub = substr($file->getMimeType(), $strpos + 1);
                $namephoto = time() . "." . $sub;
                // Upload the file to the "img/upload" directory
                $file->move(public_path('img/upload'), $namephoto);
            } else {
                // Return error message if file size is too large
                return redirect()->back()->withErrors(['photo' => 'File size is too large']);
            }
        }

        $about = new About();
        $about->name = $request->name;
        $about->email = $request->email;
        $about->phone = $request->phone;
        $about->address = $request->address;
        $about->description = $request->description;
        $about->tagline = $request->tagline;
        $about->photo = $namephoto;
        $about->save();
        return redirect()->back()->with('success', 'About created successfully');
    }
}
