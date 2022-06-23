<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Sign in method for users
     * 
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        if (!empty($request->email) && !empty($request->password)) {

            if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $authUser = Auth::guard('user')->user();
                
                $success['token'] = $authUser->createToken('MaFermeLocale')->plainTextToken;

                // User data
                $user = User::find($authUser->id)->get()->toArray();
                foreach ($user as $valueUser){
                    foreach ($valueUser as $keyPropUser => $valuePropUser) {
                        $success[$keyPropUser] = $valuePropUser;
                    }
                }

                return $this->sendResponse($success, 'User signed in.');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }

        } else {
            $error = [
                'error' => 'Bad Request.', 
                'email' => 'The email field is required.',
                'password' => 'The password field is required.'
            ];

            return $this->sendError('Bad Request.', $error, 400);
        }
    }

    /**
     * Sign up method for user
     * 
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return $this->sendResponse($user, 'User created successfully.', 201);
    }

    /**
     * Sign out method for user
     * 
     * @return \Illuminate\Http\Response
     */
    public function signoutUser(Request $request)
    {
        //get the token id from the header
        $token = $request->header('Authorization');
        $token_id = str_replace('Bearer ', '', $token);

        $request->user('sanctum_user')->tokens()->where('id', $token_id )->delete();
        
        return $this->sendResponse([], 'User Signed out.');
    }

    /**
     * Sign up method for admin
     * 
     * @return \Illuminate\Http\Response
     */
    public function signupAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $admin = Admin::create($input);

        return $this->sendResponse($admin, 'Admin created successfully.', 201);
    }

    /**
     * Sign in method for admin 
     * 
     * @return \Illuminate\Http\Response
     */
    public function signinAdmin(Request $request)
    {
        if (!empty($request->email) && !empty($request->password)) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $authAdmin = Auth::guard('admin')->user();
                $success['token'] =  $authAdmin->createToken('MaFermeLocaleAdmin')->plainTextToken;
                
                // Admin data
                $admin = Admin::find($authAdmin->id)->get()->toArray();
                foreach ($admin as $valueAdmin){
                    foreach ($valueAdmin as $keyPropAdmin => $valuePropAdmin) {
                        $success[$keyPropAdmin] = $valuePropAdmin;
                    }
                }

                return $this->sendResponse($success, 'Admin signed in');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
        } else {
            $error = [
                'error' => 'Bad Request', 
                'email' => 'The email field is required.',
                'password' => 'The password field is required.'
            ];

            return $this->sendError('Bad Request.', $error, 400);
        }
    }

    /**
     * Sign out method for admin
     * 
     * @return \Illuminate\Http\Response
     */
    public function signoutAdmin(Request $request)
    {
        //get the token id from the header
        $token = $request->header('Authorization');
        $token_id = str_replace('Bearer ', '', $token);

        $request->user('sanctum_admin')->tokens()->where('id', $token_id )->delete();

        //$request->user('sanctum_admin')->currentAccessToken()->delete();
        
        return $this->sendResponse([], 'Admin signed out.');
    }
}
