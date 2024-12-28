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
        <form method="post" action="{{ route('admin.sale_partners_management.goods.update',$model->id) }}" class="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <x-admin.form.text required="true" sectionClass="col-md-12" label="{{__('general.title')}}" required="true" name="title" value="{{$model->title}}"/>
                <x-admin.form.text-area required="true" sectionClass="col-md-12" label="{{__('general.description')}}" required="true" name="description" value="{{$model->description}}"/>
                <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" required="true" name="status"/>
                <br>
                <span class="mt-5"></span>
                <hr>

                <x-admin.form.dropzone-file-input id="images" :maxFileSize="1" storeUrl="{{route('admin.dropzone.upload.files')}}" name="images" :value="$productImages" label="{{__('general.images')}}"/>

            </div>

            <x-admin.form.submit-buttons />
        </form>
        </div>
</div>


@endsection
