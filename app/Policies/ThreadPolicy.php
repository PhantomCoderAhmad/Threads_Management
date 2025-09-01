<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use TeamTeaTime\Forum\Models\Thread;
class ThreadPolicy
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

    public function view($user, Thread $thread): bool
    {
        return true;
    }

    public function deletePosts($user, Thread $thread): bool
    {
        return true;
    }

    public function restorePosts($user, Thread $thread): bool
    {
        return true;
    }

    public function rename($user, Thread $thread): bool
    {
        if($user->role_id == (\App\Models\User::admin || \App\Models\User::moderator) || $user->getKey() === $thread->author_id){
            return true;
        }
        else{
            return false;
        }
    }

    public function reply($user, Thread $thread): bool
    {
        return ! $thread->locked;
    }

    public function delete($user, Thread $thread): bool
    {
        if($user->role_id == (\App\Models\User::admin || \App\Models\User::moderator) || $user->getKey() === $thread->author_id){
            return true;
        }
        else{
            return false;
        }
    }

    public function restore($user, Thread $thread): bool
    {
        if($user->role_id == (\App\Models\User::admin || \App\Models\User::moderator)){
            return true;
        }
        else{
            return false;
        }
    }
}
