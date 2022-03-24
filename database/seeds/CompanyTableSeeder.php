<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$compName = Setting::where('key', 'name')->first();
    	if(!$compName){
    		Setting::Create([ 'key' => 'name', 'value' => 'Datamax' ]);
    	}


    	$compEmail = Setting::where('key', 'email')->first();
    	if(!$compEmail){
    		Setting::Create([ 'key' => 'email', 'value' => 'info@datamax.com' ]);
    	}

    	$compPhone = Setting::where('key', 'phone')->first();
    	if(!$compPhone){
    		Setting::Create([ 'key' => 'phone', 'value' => '234800000000' ]);
    	}

    	$compAddress = Setting::where('key', 'address')->first();
    	if(!$compAddress){
    		Setting::Create([ 'key' => 'address', 'value' => '' ]);
    	}

    	$compLogo = Setting::where('key', 'logo')->first();
    	if(!$compLogo){
    		Setting::Create([ 'key' => 'logo', 'value' => '' ]);
    	}

        $userLimit = Setting::where('key', 'user_limit')->first();
        if(!$userLimit){
            Setting::Create([ 'key' => 'user_limit', 'value' => '25' ]);
        }

        $fileLimit = Setting::where('key', 'file_limit')->first();
        if(!$fileLimit){
            Setting::Create([ 'key' => 'file_limit', 'value' => '1000' ]);
        }

        $fileLimit = Setting::where('key', 'file_limit')->first();
        if(!$fileLimit){
            Setting::Create([ 'key' => 'file_limit', 'value' => '1000' ]);
        }

        $inactivty_warn = Setting::where('key', 'inactivty_warn')->first();
        if(!$inactivty_warn){
            Setting::Create([ 'key' => 'inactivty_warn', 'value' => '2' ]);
        }

        $inactivty_logout = Setting::where('key', 'inactivty_logout')->first();
        if(!$inactivty_logout){
            Setting::Create([ 'key' => 'inactivty_logout', 'value' => '3' ]);
        }

        $expiry_date = Setting::where('key', 'expiry_date')->first();
        if(!$expiry_date){
            Setting::Create([ 'key' => 'expiry_date', 'value' => date('Y-m-d', strtotime("+1 month")) ]);
        }


        //email settings
        $send_email = Setting::where('key', 'send_email')->first();
        if(!$send_email){
            Setting::Create([ 'key' => 'send_email', 'value' => 'No' ]);
        }

        $mail_host = Setting::where('key', 'mail_host')->first();
        if(!$mail_host){
            Setting::Create([ 'key' => 'mail_host', 'value' => '' ]);
        }

        $mail_username = Setting::where('key', 'mail_username')->first();
        if(!$mail_username){
            Setting::Create([ 'key' => 'mail_username', 'value' => '' ]);
        }

         $mail_password = Setting::where('key', 'mail_password')->first();
        if(!$mail_password){
            Setting::Create([ 'key' => 'mail_password', 'value' => '' ]);
        }

         $mail_port = Setting::where('key', 'mail_port')->first();
        if(!$mail_port){
            Setting::Create([ 'key' => 'mail_port', 'value' => '' ]);
        }

        $mail_encryption = Setting::where('key', 'mail_encryption')->first();
        if(!$mail_encryption){
            Setting::Create([ 'key' => 'mail_encryption', 'value' => '' ]);
        }

        $mail_sender = Setting::where('key', 'mail_sender')->first();
        if(!$mail_sender){
            Setting::Create([ 'key' => 'mail_sender', 'value' => '' ]);
        }
        
    }

}
