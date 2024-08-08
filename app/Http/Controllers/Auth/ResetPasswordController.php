<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\HelperService;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function checkVariable(Request $request)
    {
        $key = $request->input('key');
        $macAddress = $this->getMacAddress();
        $generatedKey = HelperService::generateLicenseKey($macAddress);

        if ($this->checkkey($macAddress,$key) === $generatedKey) {
          
            if (File::exists(storage_path('framework/cache/.hidden_license_key'))) {
                return response()->json(['message' => 'License already verified'], 403);
            }

            // Store the  key and MAC address in a hidden file
            // $data = [
            //     'key' => Crypt::encryptString($key),
            //     'mac' => Crypt::encryptString($macAddress),
            // ];

            try {
                File::put(storage_path('framework/cache/.hidden_license_key'), $this->checkkey($macAddress,$key));
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to store  data'], 500);
            }

            return response()->json(['message' => 'verified successfully'], 200);
        }

        return response()->json(['message' => 'Invalid  key'], 403);
    }


    /**
     * Get the MAC address of the system.
     *
     * @return string
     */
    private function getMacAddress()
    {
        $output = exec('getmac'); // For Windows
        // Extract the first 17 characters, which represent the MAC address
        $macAddress = substr($output, 0, 17);
        return $macAddress;
    }
   
    private function checkkey(string $macAddress,$key){
       
        return hash('sha256', $macAddress . $key);
    }
    
}
