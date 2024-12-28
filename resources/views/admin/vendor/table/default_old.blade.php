@if(!is_null($filterColumns) && count($filterColumns) > 0)
<div class="accordion accordion-flush card" id="accordionFlushExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <a role="button" class="accordion-button pl-3 bg-white @if(!session()->has($tableName."_filter") || count(session($tableName.'_filter')) == 0) collapsed @endif" type="button" >
            <i class="ki-duotone ki-filter-search me-3 h1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <h4 style="line-height: normal;" class="d-inline-block">{{__('general.filter')}}</h4>
        </a>
      </h2>
      <div id="collapseExample" class="collapse @if(session()->has($tableName.'_filter') && count(session($tableName.'_filter')) > 0) show @endif" >
        <div class="accordion-body bg-white">
            <form action="{{route('filter_table',$tableName)}}" method="post">
                @csrf
                    <div class="card-body py-4 row">
                        {!!  $filterSection !!}
                    </div>
                </form>
        </div>
      </div>
    </div>
  </div>
  @endif

  @section("toolbar-section")
  <div class="d-flex">
      @if(!is_null($toolbarButtons) && count($toolbarButtons) > 0)
      <div class="card-toolbar">
          {!!  $toolbarSection !!}
      </div>
      @endif
      @if(!is_null($paginateSection))
          <div class="card-title">
              {!!  $paginateSection !!}
          </div>
      @endif
  </div>
  @endsection

  <div class="card">
    <!--begin::Card body-->
    <div class="card-body">


        {{-- <div class="">
            <table class="table table-striped mb-0">

                <thead>
                    <tr>
                        @if($multiselect && $multiselectButtons && count($multiselectButtons))
                        <th>
                            <div class="form-check">
                                <input class="form-check-input position-static select-all" type="checkbox">
                              </div>
                        </th>
                        @endif
                        @foreach($columns as $column)
                        @if(!multi_dim($column))
                            <th class="{{$column['columnStyle']}}">
                                @if($column['sortable'])
                                    <a href="{{route('sort_table',[$tableName,$column['column']])}}">{!!$column['label']!!}</a>
                                @else
                                    {!!$column['label']!!}
                                @endif

                                @if(isset(session($tableName."_sort")[$column['column']]))
                                    @if(session($tableName."_sort")[$column['column']] ==  "asc")
                                        <i class="ki-duotone ki-arrow-up text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @else
                                        <i class="ki-duotone ki-arrow-down text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @endif
                                @endif
                            </th>
                        @else
                        <th class="{{$column[0]['columnStyle']}}">
                            @php
                            $column=array_filter(array_map(function($item){
                                return ($item['label']) ? $item : null;
                            },$column));
                            @endphp
                            @foreach($column as $key=>$sub_column)
                                    @if($sub_column['sortable'])
                                        <a href="{{route('sort_table',[$tableName,$sub_column['column']])}}">{!!$sub_column['label']!!}</a>
                                        @if(isset(session($tableName."_sort")[$sub_column['column']]))
                                            @if(session($tableName."_sort")[$sub_column['column']] ==  "asc")
                                                <i class="ki-duotone ki-arrow-up text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @else
                                                <i class="ki-duotone ki-arrow-down text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @endif
                                        @endif
                                    @else
                                        {!!$sub_column['label']!!}
                                    @endif
                                @if( $key != count($column) - 1)
                                    /
                                @endif
                            @endforeach
                        </th>
                        @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if($data->count() > 0)
                    @foreach($data as $row)
                    <tr data-id="{{$row->id}}">
                        @if($multiselect  && $multiselectButtons && count($multiselectButtons))
                        <th>
                            <div class="form-check sub-select">
                            <input class="form-check-input position-static " type="checkbox">
                          </div>
                        </th>
                        @endif
                        @foreach($columns as $column)
                        @if(!multi_dim($column))
                        @php
                            $row_key=$column['column'];
                        @endphp
                        <td class="{{$column['columnStyle']}}">
                            {!!DataTableBuilder::columnData($row->$row_key,$column['type'],$row)!!}
                        </td>
                        @else
                        <td>
                            @foreach($column as $key=>$sub_column)
                            @php
                                $row_subkey=$sub_column['column'];
                            @endphp
                            {!!DataTableBuilder::columnData($row->$row_subkey,$sub_column['type'],$row)!!}
                            @if($key<count($column) - 1)
                            {{" "}}
                            @endif
                            @endforeach
                        </td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="{{count($columns)}}" class="text-center">{{__("general.no_records")}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex">
                @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {!! $data->appends(request()->input())->links() !!}
                @endif
            </div>
        </div> --}}

        <div class="table-responsive mt-3">
            <table class="table table-centered datatable dt-responsive nowrap dataTable no-footer" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="DataTables_Table_0">
                <thead class="thead-light">
                    <tr>
                        @if($multiselect && $multiselectButtons && count($multiselectButtons))
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-all" id="customercheck">
                                    <label class="custom-control-label" for="customercheck">&nbsp;</label>
                                </div>
                            </th>
                        @endif
                        @foreach($columns as $column)
                        @if(!multi_dim($column))
                            <th class="{{$column['columnStyle']}}">
                                @if($column['sortable'])
                                    <a href="{{route('sort_table',[$tableName,$column['column']])}}">{!!$column['label']!!}</a>
                                @else
                                    {!!$column['label']!!}
                                @endif
                                @if(isset(session($tableName."_sort")[$column['column']]))
                                    @if(session($tableName."_sort")[$column['column']] ==  "asc")
                                        <i class="ki-duotone ki-arrow-up text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @else
                                        <i class="ki-duotone ki-arrow-down text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @endif
                                @endif
                            </th>
                        @else
                            <th class="{{$column[0]['columnStyle']}}">
                                @php
                                $column=array_filter(array_map(function($item){
                                    return ($item['label']) ? $item : null;
                                },$column));
                                @endphp
                                @foreach($column as $key=>$sub_column)
                                        @if($sub_column['sortable'])
                                            <a href="{{route('sort_table',[$tableName,$sub_column['column']])}}">{!!$sub_column['label']!!}</a>
                                            @if(isset(session($tableName."_sort")[$sub_column['column']]))
                                                @if(session($tableName."_sort")[$sub_column['column']] ==  "asc")
                                                    <i class="ki-duotone ki-arrow-up text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                @else
                                                    <i class="ki-duotone ki-arrow-down text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                @endif
                                            @endif
                                        @else
                                            {!!$sub_column['label']!!}
                                        @endif
                                    @if( $key != count($column) - 1)
                                        /
                                    @endif
                                @endforeach
                            </th>
                        @endif
                        @endforeach
                    </tr>

                </thead>
                <tbody>

                    @if($data->count() > 0)
                    @foreach($data as $row)
                    <tr data-id="{{$row->id}}">
                        @if($multiselect  && $multiselectButtons && count($multiselectButtons))
                        <th>
                            <div class="custom-control custom-checkbox sub-select">
                                <input type="checkbox" class="custom-control-input" id="customercheck">
                                <label class="custom-control-label" for="customercheck">&nbsp;</label>
                            </div>
                        </th>
                        @endif
                        @foreach($columns as $column)
                        @if(!multi_dim($column))
                        @php
                            $row_key=$column['column'];
                        @endphp
                        <td class="{{$column['columnStyle']}}">
                            {!!DataTableBuilder::columnData($row->$row_key,$column['type'],$row)!!}
                        </td>
                        @else
                        <td>
                            @foreach($column as $key=>$sub_column)
                            @php
                                $row_subkey=$sub_column['column'];
                            @endphp
                            {!!DataTableBuilder::columnData($row->$row_subkey,$sub_column['type'],$row)!!}
                            @if($key<count($column) - 1)
                            {{" "}}
                            @endif
                            @endforeach
                        </td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="{{count($columns)}}" class="text-center">{{__("general.no_records")}}</td>
                    </tr>
                    @endif



                </tbody>
            </table>
        </div>





    </div>
  </div>

@push('scripts')
<script>
$(function(){
$("form.tg_remove_form").on("click",".btn_remove",function(e){
e.preventDefault();
var form = $(this).parents("form");
Swal.fire({
html: "{{__('message.delete_confirmation')}}",
icon: "info",
buttonsStyling: false,
showCancelButton: true,
confirmButtonText: '{{__("general.actions.confirm")}}',
cancelButtonText: '{{__("general.actions.cancel")}}',
customClass: {
    confirmButton: "btn btn-primary",
    cancelButton: 'btn btn-danger'
}
}).then((result) => {
/* Read more about isConfirmed, isDenied below */
if (result.isConfirmed) {
form.submit();
}
});
})
});

$(function(){
$("form.ajax_form").on("click",".btn_submit",function(e){
e.preventDefault();
var form = $(this).parents("form");
Swal.fire({
html: "{{__('message.question_confirmation')}}",
icon: "info",
buttonsStyling: false,
showCancelButton: true,
confirmButtonText: '{{__("general.confirm")}}',
cancelButtonText: '{{__("general.cancel")}}',
customClass: {
    confirmButton: "btn btn-primary",
    cancelButton: 'btn btn-danger'
}
}).then((result) => {
/* Read more about isConfirmed, isDenied below */
if (result.isConfirmed) {
form.submit();
}
});
})
});


$(document).on("click",".select-all",function(){
    if($(this).is(':checked'))
        $(this).parents("table").find(".sub-select").find("input").attr("checked","checked").prop("checked",true).trigger("change");
    else
        $(this).parents("table").find(".sub-select").find("input").removeAttr("checked").prop("checked",false).trigger("change");
});

</script>

<script>
    $(function(){
      $(".btn_actions").each(function(index,item){
        if($(item).find("ul li").length == 0)
          $(item).addClass("d-none");
        else
          $(item).removeClass("d-none");
      });
    });
    $(function(){
      $(".btn_multiselect_operation").each(function(index,item){
        if($(item).parent("div").find(".menu-sub-dropdown > .menu-item").length == 0)
          $(item).addClass("d-none");
        else
          $(item).removeClass("d-none");
      });
    });
  </script>
@endpush
