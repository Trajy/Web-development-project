<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Employment extends Model
{
    use HasFactory;
    use FilterQueryString;

    protected $fillable = [
        'office', 'description', 'salary', 'user_id'
    ];

    protected $filters = [
        'office', 'description', 'salary', 'user_id'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

}
