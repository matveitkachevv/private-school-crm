<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Subscribe
{
    public function create(Request $request)
    {
        $subscribe = $request->get('subscribe');
        $subscribeId = \App\Models\Subscribe::insertGetId([
            'name' => $subscribe['name'],
            'price' => $subscribe['cost'],
            'count' => $subscribe['count'],
            'date_end' => $subscribe['dateEnd'],
            'group_id' => $subscribe['group_id']
        ]);
        if($subscribeId > 0){
            $studentId = $request->get('studentId');
            \App\Models\SubscribeStudent::insert([
                'subscribe_id' => $subscribeId,
                'student_id' => $studentId,
            ]);
            return true;
        }
        return false;
    }

    public function get(int $subscribeId): array
    {
        $subscribe = \App\Models\Subscribe::find($subscribeId);
        return [
            'id' => $subscribe->id,
            'name' => $subscribe->name,
            'price' => $subscribe->price,
            'count' => $subscribe->count,
            'date_end' => $subscribe->date_end,
            'group_id' => $subscribe->group_id,
        ];
    }

    public function update(int $subscribeId, Request $request): bool
    {
        $subscribe = $request->get('subscribe');
        return \App\Models\Subscribe::find($subscribeId)->update([
            'name' => $subscribe['name'],
            'group_id' => $subscribe['group_id'],
            'price' => $subscribe['price'],
            'date_end' => $subscribe['date_end'],
            'count' => $subscribe['count'],
        ]);
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
