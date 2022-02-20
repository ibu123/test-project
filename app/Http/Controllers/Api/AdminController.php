<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SendInvitation;
use App\Http\Controllers\Controller;
use App\Notifications\SendInvitationEmail;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    public function __construct() {

    }

    /**
     * Used to send Invitation
     * Illluminate\Http\Request $request
     *
     * return Illuminate\Http\Response
     */
    public function sendInvitation(Request $request) {



        $request->validate([
            'email' => 'required|email|max:255|unique:users,email'
        ]);


        try {

            $hash = sha1($request->email);

            $user = User::withOutGlobalScope('active_users')->updateOrCreate([
                'email' => $request->email
            ],[
                'hash' => $hash,
                'password' => \Hash::make(\Str::random(8))
            ]);

            Notification::send($user, new SendInvitationEmail());

            return sendResponse( $user, 'Invitation Successfully Send');

        } catch(\Exception $e) {
            return sendError (500, $e->getMessage());
        }
    }
}
