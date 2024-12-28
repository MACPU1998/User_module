@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")
@php
$status = generateObjectForComponent(\App\Enums\AdminStatus::toCollect(),"name","value");
$departments_selected = $admin->departments->pluck("id")->toArray();

@endphp
<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.admins_management.admins.update',$admin->id)}}" enctype="multipart/form-data">
        @csrf
        @method("put")
      <div class="row">
        @php
            $image = $admin->image ? asset('storage/images/avatars/'.$admin->id.'/'.$admin->image) : asset('assets/img/default/avatar.jpg');
        @endphp
        <x-admin.form.image sectionClass="col-md-6" label="{{__('general.image')}}" required="true" name="image" value="{{$image}}"/>
      </div>
      <div class="row">

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.first_name')}}" required="true" name="first_name" value="{{$admin->first_name}}"/>
        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.last_name')}}" name="last_name" value="{{$admin->last_name}}"/>
        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.email')}}" name="email" value="{{$admin->email}}"/>
        <x-admin.form.text  required="true" sectionClass="col-md-6" label="{{__('general.mobile')}}" name="phone" value="{{$admin->phone}}"/>
        <x-admin.form.password required="true" sectionClass="col-md-6" label="{{__('general.password')}}" name="password"/>
        <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.role')}}" name="role" :items="$roles" selectedItem="{{$admin->roles()?->first()?->id}}"/>
        <x-admin.form.select required="false" sectionClass="col-md-6" label="{{__('general.department')}}" name="department_id[]" :selectedItem="$departments_selected" :items="$departments"  multiple/>
        <x-admin.form.select  required="true" allowSearch="true" allowClear="true" sectionClass="col-md-6" label="{{__('general.status')}}" name="status" :items="$status" selectedItem="{{$admin->status}}"/>


      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
