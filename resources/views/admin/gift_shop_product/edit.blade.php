@extends("admin.layout.master")
@section("page_title",__('general.edit_giftshop_product'))
{{-- @section("breadcrumbs")
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol>
@endsection --}}
@section("content")
<div class="card">
    <div class="card-body">
            <form method="post" action="{{ route('user.users_management.giftshop_products.update',[$model->id]) }}" class="form" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <x-admin.form.text required="true" sectionClass="col-md-12" label="{{__('general.title')}}" required="true" name="title" value="{{old('title', $model->title)}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-12" label="{{__('general.description')}}" required="true" name="description" value="{{old('description', $model->description)}}"/>
                    <x-admin.form.text type="number" required="true" sectionClass="col-md-3" label="{{__('general.cost_value')}}" required="true" name="cost_value" value="{{$model->cost_value}}"/>
                    <x-admin.form.text type="number" required="true" sectionClass="col-md-3" label="{{__('general.stock')}}" required="true" name="stock" value="{{$model->stock}}"/>

                    <x-admin.form.file-preview required="true" sectionClass="col-md-4" label="{{__('general.thumbnail')}}" required="true" name="thumbnail" defaultData="{{$model->thumbnail_url}}" ext="jpg"/>
                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" selectedItem="{{$model->status}}" required="true" name="status"/>
                </div>

                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>
@push("scripts")
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreBlogPostRequest', '#my-form'); !!} --}}
@endpush

@endsection
