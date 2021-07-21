<?php

namespace DavidPella\BeemSms\Tests\Unit;

use DavidPella\BeemSms\Models\TestUser;
use DavidPella\BeemSms\Notifications\AccountActivated;
use DavidPella\BeemSms\Notifications\AnotherNotification;
use DavidPella\BeemSms\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

class NotifyAccountWasActivatedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_notify_a_user_that_a_account_was_activated()
    {
        Notification::fake();

        $user = TestUser::factory()->create();

        Notification::assertNothingSent();

        $user->notify(new AccountActivated());

        Notification::assertSentTo(
            [$user],
            AccountActivated::class
        );

        Notification::assertNotSentTo(
            [$user],
            AnotherNotification::class
        );
    }

    public function it_()
    {
        Notification::assertSentTo(
            new AnonymousNotifiable(),
            AccountActivated::class
        );
    }
}
