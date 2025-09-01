<div @if (! $post->trashed())id="post-{{ $post->sequence }}"@endif
    class="post card mb-2 {{ $post->trashed() || $thread->trashed() ? 'deleted' : '' }}"
    :class="{ 'border-primary': selectedPosts.includes({{ $post->id }}) }">
    <div class="card-header " id="thread_header" >
        @if (! isset($single) || ! $single)
            <span >
                <a id="post_seq" href="{{ Forum::route('thread.show', $post) }}">#{{ $post->sequence }}</a>
                @if ($post->sequence != 1)
                    @can ('deletePosts', $post->thread)
                        @can ('delete', $post)
                        <span class="checkbox_post" style="color: white;">Select this post</span>
                            <input type="checkbox" class="checkbox_post" name="posts[]" :value="{{ $post->id }}" v-model="selectedPosts">
                            
                        @endcan
                    @endcan
                @endif
            </span>
        @endif

        <span style="color: white;" id="thread_author_name"> {{ $post->authorName }}</span>

        <span class="text-muted rounded-pill" id="time_stamp_Thred_author">
            @include ('forum::partials.timestamp', ['carbon' => $post->created_at])
            @if ($post->hasBeenUpdated())
                ({{ trans('forum::general.last_updated') }} @include ('forum::partials.timestamp', ['carbon' => $post->updated_at]))
            @endif
        </span>
    </div>
    <div class="card-body">
        @if ($post->parent !== null)
            @include ('forum::post.partials.quote', ['post' => $post->parent])
        @endif

        @if ($post->trashed())
            @can ('viewTrashedPosts')
                {!! Forum::render($post->content) !!}
                <br>
            @endcan
            <span class="badge rounded-pill bg-danger">{{ trans('forum::general.deleted') }}</span>
        @else
            {!! Forum::render($post->content) !!}
        @endif

        @if (! isset($single) || ! $single)
            <div class="text-end">
                @if (! $post->trashed())
                    <a href="{{ Forum::route('post.show', $post) }}" class="card-link text-muted btn btn-light" id="inner_btns">{{ trans('forum::general.permalink') }}</a>
                    
                    @can ('edit', $post)
                        <a href="{{ Forum::route('post.edit', $post) }}" class="card-link btn btn-light" id="inner_btns">{{ trans('forum::general.edit') }}</a>
                    @endcan
                    @can ('reply', $post->thread)
                        <a href="{{ Forum::route('post.create', $post) }}" class="card-link btn btn-light" id="inner_btns">{{ trans('forum::general.reply') }}</a>
                    @endcan
                    @if ($post->sequence != 1)
                        @can ('deletePosts', $post->thread)
                            @can ('delete', $post)
                                <a href="{{ Forum::route('post.confirm-delete', $post) }}" class="card-link btn btn-light" id="inner_btns_delete" >{{ trans('forum::general.delete') }}</a>
                            @endcan
                        @endcan
                    @endif
                @else
                    @can ('restorePosts', $post->thread)
                        @can ('restore', $post)
                            <a href="{{ Forum::route('post.confirm-restore', $post) }}" class="card-link btn btn-light" id="inner_btns">{{ trans('forum::general.restore') }}</a>
                        @endcan
                    @endcan
                @endif
            </div>
        @endif
    </div>
</div>
