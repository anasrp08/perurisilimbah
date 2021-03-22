<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword; 
use Validator;
use App\Helpers\AppHelper;
use App\User;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('settings.profile');
    }

    public function editProfile()
    {
        dd(base_path());
        return view('settings.edit-profile');
    }

   
    public function updateProfile(Request $request)
    {
        
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'avatar' => 'nullable',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
 
        if ($request->hasFile('avatar')) {
 
            $filename = null;
            $uploaded_avatar = $request->file('avatar');
            $extension = $uploaded_avatar->getClientOriginalExtension();
 
            $filename = $uploaded_avatar->getClientOriginalName();
            $destinationPath=AppHelper::pathFileFoto("");
            // $destinationPath = $this->pathFile("");
 
            $uploaded_avatar->move($destinationPath, $filename);
 
            if ($user->avatar) {
                $old_avatar = $user->avatar;

               
                if (!$old_avatar == "member_avatar.png" || "admin_avatar.png") {
                    $filepath = AppHelper::pathFileFoto($user->avatar);

                    try {
                        File::delete($filepath);
                    } catch (FileNotFoundException $e) { 
                    }
                }
            }

            // Ganti field cover dengan cover yang baru
            $user->avatar = $filename;
            $user->save();
        }

        $user->save();

        Session::flash("flash_notification", [
            "level" => "success",
            "icon" => "fa fa-check",
            "message" => "Profile berhasil diubah"
        ]);

        return redirect('settings/profile');
    }

    public function editPassword()
    {
        return view('settings.edit-password');
    }
 
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', new MatchOldPassword],
            'new_password' => 'required|confirmed|min:6|different:password',
            'new_confirm_password' => ['same:new_password']], ['password.old_password' => 'Password lama tidak sesuai']);
 
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Session::flash("flash_notification", [
                    "level" => "success",
                    "icon" => "fa fa-check",
                    "message" => "Password berhasil dirubah"
                ]);
                return redirect('settings/password');
        
    }

}
