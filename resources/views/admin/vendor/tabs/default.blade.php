<div class="card tab-section">
    <div class="card-header card-header-stretch">
        <h3 class="card-title"></h3>
        <div class="card-toolbar w-100">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                @foreach($tabs as $tab)
                    @checkpermission($tab["permission"])
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{($selectedTab!=null&&$selectedTab==$tab["id"])?"active":($selectedTab==null&&$loop->first?"active":"")}}" href="?selectedTab={{$tab["id"]}}">{{$tab["title"]}}</a>
                    </li>
                    @endcheckpermission
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            @if(isset($view)&&$view!=null)
                <div class="tab-pane fade show active" role="tabpanel">
                    @include($view)
                </div>
            @else
                <div class="tab-pane fade show active" id="{{$tab["id"]}}" role="tabpanel">
                    @include($tabs[0]["view"])
                </div>
            @endif
{{--            @foreach($tabs as $tab)--}}
{{--                <div class="tab-pane fade show {{$loop->iteration==1?"active":""}}" id="tab{{$loop->iteration}}" role="tabpanel">--}}
{{--                    @include($tab["view"])--}}
{{--                </div>--}}
{{--            @endforeach--}}
        </div>
    </div>
</div>

