<div class="form-group row align-items-center" :class="{'has-danger': errors.has('descr'), 'has-success': fields.descr && fields.descr.valid }">
    <label for="descr" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.feedback.columns.descr') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.descr" v-validate="'required'" id="descr" name="descr"></textarea>
        </div>
        <div v-if="errors.has('descr')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('descr') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.feedback.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.feedback.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('request'), 'has-success': fields.request && fields.request.valid }">
    <label for="request" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.feedback.columns.request') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.request" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('request'), 'form-control-success': fields.request && fields.request.valid}" id="request" name="request" placeholder="{{ trans('admin.feedback.columns.request') }}">
        <div v-if="errors.has('request')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('request') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.feedback.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}" id="type" name="type" placeholder="{{ trans('admin.feedback.columns.type') }}">
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('score'), 'has-success': fields.score && fields.score.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="score" type="checkbox" v-model="form.score" v-validate="''" data-vv-name="score"  name="score_fake_element">
        <label class="form-check-label" for="score">
            {{ trans('admin.feedback.columns.score') }}
        </label>
        <input type="hidden" name="score" :value="form.score">
        <div v-if="errors.has('score')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('score') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('master'), 'has-success': fields.master && fields.master.valid }">
    <label for="master" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.feedback.columns.master') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.master" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('master'), 'form-control-success': fields.master && fields.master.valid}" id="master" name="master" placeholder="{{ trans('admin.feedback.columns.master') }}">
        <div v-if="errors.has('master')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('master') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('client'), 'has-success': fields.client && fields.client.valid }">
    <label for="client" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.feedback.columns.client') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.client" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('client'), 'form-control-success': fields.client && fields.client.valid}" id="client" name="client" placeholder="{{ trans('admin.feedback.columns.client') }}">
        <div v-if="errors.has('client')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('client') }}</div>
    </div>
</div>


