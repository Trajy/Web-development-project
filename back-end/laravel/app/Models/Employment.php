<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer;

class Employment extends Model
{
    use HasFactory;

    public function employer()
    {
        return $this->belongsTo(Employment::class);
    }

}
