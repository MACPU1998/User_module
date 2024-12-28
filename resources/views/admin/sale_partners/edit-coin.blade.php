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
            <form method="post" action="{{ route('admin.sale_partners_management.coin.update',["id"=>$salePartner->id]) }}" class="form" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <x-admin.form.text required="true" type="number" min="0" max="100000" oninvalid="this.setCustomValidity('مقدار این فیلد باید بین 0 تا 100000 باشد.')" sectionClass="col-md-3" label="{{__('general.coin')}}" required="true" name="coin" value="{{$salePartner->walletable->balance}}"/>
                </div>

                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>
@endsection
