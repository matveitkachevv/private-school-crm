<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Event
{
    public function getAll(): array
    {
        $events = [];

        foreach(\App\Models\Event::all() as $event){
            $events[] = [
                'id' => $event->id,
                'start' => (new DateTime($event->date_start))->format('Y-m-d H:i'),
                'end' => (new DateTime($event->date_end))->format('Y-m-d H:i'),
                'title' => $event->name,
                'class' => $event->class,
                'group_id' => $event->group_id,
                'split' => $event->cabinet_id,
                'background' => true
            ];
        }

        return $events;
    }

    public function create(Request $request): bool
    {
        foreach($request->get('repeats') as $date){
            $groupId = $request->get('group_id');
            $dateStart = (new DateTime($date['start']))->format('Y-m-d H:i:00');
            $dateEnd = (new DateTime($date['end']))->format('Y-m-d H:i:00');
            $newEvent = \App\Models\Event::insert([
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'name' => $request->get('name'),
                'class' => $request->get('class'),
                'cabinet_id' => $request->get('cabinet_id'),
                'group_id' => $groupId
            ]);
            if($newEvent){
                $eventId = \App\Models\Event::orderBy('id', 'desc')->first()->id;
                $userIds = \App\Models\GroupStudent::where('group_id', $groupId)->get('student_id');
                $subscribeIds = [];
                foreach($userIds as $userId){
                    $user = \App\Models\Student::find($userId->student_id);
                    $subscribes = $user->subscribes;
                    $filtredSubscribes = $subscribes->filter(function ($item) use ($groupId){
                        return
                            $groupId == $item->group_id
                            && strtotime($item->date_start) < strtotime((new DateTime())->format('d.m.Y'));
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
        return true;
    }

    public function get(int $eventId): array
    {
        $event = \App\Models\Event::find($eventId);
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
            'id' => $event->id,
            'name' => $event->name,
            'start' => $event->date_start,
            'end' => $event->date_end,
            'cabinetId' => $event->cabinet_id,
            'cabinetName' => $event->cabinet->name,
            'groupId' => $event->group_id,
            'groupName' => $event->group->name,
            'visits' => $visitList
        ];
    }

    public function delete($eventId): int
    {
        return DB::table('events')->delete($eventId);
    }
}
