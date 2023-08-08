<?php

namespace Tests\Unit;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testMainApp()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testGroups()
    {
        $response = $this->get('/groups/');
        $response->assertStatus(200);
    }

    public function testCabinets()
    {
        $response = $this->get('/cabinets/');
        $response->assertStatus(200);
    }

    public function testUsers()
    {
        $response = $this->get('/users/');
        $response->assertStatus(200);
    }

    public function testNotes()
    {
        $response = $this->get('/notes/');
        $response->assertStatus(200);
    }
}
