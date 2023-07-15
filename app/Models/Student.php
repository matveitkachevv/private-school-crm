<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'comment',
        'group_id',
    ];

    public function group()
    {
        return $this->belongsTo(
            Group::class,
            'group_id',
            'id'
        );
    }

    public function subscribes()
    {
        return $this->belongsToMany(
            Subscribe::class,
            'subscribe_students',
            'student_id',
            'id'
        );
    }
}
