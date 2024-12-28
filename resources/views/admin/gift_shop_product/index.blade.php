@extends("admin.layout.master")
@section("page_title",__('general.gift_shop_products'))
@section("breadcrumbs")
{{-- <ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol> --}}
@endsection
@section("content")



{!! $giftShopProductDataTable->table() !!}


@endsection
