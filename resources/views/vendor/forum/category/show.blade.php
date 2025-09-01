<style>
    .breadcrumb-item {
        display: none;
    }

    .accordion-button::after {
        display: none;
    }

    #main {
        padding: 1em;
    }
</style>
<link rel="stylesheet" href="{{ asset( '/css/style.css') }}?v={{time()}}" rel="stylesheet ">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{-- $thread is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends('forum::master', ['thread' => null])

@section('content')
<div class="container-fluid" style="padding: 0em;">
    @if (! $threads->isEmpty())
    @can ('markThreadsAsRead')
    <div class="mt-3" style="text-align:end;">
        <button class=" reply_btn" style="margin: auto;
    margin-bottom: 6px;" data-open-modal="mark-threads-as-read">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> {{ trans('forum::general.mark_read') }}
        </button>
    </div>

    @include ('forum::category.modals.mark-threads-as-read')
    @endcan
    @endif
</div>
<div class="container-fluid flex-row justify-content-between mb-4">
    <div class="row" id="top_row">
        <div class="col-md-4">
            <h2 id="heading_cat_title">
                {{ $category->title }}
            </h2>
        </div>
        <div class="col-md-6 text-end">
            @if($category->parent_id == null)
            <i class="fa fa-thumb-tack " style="-ms-transform: rotate(20deg);transform: rotate(30deg); color: white; padding: 12px;" aria-hidden="true"></i>
            @endif
        </div>
        <div class="col-md-2">
            @if ($category->accepts_threads)
            @can ('createThreads', $category)
            <a href="{{ Forum::route('thread.create', $category) }}" class="btn float-end" id="top_btn1">{{ trans('forum::threads.new_thread') }}</a>
            @endcan
            @endif

            @can ('editcategories')
            <button type="button" class="btn  float-end" data-open-modal="edit-category " id="top_btn1">
                {{ trans('forum::general.edit') }}
            </button>
            @endcan
        </div>
    </div>

    <div class="row" style="    border: 1px solid #dfdfdf;">
        <div class="col-md-6">
            <p id="descript">
                @if ($category->description)
                {{ $category->description }}
                @endif
            </p>

        </div>
        <div class="col-md-4 text-end">
            @if($category->parent_id == null)
            @if($category->pinned == 1)
            <i class="fa fa-thumb-tack " style="-ms-transform: rotate(20deg);transform: rotate(30deg); color: #4dc12f; padding: 12px;" aria-hidden="true"></i>
            @else
            <i class="fa fa-thumb-tack " style="-ms-transform: rotate(20deg);transform: rotate(30deg); color: grey; padding: 12px;" aria-hidden="true"></i>
            @endif
            @endif
        </div>
        <div class="col-md-2"></div>
    </div>


</div>


<div class="v-category-show">





    @if (! $category->children->isEmpty() && $category->is_private == 0 || $category->is_private == 1)
    <div class="container" style="padding:0em;">
        <div class="accordion" id="myAccordion">
            <div class="accordion-item">
                <h2 class="" id="headingOne">
                    <div class="accordion-button top_p" id="first_child">

                        <div class="row" style="width: 100%;">
                            <div class="col-md-5 col-small" style="color: white;">
                                Subcategories

                            </div>
                            <div class="col-md-2 col-small" style="text-align: center; padding-right: 0px;">
                                <!-- <i class="fa fa-thumb-tack " id="li_icons" style="-ms-transform: rotate(20deg);transform: rotate(30deg);" aria-hidden="true"></i> -->

                            </div>
                            <div class="col-md-2 col-small">
                                <i class="fa fa-comments" id="li_icons" aria-hidden="true"></i>

                            </div>
                            <div class="col-md-3 col-small">
                                <i class="fa fa-clock-o" id="li_icons" aria-hidden="true"></i>

                            </div>

                        </div>

                    </div>
                    <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                    <div class="card-body">
                        @foreach ($category->children as $subcategory)
                        @include('forum::category.partials.listsubcategory', ['category' => $subcategory])
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    @endif




    @if ($category->accepts_threads)
    @if (! $threads->isEmpty())
    <div class="mt-4">
        {{ $threads->links('forum::pagination') }}
    </div>

    @if (count($selectableThreadIds) > 0)
    @can ('manageThreads', $category)
    <form :action="actions[selectedAction]" method="POST">
        @csrf
        <input type="hidden" name="_method" :value="actionMethods[selectedAction]" />

        <div class="text-end mt-2">
            <div class="form-check">
                <label for="selectAllThreads">
                    {{ trans('forum::threads.select_all') }}
                </label>
                <input type="checkbox" value="" id="selectAllThreads" class="align-middle" @click="toggleAll" :checked="selectedThreads.length == selectableThreadIds.length">
            </div>
        </div>
        @endcan
        @endif
        <div class="threads list-group my-3 shadow-sm">

            <div class="container" style="padding:0em;">
                <div class="accordion" id="myAccordion">
                    <div class="accordion-item">
                        <h2 class="" id="headingOne">
                            <div class="accordion-button top_p" id="first_child">

                                <div class="row" style="width: 100%;">
                                    <div class="col-md-4 col-small" style="color: white;">
                                        Threads

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
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                            <div class="card-body">
                                @foreach ($threads as $thread)
                                @if(Auth::check() && ( Auth::user()->role_id == (\App\Models\User::admin || \App\Models\User::moderator )) )
                                @include ('forum::thread.partials.list')
                                @elseif(!$thread->trashed())
                                @include ('forum::thread.partials.list')
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>

        @if (count($selectableThreadIds) > 0)
        @can ('manageThreads', $category)
        <div class="fixed-bottom-right pb-xs-0 pr-xs-0 pb-sm-3 pr-sm-3 m-2" style="z-index: 1000;">
            <transition name="fade">
                <div class="card text-white bg-secondary shadow-sm" v-if="selectedThreads.length">
                    <div class="card-header text-center">
                        {{ trans('forum::general.with_selection') }}
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="bulk-actions">{{ trans_choice('forum::general.actions', 1) }}</label>
                            </div>
                            <select class="form-select" id="bulk-actions" v-model="selectedAction">
                                @can ('deleteThreads', $category)
                                <option value="delete">{{ trans('forum::general.delete') }}</option>
                                @endcan
                                @can ('restoreThreads', $category)
                                <option value="restore">{{ trans('forum::general.restore') }}</option>
                                @endcan
                                @can ('moveThreadsFrom', $category)
                                <option value="move">{{ trans('forum::general.move') }}</option>
                                @endcan
                                @can ('lockThreads', $category)
                                <option value="lock">{{ trans('forum::threads.lock') }}</option>
                                <option value="unlock">{{ trans('forum::threads.unlock') }}</option>
                                @endcan
                                @can ('pinThreads', $category)
                                <option value="pin">{{ trans('forum::threads.pin') }}</option>
                                <option value="unpin">{{ trans('forum::threads.unpin') }}</option>
                                @endcan
                            </select>
                        </div>

                        <div class="mb-3" v-if="selectedAction == 'move'">
                            <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                            <select name="category_id" id="category-id" class="form-select">
                                @include ('forum::category.partials.options', ['hide' => $category])
                            </select>
                        </div>

                        @if (config('forum.general.soft_deletes'))
                        <div class="form-check mb-3" v-if="selectedAction == 'delete'">
                            <input class="form-check-input" type="checkbox" name="permadelete" value="1" id="permadelete">
                            <label class="form-check-label" for="permadelete">
                                {{ trans('forum::general.perma_delete') }}
                            </label>
                        </div>
                        @endif

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" @click="submit" :disabled="selectedAction == null">{{ trans('forum::general.proceed') }}</button>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </form>
    @endcan
    @endif
    @else

    <div class="accordion" id="myAccordion">
        <div class="accordion-item">
            <h2 class="" id="headingOne">
                <div class="accordion-button top_p" id="first_child">

                    <div class="row" style="width: 100%;">
                        <div class="col-md-4 col-small" style="color: white;">
                            Threads

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
                    {{ trans('forum::threads.none_found') }}
                    @can ('createThreads', $category)
                    <br>
                    <a href="{{ Forum::route('thread.create', $category) }}">{{ trans('forum::threads.post_the_first') }}</a>
                    @endcan
                </div>
            </div>
        </div>

    </div>

    @endif

    <div class="row mb-3">
        <div class="col col-xs-8">
            {{ $threads->links('forum::pagination') }}
        </div>
        <div class="col col-xs-4 text-end">
            @if ($category->accepts_threads)
            @can ('createThreads', $category)
            <a href="{{ Forum::route('thread.create', $category) }}" class="reply_btn">{{ trans('forum::threads.new_thread') }}</a>
            @endcan
            @endif
        </div>
    </div>
    @endif
</div>

@can('editcategories')
@include ('forum::category.modals.edit')
@endcan

@can ('manageCategories')
@include ('forum::category.modals.delete')
@endcan

<style>
    .list-group.threads .list-group-item {
        border-left-width: 2px;
    }

    .list-group.threads .list-group-item.locked {
        border-left-color: var(--bs-yellow);
    }

    .list-group.threads .list-group-item.pinned {
        border-left-color: var(--bs-cyan);
    }

    .list-group.threads .list-group-item.deleted {
        border-left-color: var(--bs-red);
        opacity: 0.5;
    }
</style>

<script>
    new Vue({
        el: '.v-category-show',
        name: 'CategoryShow',
        data: {
            selectableThreadIds: @json($selectableThreadIds),
            actions: {
                'delete': "{{ Forum::route('bulk.thread.delete') }}",
                'restore': "{{ Forum::route('bulk.thread.restore') }}",
                'lock': "{{ Forum::route('bulk.thread.lock') }}",
                'unlock': "{{ Forum::route('bulk.thread.unlock') }}",
                'pin': "{{ Forum::route('bulk.thread.pin') }}",
                'unpin': "{{ Forum::route('bulk.thread.unpin') }}",
                'move': "{{ Forum::route('bulk.thread.move') }}"
            },
            actionMethods: {
                'delete': 'DELETE',
                'restore': 'POST',
                'lock': 'POST',
                'unlock': 'POST',
                'pin': 'POST',
                'unpin': 'POST',
                'move': 'POST'
            },
            selectedAction: null,
            selectedThreads: [],
            isEditModalOpen: false,
            isDeleteModalOpen: false
        },
        methods: {
            toggleAll() {
                this.selectedThreads = (this.selectedThreads.length < this.selectableThreadIds.length) ? this.selectableThreadIds : [];
            },
            submit(event) {
                if (this.actionMethods[this.selectedAction] === 'DELETE' && !confirm("{{ trans('forum::general.generic_confirm') }}")) {
                    event.preventDefault();
                }
            },
            onClickModal(event) {
                if (event.target.classList.contains('modal')) {
                    this.isEditModalOpen = false;
                    this.isDeleteModalOpen = false;
                }
            }
        }
    });
</script>
@stop