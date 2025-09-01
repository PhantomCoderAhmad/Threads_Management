<?php

namespace App\Http\Requests;

use App\Actions\UpdateCategory as Action;
use App\Events\UserUpdatedCategory;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

class UpdateCategory extends CreateCategory
{
    public function fulfill($category_id = null)
    {
        // dd(Route::current('category'));
        // dd($category_id);
        $category = $category_id ? Category::find($category_id) : $this->route('category');
        // dd($category);
        $input = $this->validated();
        
        $action = new Action(
            $category,
            $input['title'] ?? null,
            $input['description'] ?? null,
            $input['color'] ?? null,
            $input['accepts_threads'] ?? null,
            $input['is_private'] ?? null,
            $input['pinned'] ?? null,
            $input['parent_id'] ?? null,
            

        );
        $category = $action->execute();

        if (! $category === null) {
            UserUpdatedCategory::dispatch($this->user(), $category);
        }

        return $category;
    }
}
