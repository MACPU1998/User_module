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
            <form method="post" action="{{ route('user.users_management.giftshop_orders.update',[$model->id]) }}" class="form" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <x-admin.form.text readonly="true" sectionClass="col-md-3" label="{{__('general.first_name')}}" value="{{old('first_name', $user->first_name)}}"/>
                    <x-admin.form.text readonly="true" sectionClass="col-md-3" label="{{__('general.last_name')}}" value="{{old('last_name', $user->last_name)}}"/>
                    <x-admin.form.text readonly="true" sectionClass="col-md-3" label="{{__('general.mobile')}}" value="{{$user->mobile}}"/>
                    <x-admin.form.text readonly="true" sectionClass="col-md-3" label="{{__('general.phone')}}" value="{{$user->phone}}"/>
                    <x-admin.form.text readonly="true" sectionClass="col-md-8" label="{{__('general.address')}}" value="{{$user->address}}"/>
                    <x-admin.form.text readonly="true" sectionClass="col-md-4" label="{{__('general.postal_code')}}" value="{{$user->postal_code}}"/>
                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" selectedItem="{{$model->status}}" required="true" name="status"/>
                </div>
                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>
@push("scripts")
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreBlogPostRequest', '#my-form'); !!} --}}
@endpush

@endsection
