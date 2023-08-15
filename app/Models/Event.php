<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;

    public function create(int $groupId, int $cabinetId, \DateTime $dateStart, \DateTime $dateEnd): bool
    {
        $group = \App\Models\Group::find($groupId);
        if($this->freeDates($cabinetId, $dateStart, $dateEnd)){
            $newEvent = $this->insertGetId([
                'date_start' => $dateStart->format('Y-m-d H:i:00'),
                'date_end' => $dateEnd->format('Y-m-d H:i:00'),
                'name' => $group->name,
                'class' => 'lesson',
                'cabinet_id' => $cabinetId,
                'group_id' => $groupId
            ]);

            if($newEvent > 0){
                $userIds = \App\Models\GroupStudent::where('group_id', $groupId)->get('student_id');
                $subscribeIds = [];
                foreach($userIds as $userId){
                    $user = \App\Models\Student::find($userId->student_id);
                    $subscribes = $user->subscribes;
                    $filtredSubscribes = $subscribes->filter(function ($item) use ($groupId){
                        return
                            $groupId == $item->group_id
                            && strtotime($item->date_end) >= strtotime((new \DateTime())->format('d.m.Y'));
                    });

                    if($filtredSubscribe = $filtredSubscribes->first())
                        $subscribeIds[] = $filtredSubscribe->id;
                }

                foreach($subscribeIds as $subscribeId){
                    \App\Models\Visit::insert([
                        'date_visit' => $dateStart,
                        'visited' => false,
                        'subscribe_id' => $subscribeId,
                        'event_id' => $newEvent,
                    ]);
                }
                return true;
            }
        }
        return false;
    }

    public function get(int $eventId): array
    {
        $event = $this->find($eventId);
        $visits = \App\Models\Visit::where('event_id', $eventId)->get();
        $visitList = [];

        foreach ($visits as $visit){
            $subscribe = \App\Models\SubscribeStudent::where('subscribe_id', $visit->subscribe_id)->first();
            $student = \App\Models\Student::find($subscribe->student_id);

            $visitList[] = [
                'id' => $visit->id,
                'subscribe_id' => $visit->subscribe_id,
                'visited' => $visit->visited > 0,
                'userId' => $student->id,
                'userName' => $student->name,
            ];
        }

        $studentsIds = [];
        $students = \App\Models\GroupStudent::where('group_id', $event->group_id)
            ->get('student_id');

        $students->each(function($student) use (&$studentsIds){
            $studentsIds[] = $student->student_id;
        });

        $students = \App\Models\Student::find($studentsIds);
        $students->each(function($student) use(&$visitList){
            $hasSubscribe = array_filter($visitList, function ($value) use($student){
                return $value['userId'] === $student->id;
            }, ARRAY_FILTER_USE_BOTH);

            if(empty($hasSubscribe)){
                $visitList[] = [
                    'id' => 0,
                    'subscribe_id' => 0,
                    'visited' => false,
                    'userId' => $student->id,
                    'userName' => $student->name,
                ];
            }
        });


        return [
            'id' => $event->id ?? 0,
            'name' => $event->name ?? '',
            'start' => $event->date_start ?? '',
            'end' => $event->date_end ?? '',
            'cabinetId' => $event->cabinet_id ?? 0,
            'cabinetName' => $event->cabinet->name ?? '',
            'groupId' => $event->group_id ?? 0,
            'groupName' => $event->group->name ?? '',
            'visits' => $visitList ?? []
        ];
    }

    private function freeDates(int $cabinetId, \DateTime $dateStart, \DateTime $dateEnd): bool
    {
        return !DB::table('events')
            ->where('cabinet_id', $cabinetId)
            ->where('date_start', '<', $dateEnd->format('Y-m-d H:i:s'))
            ->where('date_end', '>', $dateStart->format('Y-m-d H:i:s'))
            ->count();
    }

    public function group()
    {
        return $this->belongsTo(
            Group::class,
            'group_id',
            'id'
        );
    }

    public function cabinet()
    {
        return $this->belongsTo(
            Cabinet::class,
            'cabinet_id',
            'id'
        );
    }
}
