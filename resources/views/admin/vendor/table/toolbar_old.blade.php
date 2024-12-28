<div id="kt_app_toolbar_container" class="d-flex justify-content-end gap-2 gap-lg-3 toolbar_section me-5">
    @if($multiselect && count($multiselectButtons) > 0)

    <div class="me-0">


            <a href="#" class="btn btn-light btn_multiselect_operation me-2 menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="kt_user_follow_button">
                <i class="ki-duotone ki-abstract-29 fs-3">
                <span class="path1"></span>
                <span class="path2"></span>
                </i>
            <!--begin::Indicator label-->
            <span class="indicator-label">
            عملیات چندگانه</span>
            <!--end::Indicator label-->

            <!--begin::Indicator progress-->
            <span class="indicator-progress">
            Please wait...    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
            <!--end::Indicator progress-->
            </a>

            <!--begin::Menu 3-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" data-popper-placement="bottom-end" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-219px, 234px);">
            @foreach($multiselectButtons as $multiselectButton)
            {{-- @checkpermission($multiselectButton['permission']) --}}
            @if(isset($multiselectButtonsData[$multiselectButton['button_name']]) && $multiselectButtonsData[$multiselectButton['button_name']] && count($multiselectButtonsData[$multiselectButton['button_name']]) > 0)

                <div class="menu-item px-3 show menu-dropdown" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                    <a href="#" class="menu-link px-3">
                        {!!getIcon($multiselectButton['icon'])!!}
                        &nbsp;
                        <span class="menu-title">{{$multiselectButton['title']}}</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown w-175px py-4 show" style="z-index: 108; position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate(200px, -57px);" data-popper-placement="right-end">
                        @foreach($multiselectButtonsData[$multiselectButton['button_name']] as $data)
                        @php
                        $permission=isset($data['permission']) && $data['permission'] ? $data['permission'] : "#no-permission";
                        @endphp
                        @checkpermission($permission)
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">

                            <a data-button-name="{{$data['button_name']}}" class="menu-link px-3">
                                @if(isset($data["icon"]))
                                    {!!getIcon($data['icon'])!!}
                                @endif
                                &nbsp;
                                {{$data['title']}}
                            </a>
                        </div>
                        <!--end::Menu item-->
                        @endcheckpermission
                        @endforeach





                        {{-- <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator--> --}}


                    </div>
                    <!--end::Menu sub-->
                </div>

            @else
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                <a href="#" data-button-name="{{$multiselectButton['button_name']}}" class="menu-link px-3">
                    {{-- @if(isset($multiselectButton["icon"]))
                        {!!getIcon($multiselectButton["icon"],'fs-3')!!}
                    @endif --}}
                    &nbsp;
                {{$multiselectButton['title']}}
                </a>
                </div>
                <!--end::Menu item-->
            @endif
            {{-- @endcheckpermission --}}
            @endforeach


            </div>
            <!--end::Menu 3-->
    </div>

    @endif
    @foreach($toolbarButtons as $tool)
    @php
    $permission = $tool['permission'] ?? null;
    @endphp
    @checkHasPermission($permission)
        @if($tool["route"])
            <a class="btn {{$tool["class"]?:"btn-secondary"}} mr-1" href="{{$tool["route"]?:""}}"
            @foreach($tool["attributes"] as $key=>$value)
                {{$key."=".$value}}
            @endforeach
            >
                @if(isset($tool["icon"]))
                    <i class="{{$tool["icon"]}} fs-1"></i>
                @endif
                {{$tool["title"]}}
            </a>
        @else
            <button class="btn {{$tool["class"]?:"btn-secondary"}} mr-1" href="{{$tool["route"]?:""}}"
            @foreach($tool["attributes"] as $key=>$value)
                {{$key."=".$value}}
                @endforeach
            >

                {{$tool["title"]}}
            </button>
        @endif
    @endcheckHasPermission
    @endforeach

</div>

@foreach($multiselectButtons as $multiselectButton)

@push("scripts")
<script>
    @if(isset($multiselectButtonsData[$multiselectButton['button_name']]) && $multiselectButtonsData[$multiselectButton['button_name']] && count($multiselectButtonsData[$multiselectButton['button_name']]) > 0)
        @foreach($multiselectButtonsData[$multiselectButton['button_name']] as $data)
            $("[data-button-name='{{$data['button_name']}}']").on("click",function(){
                if($(".sub-select input:checked").length > 0)
                {
                    var dataObject = {
                        ids: []
                    };
                    $.each($(".sub-select input:checked"),function(index,item){
                        dataObject.ids.push($(item).parents("tr").data("id"));
                    });
                    var jsonData = JSON.stringify(dataObject);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        url : "{{ route($multiselectButton['route'],$data['value']) }}",
                        data : jsonData,
                        type : 'post',
                        success : function(result){
                            if(result.action_status == true)
                            {
                                location.reload(true);
                            }
                            else
                                toastr.error(result.message);

                        }
                    });
                }
                else
                {
                    toastr.error("{{__('message.no_exist_selected_item')}}");
                }

            });
        @endforeach
    @else
        $("[data-button-name='{{$multiselectButton['button_name']}}']").on("click",function(){
            if($(".sub-select input:checked").length > 0)
            {
                var dataObject = {
                    ids: []
                };
                $.each($(".sub-select input:checked"),function(index,item){
                    dataObject.ids.push($(item).parents("tr").data("id"));
                });
                var jsonData = JSON.stringify(dataObject);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    url : "{{ route($multiselectButton['route']) }}",
                    data : jsonData,
                    type : 'post',
                    success : function(result){
                        if(result.action_status == true)
                        {
                            location.reload(true);
                        }
                        else
                            toastr.error(result.message);

                    }
                });
            }
            else
            {
                toastr.error("{{__('message.no_exist_selected_item')}}");
            }

        });
    @endif

</script>
@endpush
@endforeach

