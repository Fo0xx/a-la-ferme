<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = 200)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**
     * Check if the authenticated user is the owner of the resource or if the user is admin
     * 
     * @param int $user_id
     * 
     * @return true if the user is the owner of the resource or if the user is admin
     */
    public function checkUser(int $user_id) {
        
        while(User::find(Auth::user()->id)) {
            if (Auth::user()->id != $user_id) {
                return false;
            }
            break;
        }

        return true;
    }
}