@extends("admin.layout.master")
@section("page_title",__('general.goods'))
@section("breadcrumbs")

@endsection
@section("content")



{!! $appSliderDataTableBuilder->table() !!}


@endsection
