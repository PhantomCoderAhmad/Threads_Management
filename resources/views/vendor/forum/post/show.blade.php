<style>
    .breadcrumb-item{
        display: none;
    }
</style>
@extends ('forum::master', ['breadcrumbs_append' => [trans('forum::posts.view')]])

@section ('content')
    <div id="post">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="flex-grow-1 col-md-8"> {{ $thread->title }}</h2>
                </div>
                <div class="col-md-4" style="text-align: end;">
                    <a href="{{ Forum::route('thread.show', $thread) }}" class="btn-secondary reply_btn">{{ trans('forum::threads.view') }}</a>
                </div>
            </div>
            
           


        @include ('forum::post.partials.list', ['post' => $post, 'single' => true])
    </div>
@stop
