@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.offer.actions.edit', ['name' => $offer->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <offer-form
                :action="'{{ $offer->resource_url }}'"
                :data="{{ $offer->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.offer.actions.edit', ['name' => $offer->title]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.offer.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </offer-form>

        </div>
    
</div>

@endsection