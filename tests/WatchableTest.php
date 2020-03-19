<?php

namespace Telkins\Watchable\Tests;

use Telkins\Watchable\Tests\Support\Models\Movie;
use Telkins\Watchable\Tests\Support\Models\User;

class WatchableTest extends TestCase
{
    /** @test */
    public function an_unwatched_watchable_has_no_watchers()
    {
        $user = User::first();
        $movie = Movie::create(['title' => 'Star Wars: A New Hope']);

        $this->assertCount(0, $movie->watchers);
    }

    /** @test */
    public function a_watched_watchable_has_watchers()
    {
        $user = User::first();
        $movie = Movie::create(['title' => 'Star Wars: A New Hope']);

        $movie->addWatcher($user->id);
        $this->assertCount(1, $movie->watchers);
    }

    /** @test */
    public function a_watched_watchable_can_stop_being_watched()
    {
        $user = User::first();
        $movie = Movie::create(['title' => 'Star Wars: A New Hope']);

        $movie->addWatcher($user->id);
        $this->assertCount(1, $movie->watchers);

        $movie->removeWatcher($user->id);
        $this->assertCount(0, $movie->fresh()->watchers);
    }

    /** @test */
    public function a_watchable_can_be_toggled()
    {
        $user = User::first();
        $movie = Movie::create(['title' => 'Star Wars: A New Hope']);

        $this->assertCount(0, $movie->fresh()->watchers);

        $movie->toggleWatcher($user->id);
        $this->assertCount(1, $movie->watchers);

        $movie->toggleWatcher($user->id);
        $this->assertCount(0, $movie->fresh()->watchers);
    }

    /** @test */
    public function knows_when_a_user_is_not_a_watcher()
    {
        $user = User::first();
        $movie = Movie::create(['title' => 'Star Wars: A New Hope']);

        $this->assertFalse($movie->isWatchedBy($user->id));
    }

    /** @test */
    public function knows_when_a_user_is_a_watcher()
    {
        $user = User::first();
        $movie = Movie::create(['title' => 'Star Wars: A New Hope']);

        $movie->addWatcher($user->id);

        $this->assertTrue($movie->isWatchedBy($user->id));
    }

}