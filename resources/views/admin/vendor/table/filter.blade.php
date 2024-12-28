@foreach($filterColumns as $filterColumn)

    <div class="{{$filterColumn['class']}} @if(in_array($filterColumn['elementType'],["range:text","range:select","range:date","range:numeric"])) d-flex flex-column @endif">

        @if($filterColumn['elementType'] == 'text' || $filterColumn['elementType'] == 'numeric')
            <label class="form-label">{{__("general.".str_replace("filter_","",$filterColumn['elementName']))}}</label>
            <input class="form-control @if($filterColumn['elementType'] == 'numeric') numeric @endif" type="text" name="{{$filterColumn['elementName']}}" id="{{$filterColumn['elementName']}}" value="{{isset(session($tableName.'_filter')[$filterColumn['elementName']]) ? session($tableName.'_filter')[$filterColumn['elementName']] : null}}">

        @elseif($filterColumn['elementType'] == 'select' || strpos($filterColumn['elementType'],"select:") !== false)
            <label class="form-label">{{__("general.".str_replace("filter_","",$filterColumn['elementName']))}}</label>
            <select class="select2 form-select" data-allow-clear="true" data-placeholder="{{__("general.".str_replace("filter_","",$filterColumn['elementName']))}}" name="{{$filterColumn['elementName']}}"  id="{{$filterColumn['elementName']}}">
                <option value="">{{__("general.".str_replace("filter_","",$filterColumn['elementName']))}}</option>
                @if(isset($filterColumn['data']))
                    @foreach($filterColumn['data'] as $data)
                    <option value="{{$data->value}}" {{(isset(session($tableName.'_filter')[$filterColumn['elementName']]) && (session($tableName.'_filter')[$filterColumn['elementName']] == $data->value)) ? "selected=selected" : "" }}>{{$data->name}}</option>
                    @endforeach
                @endif
            </select>

        @elseif(in_array($filterColumn['elementType'],["range:text","range:select","range:date","range:numeric"]))
            @php
                $elementType=explode(":",$filterColumn['elementType'])[1];
                $originalName=str_replace(["filter_from_","filter_to_"],"",$filterColumn['elementName'][0]);
            @endphp
            <label class="form-label">{{__("general.".$originalName)}}</label>

            <div class="d-flex">
                <div class="col-md-5">
                    @if($elementType == "text" || $elementType == "numeric" )
                        <input type="text" class="form-control @if($elementType == 'numeric') numeric @endif" name="{{$filterColumn['elementName'][0]}}" value="{{isset(session($tableName.'_filter')[$filterColumn['elementName'][0]]) ? session($tableName.'_filter')[$filterColumn['elementName'][0]] : null}}">
                    @elseif($elementType == "select")

                        <select class="select2 form-select"  data-allow-clear="true" data-placeholder="" name="{{$filterColumn['elementName'][0]}}"  id="{{$filterColumn['elementName'][0]}}">
                            <option value=""></option>

                            @foreach($filterColumn['data'] as $data)
                            <option value="{{$data->value}}" {{(isset(session($tableName.'_filter')[$filterColumn['elementName'][0]]) && (session($tableName.'_filter')[$filterColumn['elementName'][0]] == $data->value)) ? "selected=selected" : "" }}>{{__("general.".$data->name)}}</option>
                            @endforeach
                        </select>
                    @elseif($elementType == "date")
                        <input type="text" class="form-control flatpickr-date dir-ltr text-right" name="filterdate_{{$filterColumn['elementName'][0]}}" value="{{isset(session($tableName.'_filter')[$filterColumn['elementName'][0]]) ? dateValue(session($tableName.'_filter')[$filterColumn['elementName'][0]]) : null}}">
                    @endif
                </div>
                <div class="col-md-1 d-flex flex-column align-items-center justify-content-between pt-3">تا</div>
                <div class="col-md-5">
                    @if($elementType == "text" || $elementType == "numeric" )
                        <input type="text" class="form-control @if($elementType == 'numeric') numeric @endif" name="{{$filterColumn['elementName'][1]}}" value="{{isset(session($tableName.'_filter')[$filterColumn['elementName'][1]]) ? session($tableName.'_filter')[$filterColumn['elementName'][1]] : null}}">
                    @elseif($elementType == "select")
                        <select class="select2 form-select"  data-allow-clear="true" data-placeholder="" name="{{$filterColumn['elementName'][1]}}"  id="{{$filterColumn['elementName'][1]}}">
                            <option value=""></option>
                            @foreach($filterColumn['data'] as $data)
                            <option value="{{$data->value}}" {{(isset(session($tableName.'_filter')[$filterColumn['elementName'][1]]) && (session($tableName.'_filter')[$filterColumn['elementName'][1]] == $data->value)) ? "selected=selected" : "" }}>{{__("general.".$data->name)}}</option>
                            @endforeach
                        </select>
                    @elseif($elementType == "date")
                        <input type="text" class="form-control flatpickr-date dir-ltr text-right" name="filterdate_{{$filterColumn['elementName'][1]}}" value="{{isset(session($tableName.'_filter')[$filterColumn['elementName'][1]]) ? dateValue(session($tableName.'_filter')[$filterColumn['elementName'][1]]) : null}}">
                    @endif
                </div>
            </div>





        @endif

    </div>
    @if(strpos($filterColumn['elementType'],"select:")!==false)
        @php
        if(!isset(session("params")['id']))
            session()->push('params', "id");
        @endphp
        @php
            $dependet=explode(":",$filterColumn['elementType'])[1];
            list($dependent_select,$route_name)=explode("|",$dependet);
        @endphp
        @push('scripts')
            <script>
                $("[name='{{$dependent_select}}']").change(function()
                {
                    var id=$(this).val();
                    var selectedItem="{{isset(session($tableName.'_filter')[$filterColumn['elementName']]) ? session($tableName.'_filter')[$filterColumn['elementName']] : null}}";
                    $("[name='{{$filterColumn['elementName']}}']").html();
                    if(id)
                    {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : "{{ route($route_name) }}",
                            data : {"id":id,"targetElementName":"{{$filterColumn['elementName']}}","selectedItem":selectedItem},
                            type : 'post',
                            dataType : 'json',
                            success : function(result){
                                var options="<option></option>";
                                $.each(result,function(key,item){
                                    var selected="";
                                    if(item.selected == true)
                                        selected= "selected";
                                    else
                                        selected= "";
                                    options+="<option value='"+item.hashid+"' "+selected+">"+item.name+"</option>";
                                });
                                $("[name='{{$filterColumn['elementName']}}']").html(options).trigger("change");

                            }
                        });
                    }

                });
            </script>
        @endpush
    @endif


    @if(session()->has($tableName.'_filter') && !in_array($filterColumn['elementType'],["range:text","range:select","range:date","range:numeric"]) && isset(session($tableName.'_filter')[$filterColumn['elementName']]))
        @push("scripts")
            <script>
                $(function(){
                    @if(strpos($filterColumn['elementType'],"select:")!==false)
                    $("[name='{{$dependent_select}}']").trigger("change");
                    @endif
                    $("[name='{{$filterColumn['elementName']}}']").trigger("change");
                });

            </script>
        @endpush
    @endif

@if($filterColumn['elementType'] == "range:date")
@push('scripts')
    <script>
        $(function(){
        var flatpickrDates = $(".flatpickr-date")
        $.each(flatpickrDates,function(index,item){
            $(item).flatpickr({
              monthSelectorType: 'static',
              locale: 'fa',
              altInput: true,
              altFormat: 'Y/m/d',
              disableMobile: true
            });
        })

    });
    </script>
@endpush
@endif

@endforeach


    <div class="col-md-12 pt-2 p-0 d-flex flex-row-reverse">
        <button type="submit" class="btn rounded-pill btn-label-primary">
            <span class="tf-icons bx bx-search-alt-2 me-1"></span>{{__("general.filter")}}
          </button>
        @if(session()->has($tableName.'_filter') && count(session($tableName.'_filter')) > 0)

        <a href="{{route('remove_filter',$tableName)}}" class="btn rounded-pill btn-label-secondary me-1"><span class="tf-icons bx bx-pause-circle me-1"></span>{{__("general.remove_filter")}}</a>
        @endif
    </div>




<div class="range-from-example"></div>
<div class="range-to-example"></div>



