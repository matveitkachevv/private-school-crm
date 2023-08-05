<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $fillable = [
      'payment',
      'name',
      'price',
      'count',
      'date_end',
      'group_id',
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
