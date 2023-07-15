<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Group
{
    public function getAll(): array
    {
        $groups = [];

        foreach(\App\Models\Group::all() as $group){
            $groups[] = [
                'id' => $group->id,
                'name' => $group->name
            ];
        }

        return $groups;
    }

    public function create(Request $request): int
    {
        DB::table('groups')->insert([
            'name' => $request->get('groupName')
        ]);

        $groupId = DB::table('groups')
            ->where('name', $request->get('groupName'))
            ->value('id');

        foreach($request->get('students') as $student){
            DB::table('students')->where('id', $student)->update([
               'group_id' => $groupId
            ]);
        }
        return $groupId;
    }

    public function get($groupId): array
    {
        $group = \App\Models\Group::find($groupId);
        $students = [];

        foreach($group->students as $student){
            $students[$student->id] = [
                'id' => $student->id,
                'name' => $student->name
            ];
        }

        return [
            'id' => $group->id,
            'name' => $group->name,
            'students' => $students
        ];
    }

    public function delete($groupId): int
    {
        return DB::table('groups')->delete($groupId);
    }
}
