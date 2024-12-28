@unless (count($info)==0)
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        @foreach($info as $i)
            <li class="m-1 badge {{$i["styleClass"]}}">
                @if($i["label"]!=null)
                    {{ $i["label"] }} :
                @endif
                {{$i["value"]}}
            </li>
        @endforeach
    </ul>
@endunless
