<?php

namespace DavidPella\BeemSms\Tests\Unit;

use DavidPella\BeemSms\Models\User;
use DavidPella\BeemSms\Notifications\AccountActivated;
use DavidPella\BeemSms\Notifications\AnotherNotification;
use DavidPella\BeemSms\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class NotifyAccountWasActivatedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_notify_a_user_that_a_account_was_activated()
    {
        Notification::fake();

        $user = User::factory()->create();

        Notification::assertNothingSent();

        $user->notify(new AccountActivated);

        Notification::assertSentTo(
            [$user], AccountActivated::class
        );

        Notification::assertNotSentTo(
            [$user], AnotherNotification::class
        );
    }
}
