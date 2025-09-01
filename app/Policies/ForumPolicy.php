<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
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
    public function createCategories($user): bool
    {
        if($user->role_id == \App\Models\User::admin){
            return true;
        }
        else{
            return false;
        }
    }

    public function manageCategories($user): bool
    {
        return $this->moveCategories($user) ||
               $this->renameCategories($user);
    }
    

    public function moveCategories($user): bool
    {
        return true;
    }
    public function editcategories($user): bool
    {
        if($user->role_id == \App\Models\User::admin){
            return true;
        }
        else{
            return false;
        }
    }

    public function renameCategories($user): bool
    {
        return true;
    }

    public function markThreadsAsRead($user): bool
    {
        return true;
    }

    public function viewTrashedThreads($user): bool
    {
        return true;
    }

    public function viewTrashedPosts($user): bool
    {
        return true;
    }
}
