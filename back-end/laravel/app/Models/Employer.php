<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Employment;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj', 'bussiness_name', 'fantasy_name', 'user_id',
        'country', 'cep', 'state', 'city','address',
        'neighborhood', 'number', 'phone'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function employments()
    {
        return $this->hasMany(Employment::class);
    }
}
