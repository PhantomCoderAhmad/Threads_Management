@if( !(Request::is('login') || Request::is('register')) )
<div class="container-fluid mb-3"  id="dashboardmaster_top">
        <div class="container" >
            <div class="row" style="padding: 32px 0px 32px 0px;">

                <div class="col-md-4" style="text-align: left;">
                        <h2 style="color: white; font-weight: 200;"><a href="{{url('/')}}" style="text-decoration: none; color: white; font-weight: 200;">Home</a></h2>
                </div>

                <div class="col-md-8" style="text-align: end;">
                        @if(Auth::check() && Auth::user()->role_id == \App\Models\User::admin)

                        <button type="button" style="display: none;" class="btn btn-light pst_btn" id="post_btn" data-bs-toggle="modal" data-bs-target="#myModal">
                            Add New Post
                        </button>

                        <button type="button" style="display: none;" class="btn btn-light add_user_btn" id="add_user_btn" data-bs-toggle="modal" data-bs-target="#AddnewUser">
                            Add New User
                        </button> 

                        <form id="edit_form">
                            <button type="button" style="display: none;" class="btn btn-light edit_btn" id="post_btn" data-bs-toggle="modal" data-bs-target="#Updatemodal">
                                Edit Post
                            </button> 
                        </form>

                        @endif
                          
                </div>

            </div>
                
        </div>
</div>
@endif
    
    @if(session()->has('message'))
        <div class="container" style="padding: 1.5em;" id="close_btn">
            <div class="row">
            <div class="alert alert-success col-md-12" >
            {{ session()->get('message') }}
                <a href="#"  style="float: right; color: black;"><i class="fas fa-times" style="text-align: end;" id="close_btn_ref"></i></a>
            </div>
            </div>
        </div>
    @endif

    <div class="container message" style="padding: 1.5em; display: none;" id="close_btn_ajax" >
        <div class="row">
            <div class="alert alert-success col-md-12" >
                <span id="success_message"></span>
                <a href="#"  style="float: right; color: black;"><i class="fas fa-times" style="text-align: end;" id="close_btn_ref_ajax"></i></a>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form  method="post" action="{{ route('blog') }}"  enctype="multipart/form-data" id="add_post">
                        @csrf
                        <div class="mb-3">
                            <label for="title">{{ trans('forum::general.title') }}</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description">{{ trans('forum::general.description') }}</label>
                            <textarea  name="description" value="{{ old('description') }}" style="height: 100px;" class="form-control" id="description"></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category">Category</label></br>
                           
                            <select name="category"  class="select form-control select2-container input-lg"  id="category" style="width: 100%; height: 200px" 
                            data-select2-tags="true" >
                            
                                    @foreach($blog_category as $prev_categories)
                                        <option value="{{ $prev_categories->category }}" >{{ $prev_categories->category }}</option>
                                    @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="allow_comment" id="allow_comment" value="1" {{ old('allow_comment') ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_comment">Disallow Comment's</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" required name="image" id="image">  
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

  
</div>

<script>

$("#add_post").validate({
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
        image: {
            required: true,
            onkeyup: false
        },

            },
            messages: {
                title:  `<i class="fas fa-exclamation-triangle error_icon"  >  Title is required.</i> `,
                description: `<i class="fas fa-exclamation-triangle error_icon"  >  Description is required. </i> `,
                category: `<i class="fas fa-exclamation-triangle error_icon"  >  Category is required. </i> `,
                image: `<i class="fas fa-exclamation-triangle error_icon"  >  Image is required. </i> `,

            },
			

});




$( window ).load(function() {
    $('.select').select2({
        dropdownParent: $("#myModal"),
        placeholder: "Blog Category",
    });
    
    setTimeout(function() {
    $('#close_btn').fadeOut('fast');
}, 2000);

});

$("#close_btn_ref").click(function(){
    $("#close_btn").hide();
  });
  $("#close_btn_ref_ajax").click(function(){
    $("#close_btn_ajax").hide();
  });
</script>
