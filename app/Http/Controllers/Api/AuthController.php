<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails())
        {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response,400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('test_sanctum')->plainTextToken;
        $success['name'] = $user->name;

        

        $response = [
            'success' => true,
            'date' => $success,
            'message' => 'User registered successfully!'
        ];

        return response()->json($response,201);
    }


    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('test_sanctum')->plainTextToken;
            $success['name'] = $user->name;

            $response = [
                'success' => true,
                'date' => $success,
                'message' => 'User loggedin successfully!'
            ];
            return response()->json($response,200);
        }
        else{
            $response = [
                'success' => false,
               'message' => 'Unathorized',
            ];
            return response()->json($response,401);
        }


    }
}
