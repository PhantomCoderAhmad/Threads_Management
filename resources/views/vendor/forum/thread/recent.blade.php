<style>
    .breadcrumb-item {
        display: none;
    }

    .accordion-button::after {
        display: none;
    }
    
</style>
@extends ('forum::master', ['thread' => null, 'breadcrumbs_append' => [trans('forum::threads.recent')]])

@section ('content')
    <div id="new-posts" class="mb-4">
        <!-- <h2>{{ trans('forum::threads.recent') }}</h2> -->

        @if (! $threads->isEmpty())


        <div class="accordion" id="myAccordion">
            <div class="accordion-item">
                <h2 class="" id="headingOne">
                    <div class="accordion-button top_p" id="first_child">

                        <div class="row" style="width: 100%;">
                            <div class="col-md-4 col-small" style="color: white;">
                                Recent Threads

                            </div>
                            <div class="col-md-2 col-small" style="text-align: center; padding-right: 0px;">
                                <i class="fa fa-thumb-tack " id="li_icons" style="-ms-transform: rotate(20deg);transform: rotate(30deg);" aria-hidden="true"></i>

                            </div>
                            <div class="col-md-2 col-small">
                                <i class="fa fa-comments" id="li_icons" aria-hidden="true"></i>

                            </div>
                            <div class="col-md-3 col-small">
                                <i class="fa fa-clock-o" id="li_icons" aria-hidden="true"></i>

                            </div>
                            <div class="col-md-1">

                            </div>

                        </div>

                    </div>
                    <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                    <div class="card-body">
                        @foreach ($threads as $thread)
                            @include ('forum::thread.partials.list')
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
            <!-- <div class="threads list-group my-3 shadow-sm">
                
            </div> -->
        @else
            <div class="card my-3">
                <div class="card-body text-center text-muted">
                    {{ trans('forum::threads.none_found') }}
                </div>
            </div>
        @endif
    </div>
@stop
