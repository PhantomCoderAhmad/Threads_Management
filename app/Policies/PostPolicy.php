<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use TeamTeaTime\Forum\Models\Post;

class PostPolicy
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
    public function edit($user, Post $post): bool
    {
        if($user->role_id == (\App\Models\User::admin || \App\Models\User::moderator) || $user->getKey() === $post->author_id){
            return true;
        }
        else{
            return false;
        }
    }

    public function delete($user, Post $post): bool
    {
        return $user->getKey() === $post->author_id;
    }

    public function restore($user, Post $post): bool
    {
        return $user->getKey() === $post->author_id;
    }
}
