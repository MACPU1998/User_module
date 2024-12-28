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
            <form method="post" action="{{ route('user.users_management.users.update',["user"=>$user->id]) }}" class="form" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <x-admin.form.text required="true" sectionClass="col-md-3" label="{{__('general.first_name')}}" name="first_name" value="{{old('first_name', $user->first_name)}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-3" label="{{__('general.last_name')}}" name="last_name" value="{{old('last_name', $user->last_name)}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-3" label="{{__('general.national_code')}}" name="national_code" value="{{$user->national_code}}"/>
                    <x-admin.form.text required="true" sectionClass="col-md-3" label="{{__('general.mobile')}}" name="mobile" value="{{$user->mobile}}"/>
                    <x-admin.form.text sectionClass="col-md-3" label="{{__('general.phone')}}" name="phone" value="{{$user->phone}}"/>
                    <x-admin.form.text sectionClass="col-md-3" label="{{__('general.father_name')}}" name="father_name" value="{{$user->father_name}}"/>
                    <div class="col-md-6 col-12 mb-4">
                        <label for="flatpickr-date" class="form-label">تاریخ تولد</label>
                        <input type="text" class="form-control flatpickr-date" name="birthdate" placeholder="YYYY/MM/DD" id="flatpickr-date" value="{{$user->jalali_birthdate}}"/>
                    </div>
{{--                    <x-admin.form.text required="true" sectionClass="col-md-6" label="{{__('general.birthdate')}}" required="true" name="birthdate" value="{{$user->jalali_birthdate}}"/>--}}

                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.province')}}" :items="$provinces" selectedItem="{{$user->province_id}}" required="true" name="province_id"/>
                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.city')}}" :items="$cities" selectedItem="{{$user->city_id}}" required="true" name="city_id"/>


                    <x-admin.form.text required="true" sectionClass="col-md-8" label="{{__('general.address')}}" required="true" name="address" value="{{$user->address}}"/>
                    <x-admin.form.text sectionClass="col-md-4" label="{{__('general.postal_code')}}" name="postal_code" value="{{$user->postal_code}}"/>
                    <x-admin.form.text sectionClass="col-md-4" label="{{__('general.bank_account_number')}}" name="bank_account_number" value="{{$user->bank_account_number}}"/>
                    <x-admin.form.text sectionClass="col-md-4" label="{{__('general.bank_sheba')}}" name="bank_sheba" value="{{$user->bank_sheba}}"/>
                    <x-admin.form.text sectionClass="col-md-4" label="{{__('general.bank_card_number')}}" name="bank_card_number" value="{{$user->bank_card_number}}"/>
                    <x-admin.form.file sectionClass="col-md-4" label="{{__('general.document')}}" name="document_file" preview="{{$user->document_file}}"/>
                    <x-admin.form.file sectionClass="col-md-4" label="{{__('general.personal_picture')}}" name="personal_picture_file" preview="{{$user->personal_picture_file}}"/>
                    <x-admin.form.file sectionClass="col-md-4" label="{{__('general.id_card')}}" name="id_card_file" preview="{{$user->id_card_file}}"/>



                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.gender')}}" :items="$genders" selectedItem="{{$user->gender}}" required="true" name="gender"/>
                    <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" selectedItem="{{$user->status}}" required="true" name="status"/>
                    <x-admin.form.text sectionClass="col-md-12" label="{{__('general.comment')}}" name="comment" value="{{$user->comment}}"/>

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