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

    public function addUserToEvent(int $eventId, int $groupId, int $userId)
    {
        $subscribeIds = [];
        $userSubscribes = \App\Models\SubscribeStudent::where('student_id', $userId)->get('subscribe_id');
        $userSubscribes->each(function ($subscribe) use(&$subscribeIds){
            $subscribeIds[] = $subscribe->subscribe_id;
        });
        $currentSubscribe = \App\Models\Subscribe::whereIn('id', $subscribeIds)
            ->where('date_end', '>=', (new DateTime)->format('Y-m-d'))
            ->where('group_id', $groupId)
            ->first();

        if($currentSubscribe){
            $currentEvent = \App\Models\Event::find($eventId);
            if($currentEvent){
                $dateVisit = (new \DateTime($currentEvent->date_start))->format('d.m.Y');
                return DB::table('visits')->updateOrInsert([
                    'date_visit' => $dateVisit,
                    'visited' => false,
                    'subscribe_id' => $currentSubscribe->id,
                    'event_id' => $currentEvent->id,
                ]);
            }
        }

        return false;
    }

    public function create(Request $request): bool
    {
        foreach($request->get('repeats') as $date){
            $groupId = (int)$request->get('group_id');
            $cabinetId = (int)$request->get('cabinet_id');
            $dateStart = new \DateTime($date['start']);
            $dateEnd = new \DateTime($date['end']);

            $event = new \App\Models\Event;
            return $event->create(
                $groupId,
                $cabinetId,
                $dateStart,
                $dateEnd
            );
        }
        return false;
    }

    public function get(int $eventId): array
    {
        return (new \App\Models\Event)->get($eventId);
    }

    public function delete($eventId): int
    {
        return DB::table('events')->delete($eventId);
    }

    public function update(int $eventId, Request $request): bool
    {
        $cabinetId = $request->get('cabinetId');
        $dateStart = new \DateTime($request->get('dateStart'));
        $dateEnd = new \DateTime($request->get('dateEnd'));
        return (new \App\Models\Event)->updateEvent($eventId, $cabinetId, $dateStart, $dateEnd);
    }
}
