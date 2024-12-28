<div class="d-flex paginate_section">

    @if(count($paginateSizes)>0)

        <select class="form-select" name="pageSize" id="page-size" data-hide-search="true" data-control="select2" class="form-select form-select-solid">
            @foreach($paginateSizes as $size)
                <option value="{{$size}}"
                    {{isset(session($tableName."_paginate")["perPage"]) && session($tableName."_paginate")["perPage"]==$size?"selected='selected'":""}}
                >{{$size}}</option>
            @endforeach
        </select>
        <form action="{{route("set_page",$tableName)}}" name="set-page-form" method="POST">
            @csrf
            <input id="per-page" name="size" hidden />
        </form>
    @endif
</div>

@push("scripts")
<script>
    $(document).ready(function() {
        $('#page-size').on('change', function() {
            $("#per-page").val($(this).val());
            document.forms["set-page-form"].submit();
        });
    });
</script>
@endpush

