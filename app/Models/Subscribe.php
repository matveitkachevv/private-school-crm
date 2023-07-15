<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $fillable = [
      'payment'
    ];

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'subscribe_students',
            'group_id',
            'student_id'
        );
    }
}
