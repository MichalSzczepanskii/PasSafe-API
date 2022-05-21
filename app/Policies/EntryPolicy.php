<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Entry $entry) {
        return $user->id === $entry->user_id
            ? Response::allow()
            : Response::deny('You do not own this entry');
    }

    public function edit(User $user, Entry $entry) {
        return $user->id === $entry->user_id;
    }


}
