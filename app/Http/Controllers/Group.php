<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Group
{
    public function getAll(): array
    {
        $result = [];
        $groups = \App\Models\Group::select(['id', 'name'])
            ->orderBy('name')
            ->get();

        $groups->each(function($group) use(&$result){
            $result[] = [
                'id' => $group->id,
                'name' => $group->name
            ];
        });

        return $result;
    }

    public function setStudentsGroup(int $groupId, Request $request): bool
    {
        \App\Models\GroupStudent::where(['group_id' => $groupId])->delete();
        $students = $request->get('students') ?? [];
        for($i = 0; $i < count($students); $i++){
            \App\Models\GroupStudent::updateOrInsert([
                'student_id' => $students[$i],
                'group_id' => $groupId
            ]);
        }
        return true;
    }

    public function studentsGroup(int $groupId): array
    {
        $studentIds = [];
        $students = \App\Models\GroupStudent::where(['group_id' => $groupId])->get('student_id');

        foreach($students as $student){
            $studentIds[] = $student->student_id;
        }
        return $studentIds;
    }

    public function update(int $groupId, Request $request): bool
    {
        $groupName = $request->get('groupName');
        return \App\Models\Group::find($groupId)->update([
           'name' => $groupName
        ]);
    }

    public function create(Request $request): int
    {
        return \App\Models\Group::insertGetId([
            'name' => $request->get('groupName')
        ]);
    }

    public function get(int $groupId): \Illuminate\Http\JsonResponse
    {
        try{
            return response()->json((new \App\Models\Group)->get($groupId));
        } catch (\ErrorException $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function delete($groupId): int
    {
        return DB::table('groups')->delete($groupId);
    }
}
