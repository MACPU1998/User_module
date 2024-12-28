@foreach($toolbarButtons as $tool)
@php
$permission = $tool['permission'] ?? null;
@endphp
    @checkHasPermission($permission)
    @if($tool["route"])
        <a class="btn btn_toolbar {{$tool["class"]?:"btn-secondary"}} mr-1" href="{{$tool["route"]?:""}}"
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
