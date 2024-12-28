@extends("admin.layout.master")
@section("page_title",__('general.edit_user'))
{{-- @section("breadcrumbs")
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol>
@endsection --}}
@section("content")



{!! $userDataTableBuilder->table() !!}


@endsection
