<link  rel="stylesheet"  href="{{ asset( '/css/style.css') }}?v={{time()}}" rel="stylesheet ">
<div class="category list-group">
@if ($category->is_private == 1)
    <div class="list-group-item ">
                
        <div class="row align-items-center text-center">
            <div class="col-sm col-md-10 text-md-start">
                
                <h5 class="card-title">
                    <a href="{{ Forum::route('category.show', $category) }}" style="color: {{ $category->color }};">{{ $category->title }}</a>
                </h5>
                <p class="card-text text-muted">{{ $category->description }}</p>
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
            
        </div>
        <hr>
    </div>
    @endif


    

    @if ($category->children->count() > 0 && $category->is_private == 1)
        <div class="subcategories">
            @foreach ($category->children as $subcategory)
                <div class="list-group-item">
                    <div class="row align-items-center text-center">
                        <div class="col-sm col-md-10 text-md-start" id="subcat_text">
                            <a href="{{ Forum::route('category.show', $subcategory) }}" style="color: {{ $subcategory->color }};">{{ $subcategory->title }}</a>
                            <div class="text-muted">{{ $subcategory->description }}</div>
                        </div>
                        
                        <div class="col-sm-2 col-md-2 " id="text-align-left">

                            <span class="badge rounded-pill " style="color: {{ $subcategory->color }};">
                            <p style="color:#979eb5;">{{ trans_choice('forum::posts.post', 2) }}</p> {{ $subcategory->post_count }}
                            </span>
                            <span class="badge rounded-pill " style="color: {{ $subcategory->color }};">
                                <p style="color:#979eb5;">{{ trans_choice('forum::threads.thread', 2) }}</p> {{ $subcategory->thread_count }}
                            </span>
                            
                            
                        </div>
                        
                    </div>
                    <hr>
                </div>
            @endforeach
        </div>
    @endif


    
</div>