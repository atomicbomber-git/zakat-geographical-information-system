<?php

namespace App\Http\Controllers\Auth;

use App\Collector;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'penasehat' => 'required|string',
            'ketua' => 'required|string',
            'sekretaris' => 'required|string',
            'bendahara' => 'required|string',
            'anggota_1' => 'nullable|string',
            'anggota_2' => 'nullable|string',
            'collector_name' => 'required|string',
            'admin_name' => 'required|string', // User real name
            'username' => 'required|string|alpha_dash|unique:users', // User login name
            'password' => 'required|string|min:8|confirmed',
            'picture' => 'required|file|mimes:jpg,jpeg,png'
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $collectors = Collector::query()
            ->select('id', 'name', 'address', 'latitude', 'longitude')
            ->get();

        return view('auth.register', compact('collectors'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = null;

        DB::transaction(function() use($data, &$user) {
            $user = User::create([
                'name' => $data['admin_name'],
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'type' => 'COLLECTOR'
            ]);

            $collector = Collector::create([
                'user_id' => $user->id,
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'name' => $data['collector_name'],
            ]);

            collect([
                "penasehat",
                "ketua",
                "sekretaris",
                "bendahara",
                "anggota_1",
                "anggota_2",
            ])
            ->each(function ($field) use($data, $collector) {
                if (empty($data[$field])) {
                    return;
                }

                $collector->members()
                    ->create([
                        "position" => $field,
                        "name" => $data[$field],
                    ]);
            });

            $collector->addMediaFromRequest('picture')
                ->toMediaCollection('images');
        });

        return $user;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        session()->flash('message.success', __('messages.register.success'));

        return [
            "status" => "success",
        ];
    }
}
