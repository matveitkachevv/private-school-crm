<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Note
{
    public function create(Request $request): bool
    {
        $dateStart = $request->get('dateStart');
        $dateEnd = $request->get('dateEnd');
        $noteText = $request->get('noteText');

        return \App\Models\Note::insert([
            'date_start' => (new \DateTime($dateStart))->format('Y-m-d H:i:00'),
            'date_end' => (new \DateTime($dateEnd))->format('Y-m-d H:i:00'),
            'text' => $noteText,
        ]);
    }

    public function getAll(): array
    {
        $notes = [];
        foreach(\App\Models\Note::all() as $note){
            $notes[] = [
                'id' => $note->id,
                'title' => $note->text,
                'start' => $note->date_start,
                'end' => $note->date_end,
                'background' => true,
                'class' => 'note',
            ];
        }
        return $notes;
    }

    public function get($noteId): array
    {
        $note = \App\Models\Note::find($noteId);
        return [
          'id' => $note->id,
          'text' => $note->text,
          'date_start' => $note->date_start,
          'date_end' => $note->date_end,
        ];
    }

    public function delete($noteId): bool
    {
        return DB::table('notes')->delete($noteId);
    }
}
