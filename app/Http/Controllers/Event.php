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
            DB::table('events')->insert([
                'date_start' => (new DateTime($date['start']))->format('Y-m-d H:i:00'),
                'date_end' => (new DateTime($date['end']))->format('Y-m-d H:i:00'),
                'name' => $request->get('name'),
                'class' => $request->get('class'),
                'cabinet_id' => $request->get('cabinet_id'),
                'group_id' => $request->get('group_id'),
            ]);
        }
        return true;
    }

    public function get(int $eventId): array
    {
        $event = \App\Models\Event::find($eventId);
        return [
            'id' => $event->id,
            'name' => $event->name,
            'start' => $event->date_start,
            'end' => $event->date_end,
            'cabinetId' => $event->cabinet_id,
            'cabinetName' => $event->cabinet->name,
            'groupId' => $event->group_id,
            'groupName' => $event->group->name,
        ];
    }

    public function delete($eventId): int
    {
        return DB::table('events')->delete($eventId);
    }
}
