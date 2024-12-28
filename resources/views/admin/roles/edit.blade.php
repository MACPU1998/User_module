@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.admins_management.roles.update',$role->id)}}">
        @csrf
        @method("put")
      <div class="row">

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.name')}}" name="name" value="{{$role->name}}"/>

        <x-admin.form.text required="true" type="number" sectionClass="col-md-6" label="{{__('general.sort')}}" name="sort" class="text-center" value="{{$role->sort}}"/>

        <x-admin.form.radio required="true" sectionClass="col-md-6" label="{{__('general.status')}}" name="active" :items="$activeStatus" selectedItem="{{$role->active}}"/>


      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
