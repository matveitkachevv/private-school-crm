<?php

namespace Tests\Unit\Models;

use Tests\TestCase;

class EventTest extends TestCase
{
    public function testCreateSuccessEvent()
    {
        $response = $this->post('/event/', [
            'group_id' => 1,
            'cabinet_id' => 1,
            'repeats' => [
                [
                    'start' => '09.08.2023 10:00',
                    'end' => '09.08.2023 12:00'
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function testCreateFailEvent()
    {
        $response = $this->post('/event/', [
            'group_id' => 0,
            'cabinet_id' => 0,
            'repeats' => [
                [
                    'start' => '09.08.2023 10:00',
                    'end' => '09.08.2023 12:00'
                ]
            ]
        ]);
        $response->assertStatus(500);
    }

    public function testGetEventArray()
    {
        $event = (new \App\Models\Event)->get(0);
        $this->assertArrayHasKey('id', $event);
        $this->assertArrayHasKey('name', $event);
        $this->assertArrayHasKey('start', $event);
        $this->assertArrayHasKey('end', $event);
        $this->assertArrayHasKey('cabinetId', $event);
        $this->assertArrayHasKey('cabinetName', $event);
        $this->assertArrayHasKey('groupId', $event);
        $this->assertArrayHasKey('groupName', $event);
        $this->assertArrayHasKey('visits', $event);
    }
}
