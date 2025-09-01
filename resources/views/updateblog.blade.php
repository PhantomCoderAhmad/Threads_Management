@if(isset($blog))
<div class="modal fade" id="Updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form  method="post" action="{{ route('blogupdate') }}"  enctype="multipart/form-data" id="update_post">
                        @csrf
                    
                        <input type="text" name="id" value="{{old('id', $blog->id)}}" hidden/>

                        <div class="mb-3">
                            <label for="title">{{ trans('forum::general.title') }}</label>
                            <input type="text" name="title" value="{{ old('title' , $blog->title) }}" class="form-control" id="title">
                            
                        </div>

                        <div class="mb-3">
                            <label for="description">{{ trans('forum::general.description') }}</label>
                            <textarea  name="description" value="{{ old('description' , $blog->description) }}" style="height: 100px;" class="form-control" id="description">{{$blog->description}}</textarea>
                            
                        </div>

                        <div class="mb-3">
                            <label for="category">Category</label></br>
                           
                            <select name="category"  class="select form-control select2-container input-lg"  id="category" style="width: 100%; height: 200px" 
                            data-select2-tags="true" >
                            
                                    @foreach($blog_category as $prev_categories)
                                        @if($blog->category == $prev_categories->category)
                                            <option value="{{ $prev_categories->category }}" selected>{{ $prev_categories->category }}</option>
                                        @else
                                            <option value="{{ $prev_categories->category }}" >{{ $prev_categories->category }}</option>
                                        @endif

                                    @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            
                            <input type="hidden" name="allow_comment" value="0" />
                            <input class="form-check-input" type="checkbox" name="allow_comment" id="allow_comment" value="1" {{ $blog->allow_comment ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_comment">Disallow Comment's</label>
                        </div>

                        <div class="mb-3">
                            <label for="image">Image</label></br>
                            <img src="{{ asset('../images')}}/{{ $blog->image }}" height="100px" width="120px" style="padding: 12px 0px 12px 0px;" />
                            <input type="file" class="form-control"  name="image" id="image">  
                            
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

@endif


<script>
    $( window ).load(function() {
    $('.select').select2({
        dropdownParent: $("#Updatemodal"),
        placeholder: "Blog Category",
    });
    

});
</script>