@extends("admin.layout.master")
@section("page_title",getPageTitle())
@section("content")

<div class="card mb-4">
    <h5 class="card-header heading-color">{{getPageTitle()}}</h5>
    <form class="card-body" method="POST" action="{{route('admin.admins_management.role.permissions.update',$role->id)}}" enctype="multipart/form-data">
        @csrf
      <div class="row ">

        @foreach ($permissions as $key=>$permission)
            <div class="accordion-item card active mt-5">
                <div class="d-flex">
                    <span class="form-check form-check-primary">
                        <input class="form-check-input parent-checkbox" data-group="{{$permission['name']}}" type="checkbox" value="">
                    </span>
                    <h2 class="accordion-header">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionStyle{{$key}}" aria-expanded="true">
                        {{__("permissions.".$permission['slug'])}}
                    </button>
                    </h2>
                </div>


                <hr>

                <div id="accordionStyle{{$key}}" class="accordion-collapse collapse show"  style="">
                    <div class="accordion-body lh-2">
                        <div class="row permissions-section">
                            @foreach ($permission['children'] as $permission_child)
                                <div class="col-md-3 col-sm-6">
                                    <div class="d-flex">
                                        <span class="form-check form-check-primary">
                                            <input name="permission[]" id="{{$permission_child['slug']}}{{$key}}" class="form-check-input permission-checkbox" data-group="{{$permission['name']}}" type="checkbox" value="{{$permission_child['name']}}" @if(in_array($permission_child['name'],$role_permissions)) checked @endif>
                                        </span>
                                        <label for="{{$permission_child['slug']}}{{$key}}">{{__("permissions.".$permission_child['slug'])}}</label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @endforeach


      </div>

      <x-admin.form.submit-buttons />

    </form>
  </div>

  @push("scripts")
    <script>

    function checkedStatus(el)
    {
        var unchecked_count = $(el).parents(".permissions-section").find(".permission-checkbox").length;
        var checked_count = $(el).parents(".permissions-section").find(".permission-checkbox:checked").length;

        if(unchecked_count == checked_count)
            $(el).parents(".accordion-item").find(".parent-checkbox").prop("checked",true)
        else
            $(el).parents(".accordion-item").find(".parent-checkbox").prop("checked",false)
    }
    $(".parent-checkbox").on("click",function(){
        // var group = $(this).data("gorup")
        if($(this).is(":checked"))
            $(this).parents(".accordion-item").find(".permission-checkbox").prop("checked",true);
        else
            $(this).parents(".accordion-item").find(".permission-checkbox").prop("checked",false);
    })

    $(".permission-checkbox").on("click",function(){
        checkedStatus(this)
    })

    $(function(){
        $(".parent-checkbox").each(function()
        {
            checkedStatus($(this).parents(".card").find(".permissions-section .permission-checkbox"))
        })
    })

    </script>
  @endpush


@endsection
