<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;
use App\Sale;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required',
            // 'device_name' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->errorResponse($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->hasRole('Cashier')) {
            return $this->errorResponse("Sorry, You cannot login from this end");
        }

        if ($user == null || !Hash::check($request->password, $user->password)) {

            return $this->errorResponse('The provided credentials are incorrect.');
        }


        $existent = Sale::where('user_id', $user->id)->where('finalized_at', null)->first();
        // return $existent;
        if(is_null($existent)) {

            try {
                //code...
                $client = Client::create([
                    'name' => $user->name." Shift ".Carbon::now()->toDayDateTimeString(),
                    'email' => "",
                    "phone" => ""
                ]);

                $existent = Sale::create([
                    'user_id' => $user->id,
                    'client_id' => $client->id
                ]);
                
            } catch (\Throwable $th) {
                //throw $th;
                Log::error("Error creating Sale: ".$th->getMessage());
                return $this->errorResponse("Error logging you in, Contact your admin".$th->getMessage());
            }

        }

        // $sale = $model->create($request->all());

        return $this->successResponse("Login successful", [
            'user' => $user->toArray(),
            'token' => $user->createToken('Happiness Kitchen Token')->plainTextToken,
            'salesId' => $existent->id
        ]);
    }
    public function logout(Request $request)
    {

        if (Auth::user()) {

            $user = Auth::user();

            $user->tokens()->delete();

            return $this->successResponse('Successfully logged out');
        } else {
            return $this->failureResponse('Successfully logged out');
        }
    }
}
