<?php

namespace App\Actions;
use App\Models\Category;


class UpdateCategory extends BaseAction
{
    private Category $category;
    private ?string $title;
    private ?string $description;
    private ?string $color;
    private ?bool $acceptsThreads;
    private ?bool $isPrivate;
    private ?bool $pinned;

    public function __construct(Category $category, ?string $title, ?string $description, ?string $color, ?bool $acceptsThreads, ?bool $isPrivate, ?bool $pinned, ?string $parentId)
    {
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->color = $color;
        $this->acceptsThreads = $acceptsThreads;
        $this->isPrivate = $isPrivate;
        $this->pinned = $pinned;
        $this->parentId = $parentId;
        // dd($this->pinned);
    }

    protected function transact()
    {
        $attributes = [];

        if ($this->title !== null) {
            $attributes['title'] = $this->title;
        }
        if ($this->description !== null) {
            $attributes['description'] = $this->description;
        }
        if ($this->color !== null) {
            $attributes['color'] = $this->color;
        }
        if ($this->acceptsThreads !== null) {
            $attributes['accepts_threads'] = $this->acceptsThreads;
        }
        if ($this->isPrivate !== null) {
            $attributes['is_private'] = $this->isPrivate;
        }
        if ($this->pinned !== null) {
            $attributes['pinned'] = $this->pinned;
        }
        if ($this->parentId !== null) {
            // dd("hello",$this->parentId);
            $attributes['parent_id'] = $this->parentId;
        }
        // if ($this->parentId == null) {
        //     $attributes['parent_id'] = $this->parentId;
        // }
        

        $this->category->update($attributes);

        return $this->category;
    }
}
