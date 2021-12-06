<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request = Request::create('api/register', 'POST');
    }

    protected function verify(Request $request)
    {
        $fields = $request->validate([
            'verification_code' => 'required|numeric',
            'phone_number' => 'required|numeric',
        ]);
        /* Get credentials from .env */
        $tokenTwilio = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $tokenTwilio);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($fields['verification_code'], array('to' => $fields['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $fields['phone_number']))->update(['isVerified' => true]);
            /* Authenticate user */
            Auth::login($user->first());
            return [
                'message' => 'Phone number verified'
            ];
        }
    }

    public function logout(Request $request ) {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }

    public function login(Request $request) {
        try {
            $result = $this->api_post('/login', $request->all());

            if (!$result->success) {
                $msg = self::getErrorMessage($result->message);
                return back()->withInput(request()->except('password'))->with('error', $msg);
            }

            $session = new Session();
            $session->set('auth_session', $result->data);

            return Redirect::to($result->data->redirect ?? 'admin');
        } catch (Exception $e) {
            return Redirect::to('/error')->with('error', $e->getMessage());
        }
    }
}
