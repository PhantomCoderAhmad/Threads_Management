<style>
    .breadcrumb-item{
        display: none;
    }
</style>
@extends ('forum::master', ['breadcrumbs_append' => [trans('forum::threads.new_thread')]])

@section ('content')
    <div id="create-thread">
        <h2 class="top_row1" id="heading_cat_title_thread" >{{ $category->title }}</h2>

        <form method="POST" action="{{ Forum::route('thread.store', $category) }}">
            @csrf

            <div class="mb-3">
                <label for="title">{{ trans('forum::general.title') }}</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control">
            </div>

            <div class="mb-3">
            <label for="title">Description</label>
                <textarea name="content" style="height: 150px;" class="form-control">{{ old('content') }}</textarea>
            </div>
            <div class="text-end">
                <a href="{{ URL::previous() }}" class="btn btn-link" id="inner_btns">{{ trans('forum::general.cancel') }}</a>
                <button type="submit" class="reply_btn btn-primary px-3 py-1">{{ trans('forum::general.create') }}</button>
            </div>
        </form>
    </div>
@stop
