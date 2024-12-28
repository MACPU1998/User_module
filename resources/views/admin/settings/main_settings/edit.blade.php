@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.settings.main_settings.update')}}" enctype="multipart/form-data">
        @csrf
      <div class="row">
        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.program_title')}}" name="program_title" value="{{getSetting('program_title')}}"/>


        <x-admin.form.text sectionClass="col-md-6" label="{{__('general.phone')}}" name="phone" value="{{getSetting('phone')}}"/>

        <x-admin.form.text sectionClass="col-md-6" label="{{__('general.email')}}" name="email" value="{{getSetting('email')}}"/>

        <x-admin.form.text-editor sectionClass="col-md-12" label="{{__('general.rules')}}" name="rules_content" value="{!!getSetting('rules_content')!!}"/>




      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
