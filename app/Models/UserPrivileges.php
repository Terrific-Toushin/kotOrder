<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserPrivileges extends Model
{
    protected $table = 'user_privileges';
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
