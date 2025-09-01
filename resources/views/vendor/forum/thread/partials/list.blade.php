<style>
.list-group-item {
    border: none;
}
#main
    {
        padding: 1em;
    }
</style>
<div class="list-group-item {{ $thread->pinned ? 'pinned' : '' }} {{ $thread->locked ? 'locked' : '' }} {{ $thread->trashed() ? 'deleted' : '' }}" :class="{ 'border-primary': selectedThreads.includes({{ $thread->id }}) }">
    <div class="row align-items-center text-center">
        <div class="col-sm col-md-4 text-md-start">
            <span class="lead">
                <a  id="thread_id" href="{{ Forum::route('thread.show', $thread) }}" @if (isset($category))style="color: {{ $category->color }};"@endif>{{ $thread->title }}</a>
            </span>
            <br>
            <span id="by_re">By: {{ $thread->authorName}}  </span> <span class="text-muted">@include ('forum::partials.timestamp', ['carbon' => $thread->created_at])</span>

            @if (! isset($category))
                <br>
                <a href="{{ Forum::route('category.show', $thread->category) }}" style="color: {{ $thread->category->color }};">{{ $thread->category->title }}</a>
            @endif
        </div>
        <div class="col-sm  col-md-2" style="padding-left: 0px;">
            @if ($thread->pinned)
                <i class="fa fa-thumb-tack " style="-ms-transform: rotate(20deg);transform: rotate(30deg); color: #4dc12f;" aria-hidden="true"></i>
            @endif
            @if(!$thread->pinned)
                <i class="fa fa-thumb-tack " style="-ms-transform: rotate(20deg);transform: rotate(30deg); color: grey;" aria-hidden="true"></i>
            @endif
            @if ($thread->locked)
                <span class="badge " id="top_btn">{{ trans('forum::threads.locked') }}</span>
            @endif
            @if ($thread->userReadStatus !== null && ! $thread->trashed())
                <span class="badge" id="top_btn">{{ trans($thread->userReadStatus) }}</span>
            @endif
            @if ($thread->trashed())
                <span class="badge " id="top_btn">{{ trans('forum::general.deleted') }}</span>
            @endif
            
        </div>
        <div class="col-md-2" style="text-align: left; padding-left:0px;">
            <span class="" @if (isset($category))style="background: {{ $category->color }};"@endif>
                    <p style="color:#979eb5; margin: auto;">{{ trans('forum::general.replies') }}:</p> 
                    <p style="color: #007BFF; margin: auto; font-size: 14px; font-weight: 700;">{{ $thread->reply_count }}</p>
            </span>
        </div>

        @if ($thread->lastPost)
            <div class="col-sm col-md-3 text-muted" style="text-align: left; padding-left:0px;">
                <a href="{{ Forum::route('thread.show', $thread->lastPost) }}">{{ trans('forum::posts.view') }} &raquo;</a>
                <br>
                <span id="by_re">By: {{ $thread->authorName}} </span>
                <span class="text-muted">@include ('forum::partials.timestamp', ['carbon' => $thread->lastPost->created_at])</span>
            </div>
        @endif

        @if (isset($category) && isset($selectableThreadIds) && in_array($thread->id, $selectableThreadIds))
            <div class="col-sm col-md-1">
                <input type="checkbox" name="threads[]" :value="{{ $thread->id }}" v-model="selectedThreads">
            </div>
        @endif
    </div>
    <hr>
</div>