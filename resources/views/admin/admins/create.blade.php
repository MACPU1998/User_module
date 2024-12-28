@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.admins_management.admins.store')}}" enctype="multipart/form-data">
        @csrf
      <div class="row">
        <x-admin.form.image sectionClass="col-md-6" label="{{__('general.image')}}" required="true" name="image"/>
      </div>
      <div class="row">

        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.first_name')}}" required="true" name="first_name" value="{{old('first_name')}}"/>
        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.last_name')}}" name="last_name" value="{{old('last_name')}}"/>
        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.email')}}" name="email" value="{{old('email')}}"/>
        <x-admin.form.text  required="true" sectionClass="col-md-6" label="{{__('general.mobile')}}" name="phone" value="{{old('phone')}}"/>
        <x-admin.form.password required="true" sectionClass="col-md-6" label="{{__('general.password')}}" name="password"/>
        @php
        $status = generateObjectForComponent(\App\Enums\AdminStatus::toCollect(),"name","value");
        @endphp
        <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.role')}}" name="role" :items="$roles" selectedItem="{{old('role')}}"/>

        <x-admin.form.select required="false" sectionClass="col-md-6" label="{{__('general.department')}}" name="department_id[]" :items="$departments" selectedItem="{{old('department_id')}}" multiple/>

        <x-admin.form.select  required="true" sectionClass="col-md-6" label="{{__('general.status')}}" name="status" :items="$status" selectedItem="{{old('status')}}"/>





      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
