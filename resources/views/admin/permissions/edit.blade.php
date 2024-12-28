@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.admins_management.permissions.update',$permission->id)}}" enctype="multipart/form-data">
        @csrf
        @method("put")
      <div class="row">

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.permission_name')}}" name="name" value="{{$permission->name}}"/>

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.slug')}}" name="slug" value="{{$permission->slug}}"/>

        <x-admin.form.select required="false" sectionClass="col-md-6" label="{{__('general.parent')}}" name="parent" :items="$permissions" selectedItem="{{$permission->parent}}" translate="true" translateFile="permissions"/>


        <x-admin.form.text required="true" type="number" sectionClass="col-md-6" label="{{__('general.sort')}}" name="sort" class="text-center" value="{{$permission->sort}}"/>

        <x-admin.form.radio required="true" sectionClass="col-md-6" label="{{__('general.status')}}" name="active" :items="$activeStatus" selectedItem="{{$permission->active}}"/>


      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
