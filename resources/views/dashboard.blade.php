

    

@extends('layouts.app')


@section('css_section')
<style>
    
    .accordion-button::after {
        display: none;
    }
    .timestamp{
        float: right;
    }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
            <div class="col-md-8">
                <!-- accordion strat -->

                <div class="container mb-3" style="padding:0em;">
                    <div class="accordion" id="myAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <div  class="accordion-button collapsed top_p" id="first_child"  data-bs-target="#collapseOne"  >
                                            
                                    <div class="row" style="width: 100%;">
                                            <div class="col-md-5 col-small" style="color: white;">
                                                Latest News

                                            </div>
                                            
                                            
                                        </div>

                                    </div>
                                <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                                <div class="card-body">

                                @if (! $blog->isEmpty())
                                <div class="threads list-group shadow-sm" id="background_divs" id="background_divs">
                                    @foreach ($blog as $post)
                                    
                                        <div class="row" id="post_row">
                                            <div class="col-md-4">
                                                <img id="blog_images" src="{{asset('../images/'.$post->image)}}" alt="image" class="img-fluid"/>
                                            </div>
                                            <div class="col-md-8">
                                                
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <a href="{{url('/blog/detail',$post->slug)}}" style="text-decoration: none;"><p id="blog_title">{{$post->title}}</p></a>
                                                        

                                                    </div>
                                                    <div class="col-md-5">
                                                        <time class="timestamp" id="blog_date" datetime="{{ $post->created_at }}" title="{{ $post->created_at->toDayDateTimeString() }}">{{ $post->created_at->toDayDateTimeString() }}</time>
                                                    </div>
                                                </div>

                                                <p id="blog_desc">{{$post->description}}</p>
                                                <div >
                                                    <span style="display:inline; float:left;">
                                                        <a id="read_more" href="{{url('/blog/detail',$post->slug)}}">Read more of this article <i class="fas fa-angle-double-right"></i></a>
                                                    </span>
                                                    @if($post->allow_comment == 1)
                                                    <span style="display:inline; float:right; font-size: 12px; color: #979eb5;">Comments are off for this article <i class="fas fa-comments"></i></span>
                                                    @endif
                                                </div>
                                                
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                                @else
                                    <div class="card my-3">
                                        <div class="card-body text-center text-muted">
                                            No post's found!
                                        </div>
                                    </div>
                                @endif
                                    
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- accordion end -->
                <div class="container">
                    <span>
                        {{$blog->links('pagination::bootstrap-5')}}
                    </span>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="container-fluid mb-3" id="search_container" >
                    <form  method="GET" action="{{ route('search') }}">
                        <div class="row ">
                            <div class="col-md-9 mt-2 mb-2 px-0" >
                                <input type="text" name="search"  placeholder="Search here..." class="form-control" id="search_field" value="{{$search}}" >
                            </div>
                            <div class="col-md-3 mt-2 mb-2" style="padding-left: 0px; ">
                                <button type="submit" class="btn btn-primary" id="search_btn"> Search </button>
                            </div>
                        </div>
                        
                    </form>
                
                </div>

                <div class="container-fluid mb-3" style="padding:0px;">
                    
                    <div class="card">
                        <div class="card-header top_p">
                        <p id="r_t_p">Categories</p>
                        </div>
                        <div class="card-body">
                        @if (! $blog->isEmpty())
                                <div class="threads list-group shadow-sm" id="background_divs">
                                    @foreach ($blog_category as $blog_cat)
                                    <form method="GET" action="{{ route('blog_category') }}">
                                        <input type="text" value="{{$blog_cat->category}}" name="category" hidden/>
                                       <button style="border: none; background-color: white;" type="submit" name="" id="recent_links">{{$blog_cat->category}}</button>
                                    </form>
                                    @endforeach
                                </div>
                            @else
                                <div class="card my-3">
                                    <div class="card-body text-center text-muted">
                                        No post's found!
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>

                <div class="container-fluid" style="padding:0px;">
                    
                    <div class="card">
                        <div class="card-header top_p">
                        <p id="r_t_p">Latest Post's</p>
                        </div>
                        <div class="card-body">
                            @if (! $recent_posts->isEmpty())
                                <div class="threads list-group shadow-sm" id="background_divs">
                                    @foreach ($recent_posts as $recent_post)
                                    
                                        <a href="{{url('/blog/detail',$recent_post->slug)}}" id="recent_posts">{{$recent_post->title}}</a>
                                        
                                        <span id="recent_posts_cat">Category:&nbsp{{$recent_post->category}} <time class="timestamp" datetime="{{ $recent_post->created_at }}" title="{{ $recent_post->created_at->toDayDateTimeString() }}">{{ $recent_post->created_at->toDayDateTimeString() }}</time></span>

                                    @endforeach
                                </div>
                            @else
                                <div class="card my-3">
                                    <div class="card-body text-center text-muted">
                                        No post's found!
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>
@endsection

@section('js_section')
<script>
    $( document ).ready(function() {
        $(".edit_btn").hide();
        $(".pst_btn").show();
    });
</script>

@endsection