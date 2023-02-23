<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $data['phone_raw'] = $data['phone'];
        $data['phone'] = parsePhone($data['phone']);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'min:9','max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
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

        $spec_id = '0';
        $subspecs = '0';

        if (isset($data['subspec1']) && is_array($data['subspec1']) && !in_array(0, $data['subspec1'])) {
            $subspecs = join(',', $data['subspec1']);
        } else {
            $subspecs = intval($data['subspec1'] ?? '0') ;
        }

        $user = User::create([
            'name' => trim($data['name']),
            'phone' => $phone,
            'phone_raw' => $data['phone_raw'],
            'password' => $data['password'],
            'usertype' => $data['usertype']  == User::typeMaster ? User::typeMaster : User::typeClient,
            'rating' => 0,
            'language' => join(',', $data['language'] ?? ['ru']),
            'region' => join(',', $data['region'] ?? ['_israel']),
            'status' => 'active',
            'spec_id' => $spec_id,
            'subspec_id' => $subspecs,
            'is_show_map' => 0,
            'invite_token' => strtolower(\Str::random(10)),
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
