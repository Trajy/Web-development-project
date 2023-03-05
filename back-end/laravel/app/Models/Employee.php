<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'surname', 'cpf', 'birth_date', 'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
