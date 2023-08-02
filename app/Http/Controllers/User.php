<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User
{
    public function create(Request $request): bool
    {
         return DB::table('students')->insert([
           'name' => $request->get('name'),
           'phone' => $request->get('phone'),
           'comment' => $request->get('comment'),
           'group_id' => $request->get('group_id')
        ]);
    }

    public function getAll(): array
    {
        $students = [];
        foreach(Student::all() as $user){
            $students[] = [
                'id' => $user->id,
                'name' => $user->name
            ];
        }
        return $students;
    }

    public function delete(int $userId): int
    {
        return DB::table('students')->delete($userId);
    }

    public function get(int $userId): array
    {
        $student = Student::find($userId);
        return [
            'id' => $student->id,
            'name' => $student->name,
            'phone' => $student->phone,
            'comment' => $student->comment,
            'groupId' => $student->group->id ?? 0,
            'groupName' => $student->group->name ?? '',
            'subscribes' => []
        ];
    }

    public function changeGroup(int $userId, Request $request): int
    {
        return Student::find($userId)->update([
            'group_id' => $request->get('group_id')
        ]);
    }

    public function getSubscribes(int $userId): array
    {
        $subscribeList = [];
        $visitCount = 0;

        $subscribes = Student::find($userId)->subscribes;
        foreach($subscribes as $subscribe){
            $visits = [];
            $visitCount = 0;

            $visitList = DB::table('visits')
                ->where('subscribe_id', $subscribe->id)
                ->get();

            foreach($visitList as $visit){
                $visits[] = [
                  'id' => $visit->id,
                  'date_visit' => $visit->date_visit,
                  'visited' => $visit->visited > 0,
                  'event_id' => $visit->event_id
                ];

                if($visit->visited > 0)
                    $visitCount++;
            }

            $subscribeList[] = [
                'id' => $subscribe->id,
                'name' => $subscribe->name,
                'price' => $subscribe->price,
                'count' => $subscribe->count,
                'date_start' => $subscribe->date_start,
                'date_end' => $subscribe->date_end,
                'payment' => $subscribe->payment,
                'visits' => $visits,
                'visit_count' => $visitCount,
            ];
        }
        return $subscribeList;
    }
}
