<?php

namespace Telkins\Watchable;

trait Watchable
{
    /**
     * Get a collection of watchers.
     *
     * @return mixed
     */
    public function watchers()
    {
        $userClass = config('auth.providers.users.model');

        return $this->morphToMany($userClass, 'watchable');
    }

    /**
     * Set the given user as a watcher.
     *
     * @param null|int $userId
     */
    public function addWatcher(?int $userId = null)
    {
        $this->watchers()->sync($userId ?? auth()->id());
    }

    /**
     * Unset the given user as a watcher.
     *
     * @param null|int $userId
     */
    public function removeWatcher(?int $userId = null)
    {
        $this->watchers()->detach($userId ?? auth()->id());
    }

    /**
     * Toggle the given user as a watcher.
     *
     * @param null|int $userId
     */
    public function toggleWatcher(?int $userId = null)
    {
        $this->watchers()->toggle($userId ?? auth()->id());
    }

    /**
     * Check if the given user is a watcher.
     *
     * @param null|int $userId
     * @return bool
     */
    public function isWatchedBy(?int $userId = null)
    {
        return (bool) $this->watchers()
            ->where('user_id', $userId ?? auth()->id())
            ->count();
    }
}