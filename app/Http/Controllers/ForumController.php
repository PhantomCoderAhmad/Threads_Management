<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\CategoryPrivacy;
use TeamTeaTime\Forum\Models\Thread;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\View\View;
use TeamTeaTime\Forum\Events\UserViewingCategory;
use App\Http\Requests\CreateCategory;
use TeamTeaTime\Forum\Events\UserViewingIndex;
use Illuminate\Http\RedirectResponse;
use App\Support\Web\Forum;
use App\Http\Requests\UpdateCategory;
use App\Models\Category;

class ForumController extends Controller
{
    //
    public function forumIndex(Request $request){ 
        $threads = Thread::orderBy('created_at', 'desc')->take(5)->get();
        $search = $request['search'] ?? "";
        if($search != ""){
            $categories = CategoryPrivacy::getFilteredTreeFor($request->user());
            $categories = $categories->filter(function($item) use ($search) {
                $categories = stripos($item['title'],$search) !== false;
                return $categories;
            });

            if ($request->user() !== null) {
                UserViewingIndex::dispatch($request->user());
            }
        }
        else{
            $categories = CategoryPrivacy::getFilteredTreeFor($request->user())->sortByDesc('updated_at')->sortByDesc('pinned');
        
            if ($request->user() !== null) {
                UserViewingIndex::dispatch($request->user());
            }
        }

        

        return ViewFactory::make('forum::category.index', compact(['categories','threads','search']));
    }

    public function store(CreateCategory $request): RedirectResponse
    {
        $category = $request->fulfill();

        Forum::alert('success', 'categories.created');

        return new RedirectResponse(Forum::route('category.show', $category));
    }

    public function update(UpdateCategory $request): RedirectResponse
    {
        $category_id = $request->category;
        $category = $request->fulfill($category_id);

        if ($category === null) {
            return $this->invalidSelectionResponse();
        }

        Forum::alert('success', 'categories.updated', 1);

        return new RedirectResponse(Forum::route('category.show', $category));
    }
}
