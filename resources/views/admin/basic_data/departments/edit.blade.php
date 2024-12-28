@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.basic_data_management.department.update',$department->id)}}" enctype="multipart/form-dat$department->a">
        @csrf
        @method("put")
      <div class="row">

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.name')}}" name="name" value="{{$department->name}}"/>

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.slug')}}" name="slug" value="{{$department->slug}}"/>

        <x-admin.form.text required="true" type="number" sectionClass="col-md-6" label="{{__('general.sort')}}" name="sort" class="text-center" value="{{$department->sort}}"/>

        <x-admin.form.radio required="true" sectionClass="col-md-6" label="{{__('general.status')}}" name="active" :items="$activeStatus" selectedItem="{{$department->active}}"/>


      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
