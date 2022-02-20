<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SendInvitation;
use App\Notifications\SendOtp;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Http\Requests\Api\AcceptInvitationRequest;

class UserController extends Controller
{
    //

    public function acceptInvitation(AcceptInvitationRequest $request)
    {

        $user = User::withOutGlobalScope('active_users')->where([
            'hash' => $request->hash
        ])->whereNull('registered_at')->first();

        if(!$user) {
            return sendError(500, 'Invalid Hash');
        }

        if($user && $user->hash == sha1($user->email)) {
                $result = $user->update([
                    'user_name' => $request->user_name,
                    'password' => \Hash::make($request->password),
                    'otp' => $user->id.\Str::random(4)
                ]);
                Notification::send($user, new SendOtp());

                return sendResponse( ['otp' => $user->otp ], 'Please verify OTP send to your email');
        }

    }

    public function login(Request $request) {

        $request->validate([
            'user_name' => 'required|exists:users,user_name',
            'password' => 'required'
        ]);

        $user = User::where([
            'user_name' => $request->user_name,

        ])->first();

        if(!$user) {
            return sendError(500, 'Invalid Credential');
        }

        if(!\Hash::check($request->password, $user->password)) {
            return sendError(500, 'Invalid Credential');
        }

        $user['token'] = $user->createToken('LaravelSanctumAuth')->plainTextToken;
        return sendResponse( $user, 'Success Fully Registerd');
    }

    public function update(ProfileUpdateRequest $request) {

        \Storage::disk('public')->delete(\Auth::user()->avatar);
        $path = $request->file('avatar')->store(\Auth::user()->id.'/avatar', 'public');

        $user = \Auth::user()->update([
            'name' => $request->name,
            'avatar' => $path,
            'email' => $request->email
        ]);

        if($user) {
            return sendResponse(\Auth::user(), 'Profile SuccessFully Updated');
        }
    }

    public function register(Request $request) {
        $user = User::withOutGlobalScope('active_users')->where([
            'otp' => $request->otp
        ])->whereNull('registered_at')->first();

        if(!$user) {
            return sendError(500, 'Invalid OTP');
        }

        if($user) {
            $user->update([
                'registered_at' => Carbon::now()
            ]);
            $user['token'] = $user->createToken('LaravelSanctumAuth')->plainTextToken;


            return sendResponse( $user, 'Success Fully Registerd');
        }

        return sendError(500, 'Invalid OTP');

    }
}
