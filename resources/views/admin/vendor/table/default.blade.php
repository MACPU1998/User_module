


    <div class="col-md-6 col-sm-12"></div>
    <div class="col-md-6 col-sm-12">
        <div class="d-flex justify-content-end my-2">
            @if(!is_null($toolbarButtons) && count($toolbarButtons) > 0)
            <div class="card-toolbar  mx-2">
                {!!  $toolbarSection !!}
            </div>
            @endif
            @if(!is_null($paginateSection))
                <div class="card-title">
                    {!!  $paginateSection !!}
                </div>
            @endif
        </div>
    </div>
    @if(!is_null($filterColumns) && count($filterColumns) > 0)
    <div class="accordion mt-3 accordion-header-primary  card my-1 no-padding">
        <div class="accordion-item  card">
            <h2 class="accordion-header d-flex align-items-center">
              <button type="button" class="accordion-button @if(!session()->has($tableName."_filter") || count(session($tableName.'_filter')) == 0) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-2" aria-expanded="false">
                <i class='bx bx-filter-alt me-2'></i>
                {{__('general.filter')}}
              </button>
            </h2>
            <div id="accordionWithIcon-2" class="accordion-collapse collapse @if(session()->has($tableName.'_filter') && count(session($tableName.'_filter')) > 0) show @endif" style="">
              <div class="accordion-body lh-2">
                <form action="{{route('filter_table',$tableName)}}" method="post">
                     @csrf
                    <div class="card-body py-1 row">
                        {!!  $filterSection !!}
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
    @endif




<!-- Striped Rows -->
<div class="card py-3">

        <div class="table-responsive-sm">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  @if($multiselect && $multiselectButtons && count($multiselectButtons))
                      <th>
                          <div class="form-check form-check-primary mt-3">
                              <input class="form-check-input select-all" type="checkbox" value="">
                          </div>
                      </th>
                  @endif
                  @foreach($columns as $column)
                  @if(!multi_dim($column))
                  <th class="{{$column['columnStyle']}}">
                      {!!$column['label']!!}
                      @if($column['sortable'] && !isset(session($tableName."_sort")[$column['column']]))
                      <a href="{{route('sort_table',[$tableName,$column['column']])}}"><i class='bx bx-sort-alt-2'></i></a>
                      @endif

                      @if(isset(session($tableName."_sort")[$column['column']]))
                          @if(session($tableName."_sort")[$column['column']] ==  "asc")
                          <a href="{{route('sort_table',[$tableName,$column['column']])}}"><i class='bx bx-sort-a-z'></i></a>

                          @else
                          <a href="{{route('sort_table',[$tableName,$column['column']])}}"><i class='bx bx-sort-z-a'></i></a>
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
                              {!!$sub_column['label']!!}
                              @if($sub_column['sortable'] && !isset(session($tableName."_sort")[$sub_column['column']]))
                                  <a role="button" href="{{route('sort_table',[$tableName,$sub_column['column']])}}"><i class='bx bx-sort-alt-2'></i></a>
                              @endif
                                  @if(isset(session($tableName."_sort")[$sub_column['column']]))
                                      @if(session($tableName."_sort")[$sub_column['column']] ==  "asc")
                                      <a role="button" href="{{route('sort_table',[$tableName,$sub_column['column']])}}"><i class='bx bx-sort-a-z'></i></a>

                                      @else
                                      <a role="button" href="{{route('sort_table',[$tableName,$sub_column['column']])}}"><i class='bx bx-sort-z-a'></i></a>
                                      @endif
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
              <tbody class="table-border-bottom-0">
                  @if($data->count() > 0)
                      @foreach($data as $row)
                      <tr data-id="{{$row->id}}">
                          @if($multiselect  && $multiselectButtons && count($multiselectButtons))
                              <th>
                                  <div class="form-check form-check-primary mt-3 sub-select">
                                      <input class="form-check-input" type="checkbox" value="">
                                  </div>
                              </th>
                          @endif

                      @foreach($columns as $column)
                      @if(!multi_dim($column))
                      @php
                          $row_key=$column['column'];
                          $row_rel=$column['relation'];
                      @endphp
                      <td class="{{$column['columnStyle']}}">
                          {!!DataTableBuilder::columnData($column['relation']?$row->$row_rel?->$row_key:$row->$row_key, $column['type'], $row)!!}
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
                    @php
                        if($multiselect && $multiselectButtons && count($multiselectButtons))
                          $colNum = count($columns) +1;
                          else
                          $colNum = count($columns)
                    @endphp
                    <tr>
                        <td colspan="{{$colNum}}" class="text-center">{{__("general.no_records")}}</td>
                    </tr>
                    @endif


              </tbody>
            </table>
          </div>

          <div class="mt-2">
            @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {!! $data->appends(request()->input())->links() !!}
            @endif

    </div>



  </div>
  <!--/ Striped Rows -->


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



    const dropdowns = document.querySelectorAll('.table-responsive .dropdown-toggle')
        const dropdown = [...dropdowns].map((dropdownToggleEl) => new bootstrap.Dropdown(dropdownToggleEl, {
            popperConfig(defaultBsPopperConfig) {
                return {
                    ...defaultBsPopperConfig,
                    strategy: 'fixed'
                };
            }
        }));
  </script>
@endpush

