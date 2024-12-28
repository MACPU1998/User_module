<div class="{{$sectionClass}} pt-2">
    <label class="form-label" for="{{$id??$name}}">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <input type="file" id="thumbnail input-file-now" data-default-file="{{$defaultData}}" value="{{$defaultData}}" name="{{$name}}" class="dropify" data-allowed-file-extensions="{{$ext}}"/>
    <x-admin.form.error-validation :name="$name"/>
  </div>
