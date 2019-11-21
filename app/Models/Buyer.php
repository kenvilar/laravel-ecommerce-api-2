<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
