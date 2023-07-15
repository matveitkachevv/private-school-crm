<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cabinet
{
    public function get(): array
    {
        $cabinets = [];

        foreach(\App\Models\Cabinet::all() as $cabinet){
            $cabinets[] = [
                'id' => $cabinet->id,
                'label' => $cabinet->name
            ];
        }

        return $cabinets;
    }

    public function create(Request $request): int
    {
        return \App\Models\Cabinet::insert([
            'name' => $request->get('cabinetName')
        ]);
    }

    public function delete($cabinetId): int
    {
        return DB::table('cabinets')->delete($cabinetId);
    }
}
