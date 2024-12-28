<div class="{{$sectionClass}} pt-2">
    <div class="form-password-toggle">
        <label class="form-label" for="{{$id??$name}}">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>

        <div class="input-group input-group-merge">
            <input type="password" id="{{$id??$name}}" name="{{$name}}" value="{{$value}}" class="form-control text-start {{$class}}" aria-describedby="{{$id ?? $name}}" {{$attributes}}>
            <span class="input-group-text cursor-pointer" id="{{$id ?? $name}}"><i class="bx bx-hide"></i></span>
        </div>
        <x-admin.form.error-validation :name="$name"/>
    </div>
  </div>
