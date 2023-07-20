<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Validator;
use Hash;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('users.login');
    }

    public function login(Request $request){
        // dd($request->all());
        $rules = [
            // 'username' => 'required',
            'email'                 => 'required|email',
            'password' => 'required|string'
        ];

        $messages = [
            'email.required'     => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        //dd($validator->fails());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
        
        Auth::attempt($data);
        // dd(in_array(auth()->user()->role, ['ADMIN']));

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('dashboards')
                        ->with('success','Login success!!.');

        } else { // false

            //Login Fail
            return redirect()->route('login')
                        ->with('error','Username or Password is wrong');
        }
    }

    public function logout(){
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }

    public function index(Request $request)
    {
        $data['q'] = $request->query('q');
        
        $query = User::select('users.*')
            ->where(function ($query) use ($data) {
                $query->where('users.name', 'like', '%' . $data['q'] . '%');
            });

        
        $data['users'] = $query->paginate(10)->withQueryString();
        
        // dd($data);

        return view('users.index',$data);
    }
    
    public function profile()
    {
        $data = User::where(['id'=>auth()->user()->id])->get();
        
        // dd(auth()->user());
        // dd($data['users'][0]->username);
        // dd($data[0]->id);

        return view('users.index',compact('data'));
    }

    
    public function create()
    {
        $roles = array('ADMIN'=>'ADMIN', 'DOSEN'=>'DOSEN', 'MAHASISWA'=>'MAHASISWA');
        if (Auth::check()) {
            return view('users.create', compact('roles'));
        }else{
            return view('users.register', compact('roles'));
        }
        
    }

    
    public function store(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:50',
            // 'username'              => 'required|min:3|max:35',
            'email'                 => 'email|unique:users,email',
            'password'              => 'required|confirmed',
            'role'                  => 'required'
        ];

        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 50 karakter',
            // 'username.required'     => 'Username wajib diisi',
            // 'username.min'          => 'Username lengkap minimal 3 karakter',
            // 'username.max'          => 'Username lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'role.required'        => 'Role wajib dipilih',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        // dd($request);

        $data['name'] = ucwords(strtolower($request->name));
        // $data['username'] = $request->username;
        $data['email'] = strtolower($request->email);
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->role;
        // $data['phone'] = $request->phone;
        
        // if(empty($request->status)){
        //     $data['status'] = 'off';
        // }else{
        //     $data['status'] = $request->status;
        // }

        User::create($data); //$request->all()

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('dashboards')
                        ->with('success','User created successfully.');

        } else { // false

            //Login Fail
            return redirect()->route('register')
            ->with('success','User created successfully. Please Sign In');
        }
       
        // return redirect()->route('users.index')
        //                 ->with('success','User created successfully.');

    }

    
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    
    public function edit(User $user)
    {
        $roles = array('ADMIN'=>'ADMIN', 'DOSEN'=>'DOSEN', 'MAHASISWA'=>'MAHASISWA');
        return view('users.edit',compact(['user', 'roles']));
    }

    
    public function update(Request $request, User $user)
    {
        //dd($request);
        $request->validate([
            // 'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            ]);
        
        if($request->old_password == $request->password){
            $data['password'] = $request->old_password;
        }else {
            $data['password'] = Hash::make($request->password);
        }
        // $data['name'] = $request->username;
        $data['role'] = $request->role;
        $data['email'] = strtolower($request->email);
        //$data['password'] = Hash::make($request->password);

        $data['updated_at'] = date('Y-m-d H:i:s');
      
        $user->update($data); //$request->all()
      
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    
    public function destroy(User $user)
    {
        $user->delete();
       
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
