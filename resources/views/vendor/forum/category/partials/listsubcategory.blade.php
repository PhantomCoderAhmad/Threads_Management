<style>
.list-group-item {
    border: none;
}

</style>
<link  rel="stylesheet"  href="{{ asset( '/css/style.css') }}?v={{time()}}" rel="stylesheet ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="category list-group">

@if ($category->is_private == 0)
    <div class="list-group-item ">
                
        <div class="row align-items-center text-center">
            <div class="col-sm col-md-5 text-md-start">
                
                <h5 class="card-title">
                    <a href="{{ Forum::route('category.show', $category) }}" style="color: {{ $category->color }};">{{ $category->title }}</a>
                </h5>
                <p class="card-text text-muted">{{ $category->description }}</p>
            </div>
            <div class="col-md-2" style="text-align: center; padding-left: 0px;" >
                
                  
            </div>
            <div class="col-sm-2 col-md-2 " id="text-align-left">
                @if ($category->accepts_threads)
                <span class="badge rounded-pill " style="color: {{ $category->color }};">
                        <p style="color:#979eb5;">{{ trans_choice('forum::posts.post', 2) }}</p> {{ $category->post_count }}
                </span>    
                <span class="badge rounded-pill " style="color: {{ $category->color }};">
                        <p style="color:#979eb5;">{{ trans_choice('forum::threads.thread', 2) }}</p> {{ $category->thread_count }}
                </span>
                    
                    
                @endif
            </div>
            <div class="col-sm col-md-3  text-muted" id="text-align-left">
                @if ($category->accepts_threads)
                @if ($category->latestActiveThread && $category->latestActiveThread->post_count > 1)
                        <div>
                            <a id="by_re" href="{{ Forum::route('thread.show', $category->latestActiveThread->lastPost) }}">Re: {{ $category->latestActiveThread->title }}</a>
                            <!-- <p>@include ('forum::partials.timestamp', ['carbon' => $category->latestActiveThread->lastPost->created_at])</p> -->
                        </div>
                    @endif

                    @if ($category->newestThread)
                        <div>
                            <a id="by_re" href="{{ Forum::route('thread.show', $category->newestThread) }}">By: {{ $category->newestThread->title }}</a>
                            <p>@include ('forum::partials.timestamp', ['carbon' => $category->newestThread->created_at])</p>
                        </div>
                    @endif
                    
                @endif
            </div>
        </div>
        <hr>
    </div>
    @endif


    

    @if ($category->children->count() > 0 && $category->is_private == 0)
        <div class="subcategories">
            @foreach ($category->children as $subcategory)
                <div class="list-group-item">
                    <div class="row align-items-center text-center">
                        <div class="col-sm col-md-5 text-md-start" id="subcat_text">
                            <a href="{{ Forum::route('category.show', $subcategory) }}" style="color: {{ $subcategory->color }};">{{ $subcategory->title }}</a>
                            <div class="text-muted">{{ $subcategory->description }}</div>
                        </div>
                        <div class="col-md-2" style="text-align: center; padding-left: 0px;" >
                        
                        </div>
                        <div class="col-sm-2 col-md-2 " id="text-align-left">

                            <span class="badge rounded-pill " style="color: {{ $subcategory->color }};">
                            <p style="color:#979eb5;">{{ trans_choice('forum::posts.post', 2) }}</p> {{ $subcategory->post_count }}
                            </span>
                            <span class="badge rounded-pill " style="color: {{ $subcategory->color }};">
                                <p style="color:#979eb5;">{{ trans_choice('forum::threads.thread', 2) }}</p> {{ $subcategory->thread_count }}
                            </span>
                            
                            
                        </div>
                        <div class="col-sm col-md-3  text-muted" id="text-align-left">
                            
                            @if ($subcategory->latestActiveThread && $subcategory->latestActiveThread->post_count > 1)
                                <div>
                                    <a id="by_re" href="{{ Forum::route('thread.show', $subcategory->latestActiveThread->lastPost) }}">Re: {{ $subcategory->latestActiveThread->title }}</a>
                                    <!-- <p>@include ('forum::partials.timestamp', ['carbon' => $subcategory->latestActiveThread->lastPost->created_at])</p> -->
                                </div>
                            @endif
                            @if ($subcategory->newestThread)
                                <div>
                                    <a id="by_re" href="{{ Forum::route('thread.show', $subcategory->newestThread) }}">By: {{ $subcategory->newestThread->title }}</a>
                                    <p>@include ('forum::partials.timestamp', ['carbon' => $subcategory->newestThread->created_at])</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                </div>
            @endforeach
        </div>
    @endif

</div>