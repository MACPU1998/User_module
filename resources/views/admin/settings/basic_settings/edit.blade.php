@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.settings.basic_settings.update',$basic_setting->id)}}" enctype="multipart/form-data">
        @csrf
        @method("put")
      <div class="row">

        @if($basic_setting->type == "text")
        <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.value')}}" name="value" value="{{$basic_setting->value}}"/>
        @elseif($basic_setting->type == "textarea")
        <x-admin.form.text-area required="true" type="text" sectionClass="col-md-6" label="{{__('general.value')}}" name="value" class="text-center" value="{{$basic_setting->value}}"/>
        @elseif($basic_setting->type == "bool")
        <x-admin.form.radio required="true" sectionClass="col-md-6" label="{{__('general.value')}}" name="value" :items="$activeStatus" selectedItem="{{$basic_setting->value}}"/>
        @endif


      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>


@endsection
