<div class="mb-3">
        <label for="color">{{ trans('forum::general.color') }}</label></br>
        <input type="color" value="{{ isset($category->color) ? $category->color : (old('color') ?? config('forum.web.default_category_color')) }}" name="color">
    </div>