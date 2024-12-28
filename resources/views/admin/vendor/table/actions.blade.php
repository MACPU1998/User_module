<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
      <i class="bx bx-dots-vertical-rounded"></i>
    </button>
    <div class="dropdown-menu">
        @foreach($buttons as $key=>$value)
            @php
            if ($value['type'] == "link")
            {
                $url = $value['route'];
                $url= str_replace(URL::to('/'),"",$value['route']);
                $permission=getRoutNameOfUrl($url);

            }
            else {
                $permission = $value['permission'] ?? null;
            }
            @endphp


            @php
              $attributes="";
              $class="";
              $tooltip="";
              if(isset($value['attributes']))
              {
                foreach($value['attributes'] as $attribute_id=>$attribute_value)
                $attributes .=" ".$attribute_id."=".$attribute_value;
              }
              if(isset($value['class']))
                $class=(is_array($value['class'])) ? implode(" ",$value['class']) : $value['class'];
              if(isset($value['tooltip']) && $value['tooltip']!=null)
                $tooltip=$value['tooltip'];
            @endphp

            @checkHasPermission($permission)
            @if($value['type'] == "link" || $value['type'] == "tab")
                <a href="{{$value['route']}}" class="dropdown-item {{$class}}" {{$attributes}}>{{$value['title']}}</a>
            @elseif($value['type'] == "button")
                <a href="#" class="dropdown-item {{$class}}" {{$attributes}}>{{$value['title']}}</a>
            @elseif($value['type'] == "delete")
                <form class="tg_remove_form" action="{{$value['route']}}" method="POST">
                    @csrf
                    @method("delete")
                    <input type="hidden" name="model_id" value="{{$value['row_id']}}">
                    @if(isset($tooltip))
                    <div class="tooltip-wrapper" data-bs-toggle=tooltip title="{{$tooltip}}">
                        <button class="dropdown-item btn_remove {{$class}}" {{$attributes}}>{{$value['title']}}</button>
                    </div>
                    @else
                        <button class="dropdown-item btn_remove {{$class}}" {{$attributes}}>{{$value['title']}}</button>
                    @endif
                </form>
            @elseif($value['type'] == "ajax")
                <form class="ajax_form" action="{{$value['route']}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$value['row_id']}}">
                    @if(isset($tooltip))
                    <div class="tooltip-wrapper" data-bs-toggle=tooltip title="{{$tooltip}}">
                        <button class="dropdown-item btn_submit {{$class}}" {{$attributes}}>{{$value['title']}}</button>
                    </div>
                    @else
                        <button class="dropdown-item btn_submit {{$class}}" {{$attributes}}>{{$value['title']}}</button>
                    @endif
                </form>
            @endif
            @endcheckHasPermission
        @endforeach

    </div>
  </div>
