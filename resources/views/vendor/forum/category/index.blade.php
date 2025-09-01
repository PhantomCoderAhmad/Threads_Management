<style>
    .breadcrumb-item{
        display: none;
    }
</style>
<title>Forum</title>
<link  rel="stylesheet"  href="{{ asset( '/css/style.css') }}?v={{time()}}" rel="stylesheet ">
{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['category' => null])

@section ('content')
    <!-- <div class="d-flex flex-row justify-content-between mb-2">
        <h2 class="flex-grow-1">{{ trans('forum::general.index') }}</h2>
        
        
        @can ('createCategories')
            <button type="button" class="btn btn-primary" data-open-modal="create-category">
                {{ trans('forum::categories.create') }}
            </button>

            @include ('forum::category.modals.create')
        @endcan
    </div> -->

    <div class="row">
        <div class="col-md-8">
            <!-- accordion strat -->

            <div class="container" style="padding:0em;">
                <div class="accordion" id="myAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <div  class="accordion-button collapsed top_p" id="first_child" data-bs-toggle="collapse" data-bs-target="#collapseOne"  >
                                        
                                <div class="row" style="width: 100%;">
                                        <div class="col-md-5 col-small" style="color: white;">
                                            Categories

                                        </div>
                                        <div class="col-md-2 col-small" style="text-align: center; padding-right: 0px;">
                                        <i class="fa fa-thumb-tack " id="li_icons" style="-ms-transform: rotate(20deg);transform: rotate(30deg);" aria-hidden="true"></i>

                                        </div>
                                        <div class="col-md-2 col-small">
                                            <i class="fa fa-comments" id="li_icons" aria-hidden="true"></i>   
                                            
                                        </div>
                                        <div class="col-md-3 col-small">
                                        <i class="fa fa-clock-o"  id="li_icons" aria-hidden="true"></i>
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                            <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                            <div class="card-body">
                                    @foreach ($categories as $category)
                                        @include ('forum::category.partials.list', ['titleClass' => 'lead'])
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- accordion end -->


            <!--  2nd accordion -->
            @if(Auth::check() && Auth::user()->role_id == \App\Models\User::admin)
            <div class="container mt-5" style="padding:0em;">
                <div class="accordion" id="myAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <div  class="accordion-button collapsed  top_p" id="first_child" data-bs-toggle="collapse" data-bs-target="#collapseOne"  >
                                        
                                <div class="row" style="width: 100%;">
                                        <div class="col-md-10 col-small" style="color: white;">
                                            Secret

                                        </div>
                                        <!-- <div class="col-md-2 col-small" style="text-align: center; padding-right: 0px;">
                                        <i class="fa fa-thumb-tack " id="li_icons" style="-ms-transform: rotate(20deg);transform: rotate(30deg);" aria-hidden="true"></i>

                                        </div> -->
                                        <div class="col-md-2 col-small">
                                            <i class="fa fa-comments" id="li_icons" aria-hidden="true"></i>   
                                            
                                        </div>
                                        <!-- <div class="col-md-3 col-small">
                                        <i class="fa fa-clock-o"  id="li_icons" aria-hidden="true"></i>
                                            
                                        </div> -->
                                        
                                    </div>

                                </div>
                            <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
                            <div class="card-body">
                                
                                    @foreach ($categories as $category)
                                            @include ('forum::category.partials.secret', ['titleClass' => 'lead'])
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
           @endif
            <!--  2nd accordion -->


        </div>

        
        <div class="col-md-4">
            <div class="container-fluid mb-3" id="search_container" >
                <form action="{{ route('forum.index') }}" method="GET">
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

            <div class="container-fluid" style="padding:0px;">
                
                <div class="card">
                    <div class="card-header top_p">
                    <p id="r_t_p">Recent Threads</p>
                    </div>
                    <div class="card-body">
                        @if (! $threads->isEmpty())
                            <div class="threads list-group shadow-sm">
                                @foreach ($threads as $thread)
                                    @include ('forum::thread.partials.thread_list_index')
                                @endforeach
                            </div>
                        @else
                            <div class="card my-3">
                                <div class="card-body text-center text-muted">
                                    {{ trans('forum::threads.none_found') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    





@stop
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script> 


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

