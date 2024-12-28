@extends("admin.layout.master")
@section("page_title",__('general.orders'))
@section("breadcrumbs")

@endsection
@section("content")



{!! $orderDataTable->table() !!}


@endsection
