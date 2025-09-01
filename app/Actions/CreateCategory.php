<?php

namespace App\Actions;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CreateCategory extends BaseAction
{
    private string $title;
    private string $description;
    private string $color;
    private bool $acceptsThreads;
    private bool $isPrivate;
    private string $parentId;
    private bool $pinned;
    
    

    public function __construct(string $title, string $description, string $color, bool $acceptsThreads = true, bool $isPrivate = false, string $parentId = '', bool $pinned,)
    {
        
        $this->title = $title;
        $this->description = $description;
        $this->color = $color;
        $this->acceptsThreads = $acceptsThreads;
        $this->isPrivate = $isPrivate;
        $this->parentId = $parentId;
        $this->pinned = $pinned;
    }

    protected function transact()
    {
        
        return Category::create([
            'title' => $this->title,
            'description' => $this->description,
            'color' => $this->color,
            'accepts_threads' => $this->acceptsThreads,
            'is_private' => $this->isPrivate,
            'parent_id' => $this->parentId,
            'pinned' => $this->pinned,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
        ]);
    }
}
