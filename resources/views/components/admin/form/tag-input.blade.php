<div class="{{$sectionClass}} pt-2">
    <label for="{{$id??$name}}" class="form-label">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <input id="{{$id??$name}}" class="tagifyElement form-control {{$class}}" name="{{$id??$name}}" value="{{old($name,$value)}}"  {{$attributes}}>
    <x-admin.form.error-validation :name="$name"/>
</div>


