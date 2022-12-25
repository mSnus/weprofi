<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Userinfo;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
include_once(base_path().'/app/helpers.php');

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:9','max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $phone = parsePhone($data['phone']);

        $user = User::create([
            'name' => trim($data['name']),
            'phone' => $phone,
            'password' => Hash::make($data['password']),
            'usertype' => $data['usertype']  == User::typeMaster ? User::typeMaster : User::typeClient,
            'rating' => 5,
            'language' => join(',', $data['language'] ?? ['ru']),
            'region' => join(',', $data['region'] ?? ['_israel']),
        ]);


        if ($data['usertype'] == User::typeMaster ) {
            if (isset( $data['subspec1'] ) && !empty( $data['subspec1'] )) {
                $spec_data = [];

                foreach ($data['subspec1'] as $subspec1) {
                    $spec_data[] = [
                        'user_id' => $user->id, 
                        'spec_id' => $data['spec1'], 
                        'subspec_id' => $subspec1
                    ];
                }
            } else {
                $spec_data[] = [
                        'user_id' => $user->id, 
                        'spec_id' => $data['spec1'], 
                        'subspec_id' =>  0
                    ];
            }

            DB::table('user_spec')->insert($spec_data);
        }

        Auth::loginUsingId($user->id);

        return $user;
    }
}
