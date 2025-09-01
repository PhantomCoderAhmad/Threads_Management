<style>
    .breadcrumb-item{
        display: none;
    }
</style>
@extends ('forum::master', ['breadcrumbs_append' => [trans('forum::general.new_reply')]])

@section ('content')
    <div id="create-post">
    <div class="container-fluid" style="padding: 0px; background-image: linear-gradient(to right, #005BC4,#6C16A2); border-radius:4px;">
        <h2 id="quick_r_head">{{ trans('forum::general.new_reply') }}</h2>
         <p id="new_reply_desc"> {{ $thread->title }}</p>
    </div>   
    

        @if (!$post === null && !$post->trashed())
            <p>{{ trans('forum::general.replying_to', ['item' => $post->authorName]) }}:</p>

            @include ('forum::post.partials.quote')
        @endif

        <form method="POST" action="{{ Forum::route('post.store', $thread) }}">
            {!! csrf_field() !!}
            @if ($post !== null)
                <input type="hidden" name="post" value="{{ $post->id }}">
            @endif

            <div class="mb-3">
                <textarea name="content" placeholder="Place your reply..." class="form-control" style="padding: 24px; height:150px;">{{ old('content') }}</textarea>
            </div>

            <div class="text-end">
                <a href="{{ URL::previous() }}"  class="btn btn-link" id="inner_btns">{{ trans('forum::general.cancel') }}</a>
                <button type="submit" class=" reply_btn px-3" style="padding: 4px; box-shadow: 3px 8px 26px #888888;">{{ trans('forum::general.reply') }}</button>
            </div>
        </form>
    </div>
@stop
