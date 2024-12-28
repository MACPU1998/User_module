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
            <form method="post" action="{{ route('admin.sale_partners_management.sale_partners.update',["sale_partner"=>$salePartner->id]) }}" class="form" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.first_name')}}" name="first_name" value="{{old('first_name', $salePartner->first_name)}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.last_name')}}" name="last_name" value="{{old('last_name', $salePartner->last_name)}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.national_code')}}" name="national_code" value="{{$salePartner->national_code}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.mobile')}}" name="mobile" value="{{$salePartner->mobile}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.phone')}}" name="phone" value="{{$salePartner->phone}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.father_name')}}" name="father_name" value="{{$salePartner->father_name}}"/>
                    <div class="col-md-6 col-12 mb-4">
                        <label for="flatpickr-date" class="form-label">تاریخ تولد</label>
                        <input type="text" class="form-control flatpickr-date" name="birthdate" placeholder="YYYY/MM/DD" id="flatpickr-date" value="{{$salePartner->jalali_birthdate}}"/>
                    </div>
{{--                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.birthdate')}}" required="true" name="birthdate" value="{{$salePartner->jalali_birthdate}}"/>--}}

                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.province')}}" :items="$provinces" selectedItem="{{$salePartner->province_id}}" required="true" name="province_id"/>
                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.city')}}" :items="$cities" selectedItem="{{$salePartner->city_id}}" required="true" name="city_id"/>


                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.address')}}" required="true" name="address" value="{{$salePartner->address}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.postal_code')}}" name="postal_code" value="{{$salePartner->postal_code}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.bank_account_number')}}" name="bank_account_number" value="{{$salePartner->bank_account_number}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.bank_sheba')}}" name="bank_sheba" value="{{$salePartner->bank_sheba}}"/>
                    <x-admin.form.text sectionClass="col-md-6" label="{{__('general.bank_card_number')}}" name="bank_card_number" value="{{$salePartner->bank_card_number}}"/>

                    <x-admin.form.file sectionClass="col-md-6
                    " label="{{__('general.personal_picture')}}" name="personal_picture_file" preview="{{$salePartner->personal_image_file}}"/>
                    <x-admin.form.file sectionClass="col-md-6" label="{{__('general.id_card')}}" name="id_card_file" preview="{{$salePartner->id_card_file}}"/>

                    <x-admin.form.file sectionClass="col-md-6" label="{{__('general.contract_picture')}}" name="contract_picture" preview="{{$salePartner->contract_picture}}"/>

                    <x-admin.form.file sectionClass="col-md-6" label="{{__('general.guarantees_picture')}}" name="guarantees_picture" preview="{{$salePartner->guarantees_picture}}"/>



                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.gender')}}" :items="$genders" selectedItem="{{$salePartner->gender}}" required="true" name="gender"/>
                    <x-admin.form.select required="true" sectionClass="col-md-6" label="{{__('general.status')}}" :items="$status" selectedItem="{{$salePartner->status}}" required="true" name="status"/>


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
