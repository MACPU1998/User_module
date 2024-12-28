@extends("admin.layout.master")
@section("page_title",__('general.create_sale_partner'))
@section("content")



{!! $salePartnerDataTableBuilder->table() !!}


@endsection
