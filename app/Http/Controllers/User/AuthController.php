<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Image;


class AuthController extends Controller
{
    /**
     *php composer.phar require intervention/image Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterUserRequest $request)
    {

        $user = new User();
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
       
        if ($request->has('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $request->image->extension();
            $path = 'uploads/users/';
            
            $publicPath = public_path($path);
            if (!is_dir($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            $file->move($publicPath, $fileName);
            $user->image = $publicPath . $fileName;
        }
        $user->save();


        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json($response, 201);
    }
    public function login(LoginUserRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !hash::check($request->password, $user->password)) {
                return response([
                    'message' => 'login error'
                ], 401);
            }
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Déconnecté'
        ];
    }
    public function connectedUser()
    
    {
        $user = auth()->user();
        return response()->json([
            'message'=> 'Utilisateur connecté:',
            'user'=>$user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
