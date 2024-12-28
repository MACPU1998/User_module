@php
    if(is_int($selectedItem))
        $selectedItem = [$selectedItem];
    else
        $selectedItem = !is_array($selectedItem)&& is_string($selectedItem) ? explode(",",$selectedItem) : $selectedItem;
@endphp

<div  class="{{$sectionClass}} pt-2">
    <label for="{{$id??$name}}" class="form-label">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <select id="{{$id??$name}}" name="{{$name}}" class="select2 form-select {{$class}}" data-allow-clear="{{$allowClear ? "true" : "false"}}" data-hide-search="{{$allowSearch ? "false" : "true"}}" {{$attributes}}>
        @if(isset($items) && $items)
                @foreach($items as $item)
                <option value="{{$item->value}}" @if(isset($selectedItem) && in_array($item->value,$selectedItem)) selected @endif>@if($translate=="true") {{__("$translateFile.$item->name")}} @else {{$item->name}} @endif</option>

                @endforeach
            @endif
      </select>
      <x-admin.form.error-validation :name="$name"/>
  </div>
