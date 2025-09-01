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

<div class="container-fluid mb-3" style="padding:0em;" id="manage_users_body">
    <div class="container">
        <div style="margin: auto;">
            <div class="top_header_manage" id="first_child">

                    <div class="row" id="users_list">
                        <div class="col-md-6 col-small manage_action">
                            Username

                        </div>

                        <div class="col-md-3 col-small manage_action">
                            Role
                        </div>

                        <div class="col-md-3 col-small manage_actions">
                            Action

                        </div>

                    </div>

                </div>
        </div>

    <div class="container" style="border: 1px solid #dfdfdf;
    border-radius: 4px; padding:2em; " id="new_added_user" >
    @if (! $manageuser->isEmpty())
        @foreach($manageuser as $user)
            <div class="row">
                    <div class="col-md-6">
                        <p id="blog_title">{{$user->name}}</p>
                    </div>

                    <div class="col-md-3">
                        @if($user->role_id == 2 )
                            <p id="role_admin" ><i class="fas fa-circle"></i> &nbsp Admin</p>
                        @elseif($user->role_id == 1)
                            <p id="role_moderator"><i class="fas fa-circle"></i> &nbsp Moderator</p>
                        @else
                            <p id="role_user"><i class="fas fa-circle"></i> &nbsp User</p>
                        @endif

                    </div>

                    <div class="col-md-3" style="text-align: end; padding: 1em;">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-light edit_user" data-id="{{$user->id}}" id="inner_btns" data-bs-toggle="modal" data-bs-target="#Updatemodalblog">
                                    Edit
                                </button> 
                            </div>
                            <div class="col-md-6 delete_form">
                                <form method="post"  action="{{ route('user.delete', $user->id) }}">
                                    @csrf
                                    <a  id="inner_btns_delete" class="btn btn-danger confirm_modal"> Delete</a>
                                </form>                     
                            </div>
                        </div>    
                        
                    </div>
            </div>
            <hr>
        @endforeach
        @else
            <div class="card-body text-center text-muted">
                No user's found!
            </div>
        @endif
    </div>
</div>
</div>
<div class="container">
    <span>
        {{$manageuser->links('pagination::bootstrap-5')}}
    </span>
</div>

    <div class="modal fade" id="Updatemodalblog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                        <form  method="post" action="{{ route('userupdate') }}"  id="update_user">
                            @csrf
                        
                            <input type="text" name="id" value=""   id="u_id" hidden/>
                            <div class="mb-3">
                                <label for="title" class="mb-1">Username</label>
                                <input type="text" name="name" value="" class="form-control" id="u_name"/>
                                
                            </div>

                            <div class="mb-3">
                            <label for="title" class="mb-1">User role</label>
                                <select name="role_id" id="u_role_id" class="form-control">
                                    <option value="0">User</option>
                                    <option value="1">Moderator</option>
                                    <option value="2">Admin</option>
                                </select>
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



    <!-- Add User Modal -->
    <div class="modal fade" id="AddnewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        
                            <form  id="add_user_form">

                                <div class="row mb-3">
                                    <!-- <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="name" type="text" placeholder="Username" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        <span class="error" id="email_error"></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            <span class="error" id="password_error">
                                            
                                            </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" placeholder="Confirm Passsword" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="mb-3">
                                        <select class="form-select" id="role_id" name="role_id" required style="color: #6e7589;" >
                                            <option value="NULL" disabled selected >Select User Role</option>
                                                
                                                    <option value="0" >user</option>
                                                    <option value="1" >moderator</option>
                                        </select>
                                        
                                </div>


                                <div class="modal-footer" style="padding: 1em 0em 0em 0em;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Register User</button>
                                </div>

                                
                            </form>

                        </div>
                        
                </div>
            </div>
    </div>
    <!-- Add User Modal -->

@endsection

@section('js_section')
<script>
    
var manageusers;
$( window ).load(function() {
        $('.select').select2({
            dropdownParent: $("#Updatemodalblog"),
            placeholder: "Blog Category",
        });
    });

$( document ).ready(function() {
$(".edit_btn").hide();
$(".pst_btn").hide();
$(".add_user_btn").show();
manageusers = <?php echo json_encode($manageuser);?>;
});

$("#add_user_form").validate({
	onkeyup: function(element) {
        var element_id = $(element).attr('id');
        if (this.settings.rules[element_id].onkeyup !== false) {
            $.validator.defaults.onkeyup.apply(this, arguments);
        }
    },
            rules: {
              name: {
            required: true,
            onkeyup: false
        },
        email: {
            required: true,
            onkeyup: false
        },
        password: {
            required: true,
            onkeyup: false,
            minlength : 8,
        },
        password_confirmation: {
            required: true,
            minlength : 8,
            onkeyup: false,
            equalTo: "#password"
        },
        role_id: {
            required: true,
            onkeyup: false
        },

            },
            messages: {
                name:  `<i class="fas fa-exclamation-triangle error_icon"  >  Name is required.</i> `,
                email: `<i class="fas fa-exclamation-triangle error_icon"  >  Email is required. </i> `,
                password: {
                    required: `<i class="fas fa-exclamation-triangle error_icon"  >  Password is required. </i> `,
                    minlength:  `<i class="fas fa-exclamation-triangle error_icon"  >  Your password must be at least 8 characters long </i> `,
                    
                }, 
                password_confirmation: {
                    required: `<i class="fas fa-exclamation-triangle error_icon"  >  Confirm password required </i> `,
                    minlength: `<i class="fas fa-exclamation-triangle error_icon"  >  Your password must be at least 8 characters long </i> `,
                    equalTo: `<i class="fas fa-exclamation-triangle error_icon"  > Please enter the same password as above </i> `,
                },
                role_id: `<i class="fas fa-exclamation-triangle error_icon"  >  User role is required. </i> `,

            },
		
            submitHandler: function (form) {
    let name = $('#name').val();

    let email = $('#email').val();
    let password = $('#password').val();
    let password_confirmation = $('#password-confirm').val();
    let role_id = $('#role_id').val();
    
    $.ajax({
      url: "{{url('createuser')}}",
      type:"POST",
	  dataType: 'json',
      data:{
        _token: "{{ csrf_token() }}" ,
        name: name,
        email: email,
        password: password,
        password_confirmation: password_confirmation,
        role_id: role_id,
      },
      success:function(res){

         manageusers.data.push(res.user);

        var role_name = ``;
            if(res.user.role_id ==  <?php echo \App\Models\User::admin ?>)
            {
                role_name = `<p id="role_admin" ><i class="fas fa-circle"></i> &nbsp Admin</p>`
            }
            else if(res.user.role_id == <?php echo \App\Models\User::moderator?>)
            {
                role_name = `<p id="role_moderator"><i class="fas fa-circle"></i> &nbsp Moderator</p>`
            }
            else
            {
                role_name = `<p id="role_user"><i class="fas fa-circle"></i> &nbsp User</p>`
            }

        $('#add_user_form').trigger("reset");
        $('#AddnewUser').modal('hide');
        $("#new_added_user").append(
            `<div class="row">
                    <div class="col-md-6">
                        <p id="blog_title">`+res.user.name+`</p>
                    </div>

                    <div class="col-md-3">
                    
                        ${role_name}

                    </div>

                    <div class="col-md-3" style="text-align: end; padding: 1em;">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-light edit_user" data-id="${res.user.id}" id="inner_btns" data-bs-toggle="modal" data-bs-target="#Updatemodalblog">
                                    Edit
                                </button> 
                            </div>
                            <div class="col-md-6 delete_form">
                                <form method="post"  action="{{url('/')}}/delete/user/`+res.user.id+`">
                                    @csrf
                                    <a  id="inner_btns_delete" class="btn btn-danger confirm_modal"> Delete</a>
                                </form>                     
                            </div>
                        </div>    
                        
                            
                    </div>
            </div>
            <hr>`
            );
            $(".message").show();
            $("#success_message").html(res.message);
            
            setTimeout(function() {
                $('.message').fadeOut('fast');
            }, 2000);
	   
      },
      error:function(xhr,error){
        var err = JSON.parse(xhr.responseText);
        var error_message_email = err.message;
            $("#email_error").html(`<i class="fas fa-exclamation-triangle error_icon"  > ${error_message_email} </i>`);
      },


      });
	}


});
$(document).on("click", ".edit_user", function(e) {
        var id = $(this).data('id');
        var users = manageusers.data.find(users => users.id === id);
        $("#u_id").val(id);
        $("#u_name").val(users.name);
        $("#u_role_id").val(users.role_id);
        
    });


    $("#update_user").validate({
	onkeyup: function(element) {
        var element_id = $(element).attr('id');
        if (this.settings.rules[element_id].onkeyup !== false) {
            $.validator.defaults.onkeyup.apply(this, arguments);
        }
    },
            rules: {
              name: {
            required: true,
            onkeyup: false
        },

            },
            messages: {
                name:  `<i class="fas fa-exclamation-triangle error_icon"  >  Username is required.</i> `,

            },
			

});


$(document).on("click", ".confirm_modal", function(event) {
          var form =  $(this).closest("form");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this User.`,
              text: "This User will delete permanently!",
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