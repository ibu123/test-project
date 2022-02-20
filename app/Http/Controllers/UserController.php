<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function acceptInvitation(Request $request) {
        return "please call api route ".route('user.accept.invitation').' with request query parameter hash, post params user name and password params';
    }
}
