<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Topic;
class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     * CREATE: php artisan make:policy TopicPolicy
     * @return void
     */
    public function update(User $user, Topic $topic)
    {
       return $user->ownsTopic($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->ownsTopic($topic);
    }

}
