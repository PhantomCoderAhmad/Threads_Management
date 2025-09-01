
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
<div class="container-fluid mb-3" style="padding:0em;">
    <div class="container">
        <div style="margin: auto;">
            <div class="top_header_manage" id="first_child">

            <div class="row" style="width: 100%;">
                <div class="col-md-9 col-small" style="color: white;">
                    News

                </div>
                <div class="col-md-3 col-small manage_actions">
                    Action

                </div>

            </div>

        </div>
</div>
    <div class="container" style="border: 1px solid #dfdfdf;
    border-radius: 4px; padding:2em; ">
    @if (! $manageblog->isEmpty())
        @foreach($manageblog as $post)
            <div class="row">
                    <div class="col-md-9">
                        <a href="{{url('/blog/detail',$post->slug)}}" style="text-decoration: none;"><p id="blog_title">{{$post->title}}</p></a>
                    </div>
                    <div class="col-md-3" style="text-align: end; padding: 1em;">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-light manage_edit_btn" data-id="{{$post->id}}" id="inner_btns" data-bs-toggle="modal" data-bs-target="#Updatemodalblog">
                                    Edit
                                </button> 
                            </div>
                            <div class="col-md-6 delete_form">
                                <form method="post"  action="{{ route('blog.delete', $post->id) }}">
                                    @csrf
                                    <a  id="inner_btns_delete" class="btn btn-danger show_confirm"> Delete</a>
                                </form>                     
                            </div>
                        </div>    
                        
                            
                    </div>
            </div>
            <hr>
        @endforeach
        @else
            <div class="card-body text-center text-muted">
                No post's found!
            </div>
        @endif
    </div>
</div>
</div>
<div class="container">
    <span>
        {{$manageblog->links('pagination::bootstrap-5')}}
    </span>
</div>

<div class="modal fade" id="Updatemodalblog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form  method="post" action="{{ route('blogupdate') }}"  enctype="multipart/form-data" id="update_post">
                        @csrf
                    
                        <input type="text" name="id" value=""   id="u_id" hidden/>
                        <div class="mb-3">
                            <label for="title">{{ trans('forum::general.title') }}</label>
                            <input type="text" name="title" value="" class="form-control" id="u_title"/>
                            
                        </div>

                        <div class="mb-3">
                            <label for="description">{{ trans('forum::general.description') }}</label>
                            <textarea  name="description" value="" style="height: 100px;" class="form-control" id="u_description"></textarea>
                            
                        </div>

                        <div class="mb-3">
                            <label for="category">Category</label></br>
                           
                            <select name="category"  class="select form-control select2-container input-lg"  id="category" style="width: 100%; height: 200px" 
                            data-select2-tags="true" >
                            
                                    @foreach($blog_category as $prev_categories)
                                        
                                            <option id="selected_val" value="{{ $prev_categories->category }}" >{{ $prev_categories->category }}</option>
                                        
                                    @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            
                            <input type="hidden" name="allow_comment" value="0" />
                            <input class="form-check-input" type="checkbox" name="allow_comment" id="allow_commentS" value="1" >
                            <label class="form-check-label" for="allow_comment">Disallow Comment's</label>
                        </div>


                        <div class="mb-3">
                            <label for="image">Image</label></br>
                            <img src="" id="u_image" height="100px" width="120px" style="padding: 12px 0px 12px 0px;" />
                            <input type="file" class="form-control" name="image" id="uimage">  
                            
                        </div>

                        <div class="modal-footer" style="padding: 1em 0em 0em 0em;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>

                    </div>
                    
            </div>
        </div>
    </div>
@endsection

@section('js_section')
<script>
    

$( window ).load(function() {
        $('.select').select2({
            dropdownParent: $("#Updatemodalblog"),
            placeholder: "Blog Category",
        });
    });

$( document ).ready(function() {
$(".edit_btn").hide();
$(".pst_btn").show();
});

$(".manage_edit_btn").click(function(){
    var id = $(this).data('id');
    //alert(id);
        $.ajax({ 
            
            url: "{{url('/edit/blog')}}",
            type:"GET",
            data:{
            id:id,
            },
        
            success: function(res)
            {

               
                $("#u_id").val(res.up_blog.id);
                $("#u_title").val(res.up_blog.title);
                $("#u_description").html(res.up_blog.description);
                $('.select').val(res.up_blog.category); 
                $('.select').trigger('change');

                if(res.up_blog.allow_comment == 1){
                    $("#allow_commentS").attr("checked",true);
                }
                

                $("#u_image").attr("src" , "../images/"+res.up_blog.image);
                $("#image").val(res.up_blog.image);
                console.log(res.up_blog.image);
            }
        });
    });


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

$('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "All comments and replies will also delete along this post.",
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

      
</script>

@endsection