@extends("admin.layout.master")
@section("page_title",__('general.create_good'))
{{-- @section("breadcrumbs")
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol>
@endsection --}}
@section("content")
<div class="card">
    <div class="card-body">
            <form method="post" action="{{ route('admin.sale_partners_management.goods.store') }}" class="form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <x-admin.form.text required="true" sectionClass="col-md-12" label="{{__('general.title')}}" required="true" name="title" value="{{old('title')}}"/>
                    <x-admin.form.text-area required="true" sectionClass="col-md-12" label="{{__('general.description')}}" required="true" name="description" value="{{old('description')}}"/>
                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" required="true" name="status"/>
                    <br>
                    <span class="mt-5"></span>
                    <hr>
                    <x-admin.form.dropzone-file-input id="images" storeUrl="{{route('admin.dropzone.upload.files')}}" name="images" label="{{__('general.images')}}"/>

                </div>

                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>


@endsection
