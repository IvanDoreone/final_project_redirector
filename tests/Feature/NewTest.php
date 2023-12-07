<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewTest extends TestCase
{
    /**
     * A basic feature test example.
     * @group listt
     */
    public function test_example(): void
    {
        $response = $this->get('/news');

        $response->assertStatus(200);
    }
}
