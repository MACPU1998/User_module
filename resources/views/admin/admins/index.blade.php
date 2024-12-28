@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")



{!! $adminDatatableBuilder->table() !!}


@endsection
