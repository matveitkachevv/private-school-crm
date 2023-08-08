<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function create(int $groupId, int $cabinetId, \DateTime $dateStart, \DateTime $dateEnd): void
    {
        $group = \App\Models\Group::find($groupId);
        $newEvent = $this->insertGetId([
            'date_start' => $dateStart->format('Y-m-d H:i:00'),
            'date_end' => $dateEnd->format('Y-m-d H:i:00'),
            'name' => $group->name,
            'class' => 'lesson',
            'cabinet_id' => $cabinetId,
            'group_id' => $groupId
        ]);

        if($newEvent > 0){
            $eventId = $this->orderBy('id', 'desc')->first()->id;
            $userIds = \App\Models\GroupStudent::where('group_id', $groupId)->get('student_id');
            $subscribeIds = [];
            foreach($userIds as $userId){
                $user = \App\Models\Student::find($userId->student_id);
                $subscribes = $user->subscribes;
                $filtredSubscribes = $subscribes->filter(function ($item) use ($groupId){
                    return
                        $groupId == $item->group_id
                        && strtotime($item->date_start) < strtotime((new \DateTime())->format('d.m.Y'));
                });

                if($filtredSubscribe = $filtredSubscribes->first())
                    $subscribeIds[] = $filtredSubscribe->id;
            }

            foreach($subscribeIds as $subscribeId){
                \App\Models\Visit::insert([
                    'date_visit' => $dateStart,
                    'visited' => false,
                    'subscribe_id' => $subscribeId,
                    'event_id' => $eventId,
                ]);
            }
        }
    }

    public function get(int $eventId): array
    {
        $event = $this->find($eventId);
        $visits = \App\Models\Visit::where('event_id', $eventId)->get();

        $visitList = [];

        foreach ($visits as $visit){
            $subscribe = \App\Models\SubscribeStudent::where('subscribe_id', $visit->subscribe_id)->first();
            $user = \App\Models\Student::find($subscribe->student_id);

            $visitList[] = [
                'id' => $visit->id,
                'subscribe_id' => $visit->subscribe_id,
                'visited' => $visit->visited > 0,
                'userId' => $user->id,
                'userName' => $user->name,
            ];
        }

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
