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
        $eventsList = \App\Models\Event::all();
        $eventsList->each(function ($event) use(&$events){
            $events[] = [
                'id' => $event->id,
                'start' => (new \DateTime($event->date_start))->format('Y-m-d H:i'),
                'end' => (new \DateTime($event->date_end))->format('Y-m-d H:i'),
                'title' => $event->name,
                'class' => $event->class,
                'group_id' => $event->group_id,
                'split' => $event->cabinet_id,
                'background' => true
            ];
        });
        return $events;
    }

    public function addUserToEvent(int $eventId, int $groupId, int $userId): \Illuminate\Http\JsonResponse
    {
        try{
            return response()->json((new \App\Models\Event)->addUserToEvent($eventId, $groupId, $userId));
        } catch (\ErrorException $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            foreach ($request->get('repeats') as $date) {
                $groupId = (int)$request->get('group_id');
                $cabinetId = (int)$request->get('cabinet_id');
                $dateStart = new \DateTime($date['start']);
                $dateEnd = new \DateTime($date['end']);

                $event = new \App\Models\Event;
                return response()
                    ->json($event->create(
                        $groupId,
                        $cabinetId,
                        $dateStart,
                        $dateEnd
                    ));
            }
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());
        }
        return response()->json(['error' => true, 'message' => 'Не удалось создать занятие'], 401);
    }

    public function get(int $eventId): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json((new \App\Models\Event)->get($eventId));
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function delete($eventId): int
    {
        return DB::table('events')->delete($eventId);
    }

    public function update(int $eventId, Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $cabinetId = $request->get('cabinetId');
            $dateStart = new \DateTime($request->get('dateStart'));
            $dateEnd = new \DateTime($request->get('dateEnd'));
            return response()->json((new \App\Models\Event)->updateEvent($eventId, $cabinetId, $dateStart, $dateEnd));
        } catch (\ErrorException $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());
        }
    }
}
