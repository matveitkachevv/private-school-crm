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
            $groupId = (int)$request->get('group_id');
            $cabinetId = (int)$request->get('cabinet_id');
            $dateStart = new \DateTime($date['start']);
            $dateEnd = new \DateTime($date['end']);

            $event = new \App\Models\Event;
            $event->create(
                $groupId,
                $cabinetId,
                $dateStart,
                $dateEnd
            );
        }
        return true;
    }

    public function get(int $eventId): array
    {
        return (new \App\Models\Event)->get($eventId);
    }

    public function delete($eventId): int
    {
        return DB::table('events')->delete($eventId);
    }
}
