<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function createUser(Request $request)
    {
        // Validator

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'phone' => 'required|numeric',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            $result = array('status' => false, 'message' => 'validation error occured', 'error_message' => $validator->errors());
            return response()->json($result, 400);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        if ($user->id) {
            $responsecode = 200;
            $result = array('status' => true, 'message' => 'user created', 'data' => $user);
        } else {
            $responsecode = 400;
            $result = array('status' => false, 'message' => 'validation error occured', 'error_message' => $validator->errors());
        }

        return response()->json($result, $responsecode);
    }
    public function getUsers(Request $request)
    {

        $users = User::all();

        $result = array('status' => true, 'message' => count($users) . ' user(s) fetched.');

        $responsecode = 200;

        return response()->json($result, $responsecode);
    }
    public function getUserDetail($id)
    {

        $users = User::find($id);

        $result = array('status' => true, 'message' => $users . ' user(s) fetched.');

        $responsecode = 200;

        return response()->json($result, $responsecode);
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'user not found'], 404);
        }


        // Validator

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'phone' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $result = array('status' => false, 'message' => 'validation error occured', 'error_message' => $validator->errors());
            return response()->json($result, 400);
        }

        // update code

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        $responsecode = 200;
        $result = array('status' => true, 'message' => 'user has been updated successfully', 'data' => $user, $responsecode);

        return response()->json($result, $responsecode);
    }
}