@extends("admin.layout.master")
@section("page_title",__('general.create_good'))

@section("content")
<div class="card">
    <div class="card-body">
            <form method="post" action="{{ route('admin.app-settings.sliders.store') }}" class="form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.title')}}" name="title" value="{{old('title')}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.link')}}" name="link" value="{{old('link')}}"/>
                    <x-admin.form.file required sectionClass="col-md-6" label="{{__('general.picture')}}" name="media" preview="{{old('media')}}"/>

                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" required="true" name="status"/>
                </div>

                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>
@endsection
