<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function get(int $groupId): array
    {
        if($group = $this->find($groupId)){
            $students = [];
            $groupStudentsIds = \App\Models\GroupStudent::where(['group_id' => $groupId])->get('student_id');
            foreach($groupStudentsIds as $studentId){
                $student = \App\Models\Student::find($studentId->student_id);
                $students[$student->id] = [
                    'id' => $student->id,
                    'name' => $student->name
                ];
            }

            return [
                'id' => $group->id,
                'name' => $group->name,
                'students' => $students
            ];
        }
        throw new \ErrorException('Группа не найдена', 404);
    }
}
