<div class="list-group-item {{ $thread->pinned ? 'pinned' : '' }} {{ $thread->locked ? 'locked' : '' }} {{ $thread->trashed() ? 'deleted' : '' }}" :class="{ 'border-primary': selectedThreads.includes({{ $thread->id }}) }">
    <div class="row align-items-center text-center">
        <div class="col-sm text-md-start">
            <span class="lead">
                <a  id="thread_id" href="{{ Forum::route('thread.show', $thread) }}" @if (isset($category))style="color: {{ $category->color }};"@endif>{{ $thread->title }}</a>
            </span>
            <br>
            <span id="author_by" > by </span> <span id="author_name"> {{ $thread->authorName }}</span> <span class="text-muted author_post_date">@include ('forum::partials.timestamp', ['carbon' => $thread->created_at])</span>

            
        </div>
        

        

        
    </div>
</div>