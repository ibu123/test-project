<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendInvitation extends Model
{
    use HasFactory;

    protected $fillable = [ 'email', 'hash', 'user_name', 'password', 'otp'];

    public function routeNotificationFor()
    {
        return $this->email;
    }
}
