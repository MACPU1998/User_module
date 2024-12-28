<div class="{{$sectionClass}} pt-2">
    <label class="form-label" for="{{$id??$name}}">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <textarea class="editor form-control {{$class}}" id="{{$id??$name}}" name="{{$name}}" rows="3" {{$attributes}}>{{$value}}</textarea>
    <x-admin.form.error-validation :name="$name"/>
</div>
