<?php

namespace App\Http\Controllers;

class Visit
{
    public function change($visitId): bool
    {
        $visited = \App\Models\Visit::find($visitId)->visited;
        return \App\Models\Visit::find($visitId)->update([
            'visited' => !($visited > 0)
        ]);
    }
}
