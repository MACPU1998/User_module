@extends("admin.layout.master")
@section("page_title",__('general.edit_user'))
{{-- @section("breadcrumbs")
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol>
@endsection --}}
@section("content")
<div class="card">
    <div class="card-body">
            <form method="post" action="{{ route('admin.sale_partners_management.sale_partners.store') }}" class="form" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.first_name')}}" name="first_name" value="{{old('first_name', old('first_name'))}}"/>

                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.last_name')}}" name="last_name" value="{{old('last_name', old('last_name'))}}"/>

                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.national_code')}}" name="national_code" value="{{old('national_code')}}"/>

                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.mobile')}}" name="mobile" value="{{old('mobile')}}"/>

                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.phone')}}" name="phone" value="{{old('phone')}}"/>

                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.father_name')}}" name="father_name" value="{{old('father_name')}}"/>

                    <div class="col-md-6 col-12 mb-4">
                        <label for="flatpickr-date" class="form-label">تاریخ تولد <span class="text-danger">*</span></label>
                        <input type="text" class="form-control flatpickr-date" name="birthdate" placeholder="YYYY/MM/DD" id="flatpickr-date" value="{{old('birthdate')}}"/>
                    </div>


                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.province')}}" :items="$provinces" selectedItem="{{old('province_id')}}" required="true" name="province_id"/>

                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.city')}}" :items="$cities" selectedItem="{{old('city_id')}}" required="true" name="city_id"/>


                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.address')}}" required="true" name="address" value="{{old('address')}}"/>

                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.postal_code')}}" name="postal_code" value="{{old('postal_code')}}"/>

                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.bank_account_number')}}" name="bank_account_number" value="{{old('bank_account_number')}}"/>

                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.bank_sheba')}}" name="bank_sheba" value="{{old('bank_sheba')}}"/>

                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.bank_card_number')}}" name="bank_card_number" value="{{old('bank_card_number')}}"/>

                    <x-admin.form.file sectionClass="col-md-6" label="{{__('general.personal_picture')}}" name="personal_image_file" preview="{{old('personal_image_file')}}"/>

                    <x-admin.form.file sectionClass="col-md-6" label="{{__('general.id_card')}}" name="id_card_file" preview="{{old('id_card_file')}}"/>

                    <x-admin.form.file sectionClass="col-md-6" label="{{__('general.contract_picture')}}" name="contract_picture" preview="{{old('contract_picture')}}"/>

                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.gender')}}" :items="$genders" selectedItem="{{old('gender')}}" required="true" name="gender"/>

                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.status')}}" :items="$status" selectedItem="{{old('status')}}" required="true" name="status"/>



                </div>

                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>
@push("scripts")
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreBlogPostRequest', '#my-form'); !!} --}}
    <script>

    </script>
@endpush

@endsection
