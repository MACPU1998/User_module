<div class="{{$sectionClass}} pt-2">
    <label class="form-label">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <div class="mt-2">
        @if(isset($items) && $items)
            @foreach($items as $key=>$item)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{$name}}" id="{{$name.$key}}" value="{{$item->value}}" @if($selectedItem == $item->value) checked @endif>
                <label class="form-check-label" for="{{$name.$key}}">{{$item->name}}</label>
            </div>
            @endforeach
            {{-- <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled="">
                <label class="form-check-label" for="inlineRadio3">3 (غیرفعال)</label>
            </div> --}}
        @endif
    </div>
    <x-admin.form.error-validation :name="$name"/>

  </div>
