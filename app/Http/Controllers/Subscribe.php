<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Subscribe
{
    public function create(Request $request)
    {
        $subscribe = $request->get('subscribe');

        $subscribeId = DB::table('subscribes')->insertGetId([
            'name' => $subscribe['name'],
            'price' => $subscribe['cost'],
            'count' => $subscribe['count'],
            'date_start' => $subscribe['dateStart'],
            'date_end' => $subscribe['dateEnd'],
            'payment' => true,
        ]);

        $studentId = $request->get('studentId');
        DB::table('subscribe_students')->insert([
            'subscribe_id' => $subscribeId,
            'student_id' => $studentId,
        ]);
        return true;
    }

    public function paymentChange($subscribeId): bool
    {
        $payment = \App\Models\Subscribe::find($subscribeId)->payment > 0;
        return \App\Models\Subscribe::find($subscribeId)->update([
            'payment' => !$payment
        ]);
    }

    public function delete($subscribeId): int
    {
        return DB::table('subscribes')->delete($subscribeId);
    }
}
