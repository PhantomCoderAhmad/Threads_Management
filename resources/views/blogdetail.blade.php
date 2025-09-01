@extends('layouts.app')


@section('css_section')
<style>

    
    .accordion-button::after {
        display: none;
    }
    .timestamp{
        float: right;
    }
    
    
    .error {
      color: #d32e2e;
	  text-align: left;
	  font-size: 12px;
	  
   }
   
    </style>
@endsection
   
@section('content')
<input type="text" value="{{$blog->id}}" name="id" id="blog_id" hidden/>

@include('updateblog')


<div class="container">
    <div class="row">
            <div class="col-md-8">
                <!-- accordion strat -->

                <div class="container" style="padding:0em;">
                    <div class="accordion" id="myAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <div  class="accordion-button collapsed top_p" id="first_child" data-bs-target="#collapseOne"  >
                                            
                                    <div class="row" style="width: 100%;">
                                            <div class="col-md-12 col-small" style="color: white;">
                                            
                                                <div>
                                                    <span style="display:inline; float:left;">
                                                        {{$blog->title}}
                                                    </span>
                                                    <span style="display:inline; float:right; font-size: 12px; color: #979eb5;">
                                                        <time  id="blog_date_detail" datetime="{{ $blog->created_at }}" title="{{ $blog->created_at->toDayDateTimeString() }}">{{ $blog->created_at->toDayDateTimeString() }}</time>
                                                    </span>
                                                </div>

                                            </div>
                                            
                                            
                                        </div>

                                    </div>
                                <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                                <div class="card-body">

                                
                                <div class="threads list-group shadow-sm" id="background_divs" id="background_divs">
                                    
                                    
                                        <div class="row" id="post_row">
                                            <div class="col-md-12">
                                                <img id="blog_images_detail" src="{{asset('../images/'.$blog->image)}}" alt="image" class="img-fluid"/>
                                            </div>
                                           
                                        </div>
                                        <div class="row" id="post_row">
                                            <div class="col-md-12">
                                               <p id="detail_desc"> 
                                                   {{$blog->description}}
                                               </p>
                                            </div>
                                           
                                        </div>

                                </div>
                                
                                    
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- accordion end -->



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
                        @if (! $blog_category->isEmpty())
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
@if($blog->comments)
    <div class="container  mt-3 mb-3" id="posted_comments">
        @foreach($blog->comments as $comment)
            <div class="container-fluid" id="quick_r_head">
            #{{$loop->index +1}} | {{$comment->username}}
                <span class="rounded-pill" id="blog_time">
                <time  id="blog_date_detail" datetime="{{ $comment->created_at }}" title="{{ $comment->created_at->toDayDateTimeString() }}">{{ $comment->created_at->toDayDateTimeString() }}</time>
                </span>
            </div>
            <div class="container-fluid mb-3" id="commented_space">
                <p id="comment_title">{{$comment->blog_comment}}</p>
                <!-- Replies Foreach -->
                @foreach($comment->replies as $reply)
                    @if($reply->comment_id == $comment->id )
                        <div class="container mt-2 mb-3" id="replies_container">
                            <!-- ROW     -->
                            <div class="row">

                                <div class="col-md-8">
                                    <p id="commented_reply">{{$reply->comment_reply}}</p>
                                    <span id="commented_detail" >By: {{$reply->reply_user}}</span>
                                    
                                    <span id="commented_detail" class="rounded-pill"><time  datetime="{{ $reply->created_at }}" title="{{ $reply->created_at->toDayDateTimeString() }}">{{ $reply->created_at->toDayDateTimeString() }}</time>
                                    </span>
                                </div>

                                <div class="col-md-4 text-end">
                                    <div class="row">
                                        <div class="col-md-8">
                                            @if($reply->user_id == Auth::id() && $blog->allow_comment == 0)
                                                <button data-id="{{$reply->id}}" class="btn btn-light edit_reply" id="inner_btns" data-bs-toggle="modal" data-bs-target="#editreply">
                                                Edit</button>
                                            @endif
                                        </div>
                                        <div class="col-md-4 delete_form">
                                            @if( Auth::check() && $blog->allow_comment == 0 && ($reply->user_id == Auth::id() || (Auth::user()->role_id == \App\Models\User::admin)) )

                                            <form method="post"  action="{{ route('reply.delete', $reply->id) }}">
                                                @csrf
                                                <a  id="inner_btns_delete" class="btn btn-danger reply_delete"> Delete</a>
                                            </form>  
                                            @endif                    
                                        </div>
                                    </div>    
                                    
                                </div>

                            </div>
                            <!-- ROW     -->
                            

                        </div>
                    @endif
                @endforeach
                <!-- Replies Foreach -->


                <div class="container-fluid" style="text-align: end;">

                            <span>
                                @if(Auth::check() && $blog->allow_comment == 0)
                                    <button data-id="{{$comment->id}}" class="btn btn-light reply_comment" id="inner_btns"  data-bs-toggle="modal" data-bs-target="#Replymodal">Reply</button>
                                @endif
                            </span>

                            <span>
                                @if(Auth::check() && $comment->user_id == Auth::id() && $blog->allow_comment == 0)
                                    <button data-id="{{$comment->id}}" class="btn btn-light edit_comment" id="inner_btns" data-bs-toggle="modal" data-bs-target="#editcomment">Edit</button>

                                @endif
                            </span>


                            <span style="float:right">
                                @if(Auth::check() && $blog->allow_comment == 0 && ($comment->user_id == Auth::id() || ( Auth::user()->role_id == \App\Models\User::admin))  )
                                    <form method="post"  action="{{ route('comment.delete', $comment->id) }}">
                                        @csrf
                                        <a  id="inner_btns_delete" class="btn btn-danger comment_delete"> Delete</a>
                                    </form>  
                                    <!-- <a href="{{url('/delete/comment',$comment->id)}}"  class="btn btn-danger" id="inner_btns_delete" >Delete</a> -->
                                @endif
                            </span>

                    
                    
                </div>
            </div>
        @endforeach
    </div>

@endif
@if(Auth::check() && $blog->allow_comment == 0)
    <div class="container  mt-3 mb-3">
        
            <div class="container-fluid" id="quick_r_div">

                    <div class="container-fluid" id="quick_r_head">
                        Quick Comment
                    </div>
                    <div class="comntainer-fluid">
                        <div class="container-fluid">
                                <div id="quick-reply">
                                    <form  id="post_comment_form">

                                        <div style="margin: 12px;">
                                            <textarea required placeholder="Place your comments here..." id="post_comment"  style="height: 150px; padding: 14px;" name="comment" class="form-control">{{ old('comment') }}</textarea>
                                        </div>
                                        <input type="text" value="{{$blog->id}}" name="blog_id" id="blog_id" hidden/>

                                        <div class="text-end mb-3">
                                            <button type="submit" id="submit_reply_btn" class="btn btn-light px-5">Add Comment</button>
                                        </div>
                                    </form>
                                </div>
                        </div>
                        
                    </div>
                    
               
            </div>
            
        
    </div>
    @elseif($blog->allow_comment == 1)
        <p style="text-align: center;" class="mt-5 mb-5">Comment's are turned off for this Post.</p>
    @else
    <p style="text-align: center;" class="mt-5 mb-5">Please Login to add Comment's / Replie's. <a href="{{url('/checkauth')}}"> Click here to Login </a> </p>
@endif
    
<div class="modal fade" id="editcomment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
     
        <form  method="post" action="{{ route('commentupdate') }}"  id="update_post">
                @csrf
                
                <input value="" name="id" id="up_id" hidden/>
            <textarea placeholder="Place your comments here..."  style="height: 150px; padding: 14px;" name="comment" id="up_comment" class="form-control"></textarea>
            <div class="container mt-3" style="text-align: end;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
      
    
  
    </div>
   
  </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="Replymodal" tabindex="-1" aria-labelledby="ReplymodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ReplymodalLabel">Add Reply</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          
        <form  method="post" action="{{ route('postreply') }}" id="reply_form">
                @csrf
                
                <input value="{{$blog->id}}" name="blog_id" id="blog_id" hidden />
                <input value="" name="comment_id" id="comment_id" hidden/>
                <textarea placeholder="Place your Reply here..."  style="height: 150px; padding: 14px;" name="comment_reply" id="comment_reply" class="form-control">{{ old('comment_reply') }}</textarea>
                <div class="container mt-3" style="text-align: end; padding:0em;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Reply</button>
                </div>
        </form>

      </div>
      
    </div>
  </div>
</div>
<!-- Reply Modal -->


<!--Edit Reply Modal -->
<div class="modal fade" id="editreply" tabindex="-1" aria-labelledby="ReplymodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ReplymodalLabel">Update Reply</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          
        <form  method="post" action="{{ route('replyupdate') }}" id="u_reply_form">
                @csrf
                
                <input value="" name="id" id="updating_id" hidden/>
                <textarea placeholder="Place your Reply here..."  style="height: 150px; padding: 14px;" name="comment_reply" id="updating_reply" class="form-control"></textarea>
                <div class="container mt-3" style="text-align: end; padding:0em;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Reply</button>
                </div>
        </form>

      </div>
      
    </div>
  </div>
</div>
<!--Edit Reply Modal -->
@endsection

@section('js_section')
<script>
    $( document ).ready(function() {
        $(".edit_btn").show();
        $(".pst_btn").hide();
    });

    

    $(".edit_btn").click(function(){
        var id = $("#blog_id").val();
        $.ajax({ 
            
            url: "{{url('/edit/blog')}}",
            type:"GET",
            data:{
            id:id,
            },
        
            success: function()
            {
                console.log('hits');
            }
        });
    });

    $(".edit_comment").click(function(){
        var id = $(this).data('id');
        $.ajax({ 
            
            url: "{{url('/edit/comment')}}",
            type:"GET",
            data:{
            id:id,
            },
        
            success: function(res)
            {
                $("#up_id").val(res.updated_comment.id);
                $("#up_comment").html(res.updated_comment.blog_comment);
                console.log(res.updated_comment.username);
            }
        });
    });


    $(".edit_reply").click(function(){
        var id = $(this).data('id');
        $.ajax({ 
            
            url: "{{url('/edit/reply')}}",
            type:"GET",
            data:{
            id:id,
            },
        
            success: function(res)
            {
                $("#updating_id").val(res.updated_reply.id);
                $("#updating_reply").html(res.updated_reply.comment_reply);
                console.log(res.updated_reply.reply_user);
            }
        });
    })

    


    $("#update_post").validate({
	onkeyup: function(element) {
        var element_id = $(element).attr('id');
        if (this.settings.rules[element_id].onkeyup !== false) {
            $.validator.defaults.onkeyup.apply(this, arguments);
        }
    },
            rules: {
              title: {
            required: true,
            onkeyup: false
        },
        description: {
            required: true,
            onkeyup: false
        },
        category: {
            required: true,
            onkeyup: false
        },

            },
            messages: {
                title:  `<i class="fas fa-exclamation-triangle error_icon"  >  Title is required.</i> `,
                description: `<i class="fas fa-exclamation-triangle error_icon"  >  Description is required. </i> `,
                category: `<i class="fas fa-exclamation-triangle error_icon"  >  Category is required. </i> `,
                

            },
			

});

$(".reply_comment").click(function(){
        var comment_id = $(this).data('id');
        $("#comment_id").val(comment_id);
    });

    

$("#reply_form").validate({
	onkeyup: function(element) {
        var element_id = $(element).attr('id');
        if (this.settings.rules[element_id].onkeyup !== false) {
            $.validator.defaults.onkeyup.apply(this, arguments);
        }
    },
        rules: {
                comment_reply: {
                required: true,
                onkeyup: false
            },
        },
        messages: {
            comment_reply:  `<i class="fas fa-exclamation-triangle error_icon"  >  Reply is required.</i> `,
        },
});




$("#u_reply_form").validate({
	onkeyup: function(element) {
        var element_id = $(element).attr('id');
        if (this.settings.rules[element_id].onkeyup !== false) {
            $.validator.defaults.onkeyup.apply(this, arguments);
        }
    },
        rules: {
                comment_reply: {
                required: true,
                onkeyup: false
            },
        },
        messages: {
            comment_reply:  `<i class="fas fa-exclamation-triangle error_icon"  >  Reply is required.</i> `,
        },
});
$('.reply_delete').click(function(event) {
          var form =  $(this).closest("form");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this Reply?`,
              text: "This Reply Will Delete Permanently.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
      $('.comment_delete').click(function(event) {
          var form =  $(this).closest("form");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this comment?`,
              text: "All replies will also delete belong to this comment.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });

      $("#post_comment_form").validate({
            onkeyup: function(element) {
                var element_id = $(element).attr('id');
                if (this.settings.rules[element_id].onkeyup !== false) {
                    $.validator.defaults.onkeyup.apply(this, arguments);
                }
            },
            rules: {
              comment: {
            required: true,
            onkeyup: false
            },

            },
            messages: {
                comment: `<i class="fas fa-exclamation-triangle error_icon"  >  Comment is required. </i> `,
            },
		
            submitHandler: function (form) {
                let comment = $("#post_comment").val();
                let blog_id = $("#blog_id").val();
            $.ajax({
            url: "{{url('postcomment')}}",
            type:"POST",
            dataType: 'json',
            data:{
                _token: "{{ csrf_token() }}",
                comment: comment,
                blog_id: blog_id,
            },
            success:function(res){
                console.log(res.data);
                    $("#post_comment").val('');
                    $(".message").show();
                    $("#success_message").html(res.message);
                    
                    setTimeout(function() {
                        $('.message').fadeOut('fast');
                    }, 2000);
                    
                    $("#posted_comments").append(
                        `
                            <div class="container-fluid" id="quick_r_head">
                             `+res.user.username+`
                                <span class="rounded-pill" id="blog_time">
                                <time  id="blog_date_detail" datetime="${res.data.created_at}" title="${ res.data.created_at}->toDayDateTimeString()">${ res.data.created_at}->toDayDateTimeString() </time>
                                </span>
                            </div>
                            <div class="container-fluid mb-3" id="commented_space">
                                <p id="comment_title">`+res.user.blog_comment+`</p>
                                
                                    <div class="container-fluid" style="text-align: end;">

                                                <span>
                                                    if(<?php Auth::check() ?> && $blog->allow_comment == 0){
                                                        <button data-id="${res.data.id}" class="btn btn-light reply_comment" id="inner_btns"  data-bs-toggle="modal" data-bs-target="#Replymodal">Reply</button>
                                                    }
                                                </span>

                                                <span>
                                                    if(<?php Auth::check() ?>&& ${res.data.user_id} == <?php Auth::id() ?> && <?php $blog->allow_comment == 0; ?>){
                                                        <button data-id="${res.data.id}" class="btn btn-light edit_comment" id="inner_btns" data-bs-toggle="modal" data-bs-target="#editcomment">Edit</button>

                                                    }
                                                </span>


                                                <span style="float:right">
                                                    if(<?php Auth::check() ?> && <?php $blog->allow_comment == 0; ?> && (${res.data.user_id} == <?php Auth::id() ?> || ( <?php Auth::user()->role_id ?> == <?php echo \App\Models\User::admin ?>))  ){
                                                        <form method="post"  action="{{url('/')}}/delete/comment`+res.data.id+`">
                                                            @csrf
                                                            <a  id="inner_btns_delete" class="btn btn-danger comment_delete"> Delete</a>
                                                        </form>  
                                                        
                                                    }
                                                </span>

                                        
                                        
                                    </div>
                            </div>
                        `
                    );
                    
                    
                    
            },
            error:function(error){
                console.log("something went wrong");
            },


        });
    }

});

</script>

@endsection