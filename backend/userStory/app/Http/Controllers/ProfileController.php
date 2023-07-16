<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function updatePhotoProfile(Request $request)
    {
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $originalName = $file->hashName();
            $img = Image::make($file->getRealPath());
            $img->stream();

            Storage::disk('local')->put('public/images/'. $originalName, $img, 'public');

            $user = Auth::User();
            $user->profile_picture = $originalName;
            $user->save();

            return redirect()->to('profile')->withSuccess('Profile image updated');
        }

        return redirect()->to('profile')->withErrors('Profile image not updated');
    }

    public function updateProfileDetail(Request $request)
    {
        $user = Auth::User();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'old_password' => [
                'required', function($attr, $value, $fail){
                    if (!Hash::check($value, Auth::User()->password )){
                        $fail('Old password not match');
                    }
                }
            ],
            'new_password' => 'required|different:old_password|min:8',
            'confirm_password' => 'required|different:old_password|same:new_password'
        ]);
        if ($validator->fails()){
            return redirect()->to('profile')->withErrors($validator);
        }
        $user->name = $request->name;
        $user->password = $request->confirm_password;

        if (!$user->save()){
            return redirect()->to('profile')->withErrors('Profile detail not updated');
        }

        return redirect()->to('profile')->withSuccess('Profile detail updated ');

    }
}
