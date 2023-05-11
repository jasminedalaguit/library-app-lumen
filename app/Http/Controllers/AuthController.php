<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all users from database

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST(request)
        // Store all information of Users to Database
        //in_array()

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $user = new User();

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));

        $user->save();
        return response()->json($user);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // $credentials = $request->only(['username', 'password']);

        
        // $username = $request->input('username');
        // $password = $request->input('password'); 
         
        // $user = User::where('username', $username)
        //             ->where('password', $password)
        //             ->first();
                    
        // if (!$token = Auth::attempt($credentials)) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }
       
        // return $this->jsonResponse($token);
        
        $user = User::where('username', $request->input('username'))->first();
        if($user && Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(40));
            User::where('username', $request->input('username'))->update(['api_key' => "$apikey"]);;
            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'Invalid username or password!'],401);
        }
     }

     
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get user by ID 
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update user by ID 

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $user = User::find($id);

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = md5($request->input('password'));

        $user->save();
        return response()->json($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete user by ID
        $user = User::find($id);
        $user->delete();
        return response()->json('User deleted successfully!');
    }

    // public function logout(Request $request): RedirectResponse
    // {
    //     Auth::logout();
    
    //     $request->session()->invalidate();
    
    //     $request->session()->regenerateToken();
    
    //     return redirect('/');
    // }

     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    public function logout(Request $request) {
        $apikey = $request->header('Authorization');


        $test = explode(' ',$request->header('Authorization'));
        // dd($test); 

        $user = User::where('api_key', $test[1])->first();
        
        if ($user) {
            $user->api_key = null;
            $user->save();
        return response()->json(['status' => 'success']);
        } else {
        return response()->json(['status' => 'fail'], 401);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->jsonResponse(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'user'         => auth()->user(),
            'expires_in'   => auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}




    