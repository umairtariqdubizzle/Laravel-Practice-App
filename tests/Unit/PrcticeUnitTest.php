<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyUser;
use App\Models\User;

class PrcticeUnitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_send_notification(): void
    {

        Notification::fake();

        $user = User::factory()->create();
        $user->notify(new NotifyUser());

        Notification::assertSentTo(
            $user,
            NotifyUser::class
        );
        // Queue::fake();
        // $response = $this->get('/');
        // $response->assertStatus(200);
        // Queue::assertPushed(Notify::class);
        // $user = User::factory()->create();
        // $response = $this->get('/');
        // $response->assertStatus(200);
    }
}
