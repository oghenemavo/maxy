<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Storage;

class SettingsController extends Controller
{
    
    public function view(Request $request){


        $mainTab = 'settings';

    	if($request->isMethod('post')){

            // dd($request->all());

            if($request->hasFile('logo')){
                $validatedData = $request->validate([
                    'logo' => 'required|mimes:jpg,jpeg,bmp,png,gif',
                ]);
            }

    		if($request->name){
    			Setting::where('key', 'name')->update(['value' =>  $request->name]);
    		}

    		if($request->email){
    			Setting::where('key', 'email')->update(['value' =>  $request->email]);
    		}

    		if($request->phone){
    			Setting::where('key', 'phone')->update(['value' =>  $request->phone]);
    		}

    		if($request->address){
    			Setting::where('key', 'address')->update(['value' =>  $request->address]);
    		}

            if($request->user_limit){
                Setting::where('key', 'user_limit')->update(['value' =>  $request->user_limit]);
            }

            if($request->file_limit){
                Setting::where('key', 'file_limit')->update(['value' =>  $request->file_limit]);
            }

            if($request->inactivty_warn){
                Setting::where('key', 'inactivty_warn')->update(['value' =>  $request->inactivty_warn]);
            }

            if($request->inactivty_logout){
                Setting::where('key', 'inactivty_logout')->update(['value' =>  $request->inactivty_logout]);
            }

            if($request->expiry_date){
                Setting::where('key', 'expiry_date')->update(['value' =>  $request->expiry_date]);
            }


    		if($request->hasFile('logo')){

                // dd($request->all());

                $f = $request->logo;

                $fileName = $f->getClientOriginalName();

                $ff = Storage::disk('public')->put('logo', $f);

    			Setting::where('key', 'logo')->update(['value' =>  $ff]);
    		}

    		return redirect()->back()->with('success', 'Company setting have been updated');

    	}

    	$name = Setting::where('key', 'name')->first()->value;
    	$email = Setting::where('key', 'email')->first()->value;
    	$logo = Setting::where('key', 'logo')->first()->value;
    	$phone = Setting::where('key', 'phone')->first()->value;
    	$address = Setting::where('key', 'address')->first()->value;
        $address = Setting::where('key', 'address')->first()->value;
        $address = Setting::where('key', 'address')->first()->value;
        $user_limit = Setting::where('key', 'user_limit')->first()->value;
        $file_limit = Setting::where('key', 'file_limit')->first()->value;

        $inactivty_warn = Setting::where('key', 'inactivty_warn')->first()->value;
        $inactivty_logout = Setting::where('key', 'inactivty_logout')->first()->value;
        $expiry_date = Setting::where('key', 'expiry_date')->first()->value;



    	return view('settings.view', compact('name', 'email', 'logo', 'phone', 'address', 'file_limit', 'user_limit', 'mainTab', 'expiry_date', 'inactivty_warn', 'inactivty_logout'));
    }

    public function companyDetails() {
        $mainTab = 'users';
        $name = Setting::where('key', 'name')->first()->value;
        $user_limit = Setting::where('key', 'user_limit')->first()->value;
        $expiry_date = Setting::where('key', 'expiry_date')->first()->value;
        return view ('settings.details', compact('name','expiry_date', 'user_limit', 'mainTab'));
    }


    public function email(Request $request){

        $mainTab = 'users';

        

        if($request->isMethod('post')){

            

            if($request->send_email){
                Setting::where('key', 'send_email')->update(['value' =>  $request->send_email]);
            }

            if($request->host){
                Setting::where('key', 'mail_host')->update(['value' =>  $request->host]);
            }

            if($request->username){
                Setting::where('key', 'mail_username')->update(['value' =>  $request->username]);
            }

            if($request->password){
                Setting::where('key', 'mail_password')->update(['value' =>  $request->password]);
            }

            if($request->port){
                Setting::where('key', 'mail_port')->update(['value' =>  $request->port]);
            }

            if($request->encryption){
                Setting::where('key', 'mail_encryption')->update(['value' =>  $request->encryption]);
            }

            if($request->sender){
                Setting::where('key', 'mail_sender')->update(['value' =>  $request->sender]);
            }


            return redirect()->back()->with('success', 'Email setting have been updated');

        }

        $send_email = Setting::where('key', 'send_email')->first()->value;
        $host = Setting::where('key', 'mail_host')->first()->value;
        $username = Setting::where('key', 'mail_username')->first()->value;
        $password = Setting::where('key', 'mail_password')->first()->value;
        $port = Setting::where('key', 'mail_port')->first()->value;
        $encryption = Setting::where('key', 'mail_encryption')->first()->value;
        $sender = Setting::where('key', 'mail_sender')->first()->value;
        


        return view('settings.email', compact('mainTab','host', 'username', 'password', 'port', 'encryption', 'sender', 'send_email'));
    }
}

