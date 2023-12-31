<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\TestFixture\func;

class User
{
    public function create(Request $request): bool
    {
         return DB::table('students')->insert([
           'name' => $request->get('name'),
           'phone' => $request->get('phone'),
           'comment' => $request->get('comment')
        ]);
    }

    public function update(int $userId, Request $request): bool
    {
        $user = $request->get('user');
        $userName = $user['name'];
        $userPhone = $user['phone'];
        $userComment = $user['comment'];

        return \App\Models\Student::find($userId)->update([
            'name' => $userName,
            'phone' => $userPhone,
            'comment' => $userComment,
        ]);
    }

    public function getAll(): array
    {
        $students = [];
        $users = Student::select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $users->each(function ($user) use(&$students){
            $students[] = [
                'id' => $user->id,
                'name' => $user->name
            ];
        });
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

    public function getUserGroups(int $userId): array
    {
        $groupIds = [];
        $groups = \App\Models\GroupStudent::where(['student_id' => $userId])->get('group_id');
        $groups->each(function($group) use(&$groupIds){
            $groupIds[] = $group->group_id;
        });

        $groupsList = [];
        $groups = \App\Models\Group::whereIn('id', $groupIds)
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $groups->each(function($group) use (&$groupsList){
            $groupsList[] = [
                'id' => $group->id,
                'name' => $group->name
            ];
        });
        return $groupsList;
    }

    public function getSubscribes(int $userId): array
    {
        $subscribeList = [];
        $subscribes = Student::find($userId)
            ->subscribes
            ->sortDesc()
            ->take(3);

        $subscribes->each(function($subscribe) use(&$subscribeList){
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
                    'event_id' => $visit->event_id,
                    'subscribe_id' => $visit->subscribe_id
                ];

                if($visit->visited > 0)
                    $visitCount++;
            }

            $groupName = \App\Models\Group::find($subscribe->group_id);

            $subscribeList[] = [
                'id' => $subscribe->id,
                'name' => $subscribe->name,
                'price' => $subscribe->price,
                'count' => $subscribe->count,
                'groupId' => $groupName->id,
                'groupName' => $groupName->name,
                'date_start' => $subscribe->date_start,
                'date_end' => $subscribe->date_end,
                'payment' => $subscribe->payment,
                'visits' => $visits,
                'visit_count' => $visitCount,
            ];
        });

        return $subscribeList;
    }
}
