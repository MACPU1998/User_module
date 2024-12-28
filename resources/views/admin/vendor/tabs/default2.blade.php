<div class="card tab-section">
    <div class="card-header card-header-stretch">
        <h3 class="card-title"></h3>
        <div class="card-toolbar w-100">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                @foreach($tabs as $key=>$value)
                    @if($value["active"])
                    <li class="nav-item">
                        @php
                            $params = [];
                        foreach($value["parameters"] as $p){
                            !isset($p) ? "Invalid parameter":$params[$p]=encryptValue($$p,$p);
                        }

                        @endphp
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{($selectedTab!=null&&$selectedTab==$key)?"active":($selectedTab==null&&$loop->first?"active":"")}}" href="{{route($value["routeName"],$params)}}">{{$value["title"]}}</a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

