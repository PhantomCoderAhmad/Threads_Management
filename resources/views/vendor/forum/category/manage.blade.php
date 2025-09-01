<style>
    .breadcrumb-item {
        display: none;
    }

    .accordion-button::after {
        display: none;
    }
    #main
    {
        padding: 1em;
    }
    
    
</style>
@extends ('forum::master', ['category' => null, 'thread' => null, 'breadcrumbs_append' => [trans('forum::general.manage')]])

@section ('content')
    <div class="d-flex flex-row justify-content-between mb-2">
        <h2 class="flex-grow-1">{{ trans('forum::general.manage') }}</h2>

        <!-- @can ('createCategories')
            <button type="button" class="btn btn-primary" data-open-modal="create-category">
                {{ trans('forum::categories.create') }}
            </button>

            @include ('forum::category.modals.create')
        @endcan -->
    </div>

    <div class="container-fluid" style="padding:0em;">
            
                <div style="margin: auto;">
                    <div class="top_header_manage" id="first_child">

                        <div class="row" style="width: 100%;">
                            <div class="col-md-9 col-small" style="color: white;">
                                Categories

                            </div>
                            
                            
                            <div class="col-md-3 col-small" style="text-align: end; color:white;">
                                Action

                            </div>

                        </div>

                    </div>
                    <!-- <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne">1. What is HTML?</button>									 -->
                </div>
                    
                        <script type="text/x-template" id="draggable-category-list-template">
                            <draggable tag="ul" class="list-group" :list="categories" group="categories" :invertSwap="true" :emptyInsertThreshold="14">
                                <li class="list-group-item" v-for="category in categories" :data-id="category.id" :key="category.id">
                                    <a class="float-end btn btn-sm btn-danger ml-2" id="delete_btn_manage" :href="`${category.route}#modal=delete-category`">{{ trans('forum::general.delete') }}</a>
                                    <a class="float-end btn btn-sm btn-link ml-2" id="inner_btns" :href="`${category.route}#modal=edit-category`">{{ trans('forum::general.edit') }}</a>
                                    
                                    <strong :style="{ color: category.color }">@{{ category.title }}</strong>
                                    <div class="text-muted">@{{ category.description }}</div><hr>
                                    

                                    <draggable-category-list :categories="category.children"></draggable-category-list>
                                </li>
                            </draggable>
                        </script>

    </div>
    <div class="v-manage-categories" id="v-manage-cat">
        <draggable-category-list :categories="categories"></draggable-category-list>

        <transition name="fade">
            <div v-show="changesApplied" class="alert alert-success mt-3" role="alert">
                {{ trans('forum::general.changes_applied') }}
            </div>
        </transition>

        <div class="py-3 mr-5" style="text-align: end; margin-right: 12px;">
            <button type="button" class="btn btn-primary px-3 py-1 reply_btn" :disabled="isSavingDisabled" @click="onSave">
                {{ trans('forum::general.save') }}
            </button>
        </div>
    </div>

    
    

    <script>
    var draggableCategoryList = {
        name: 'draggable-category-list',
        template: '#draggable-category-list-template',
        props: ['categories']
    };

    new Vue({
        el: '.v-manage-categories',
        name: 'ManageCategories',
        components: {
            draggableCategoryList
        },
        data: {
            categories: @json($categories),
            isSavingDisabled: true,
            changesApplied: false
        },
        watch: {
            categories: {
                handler: function (categories) {
                    this.isSavingDisabled = false;
                },
                deep: true
            }
        },
        methods: {
            onSave ()
            {
                this.isSavingDisabled = true;
                this.changesApplied = false;

                var payload = { categories: this.categories };
                axios.post('{{ route('forum.bulk.category.manage') }}', payload)
                    .then(response => {
                        this.changesApplied = true;
                        setTimeout(() => this.changesApplied = false, 3000);
                    })
                    .catch(error => {
                        this.isSavingDisabled = false;
                        console.log(error);
                    });
            }
        }
    });
    </script>
@stop