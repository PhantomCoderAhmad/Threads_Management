<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Category;
class CategoryPolicy
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
    public function createThreads($user): bool
    {
        return true;
    }

    public function manageThreads($user): bool
    {
        return $this->deleteThreads($user) ||
               $this->restoreThreads($user) ||
               $this->moveThreadsFrom($user) ||
               $this->lockThreads($user) ||
               $this->pinThreads($user);
    }

    public function deleteThreads($user): bool
    {
        return true;
    }

    public function restoreThreads($user): bool
    {
        return true;
    }

    public function enableThreads($user): bool
    {
        return false;
    }

    public function moveThreadsFrom($user): bool
    {
        if($user->role_id == \App\Models\User::admin || $user->role_id == \App\Models\User::moderator){
                return true;
            }
            else{
                return false;
            }
    }

    public function moveThreadsTo($user): bool
    {
        if($user->role_id == \App\Models\User::admin || $user->role_id == \App\Models\User::moderator){
            return true;
        }
        else{
           return false;
        }
    }

    public function lockThreads($user): bool
    {
        if($user->role_id == \App\Models\User::admin || $user->role_id == \App\Models\User::moderator){
            return true;
        }
        else{
            return false;
        }
    }

    public function pinThreads($user): bool
    {
        if($user->role_id == \App\Models\User::admin || $user->role_id == \App\Models\User::moderator){
            return true;
        }
        else{
           return false;
        }
    }

    public function markThreadsAsRead($user): bool
    {
        return true;
    }

    public function view($user): bool
    {
        return true;
    }

    public function delete($user): bool
    {
        return false;
    }
    
}
