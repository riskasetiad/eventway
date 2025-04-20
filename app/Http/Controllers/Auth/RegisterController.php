<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan Anda memiliki file register.blade.php di resources/views/auth
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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi gambar
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
        $imagePath = null;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $data['image']->store('profile_images', 'public');
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'image'    => $imagePath,
        ]);

        // Berikan role "user" ke pengguna baru
        try {
            DB::transaction(function () use ($user) {
                $user->assignRole('User');
            });
        } catch (\Exception $e) {
            Log::error('Gagal memberikan role user: ' . $e->getMessage());
        }

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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $user = $this->create($data);

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }
}
