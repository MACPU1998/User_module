<div class="{{$sectionClass}} pt-2">
    <label class="form-label" for="{{$id??$name}}">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <input type="file" id="{{$id??$name}}" name="{{$name}}" value="{{$value}}" class="form-control text-start {{$class}}" {{$attributes}}>

         @if($preview)
        <hr/>

        <a target="_blank" href="{{getFile($preview)}}">{{__("general.download")}}</a>
        @endif
    <x-admin.form.error-validation :name="$name"/>
  </div>
