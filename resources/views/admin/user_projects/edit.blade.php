@extends("admin.layout.master")
@section("page_title",__('general.edit_giftshop_product'))
{{-- @section("breadcrumbs")
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol>
@endsection --}}
@section("content")
<div class="card">
    <div class="card-body">
            <form method="post" action="{{ route('user.users_management.user_projects.update',[$model->id]) }}" class="form" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <span class="text text-bg-gray" style="font-size: 16px !important;padding: 5px">{{__('general.project_code')}} {{$model->code}}</span>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.client_name')}}" value="{{$model->client_first_name}} {{$model->client_last_name}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.client_national_code')}}" value="{{$model->client_national_code}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.province')}}" value="{{$model->province_name}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.city')}}" value="{{$model->city_name}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.client_phone')}}" value="{{$model->client_phone}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-6" label="{{__('general.client_address')}}" value="{{$model->client_address}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.client_zipcode')}}" value="{{$model->client_zipcode}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.user_name')}}" value="{{$model->user->first_name}} {{$model->user->last_name}}"/>
                    <x-admin.form.text readonly="" sectionClass="col-md-12" label="{{__('general.description')}}" value="{{$model->description}}"/>
                    <hr/>
                    <table class="table table-borderless table-hover table-responsive">
                        <thead>
                            <th>سریال محصول</th>
                            <th>عنوان</th>
                            <th>وضعیت</th>
                            <th>گزینه ها</th>
                        </thead>
                        <tbody>
                        @foreach($model->items as $i)
                            <tr>
                                <td>
                                    {{$i->serial}}
                                </td>
                                <td>
                                    {{$i->title}}
                                </td>
                                <td>
                                    @if($i->status == 1)
                                        <span class="badge bg-label-warning">در انتظار استعلام</span>
                                    @elseif($i->status == 2)
                                        <span class="badge bg-label-success">تایید استعلام</span>
                                    @elseif($i->status == 3)
                                        <span class="badge bg-label-danger">استعلام رد شد</span>
                                    @elseif($i->status == 4)
                                        <span class="badge bg-label-danger">محصول تکراری</span>
                                    @endif
                                </td>
                                @checkHasPermission("user.users_management.project.edit.item")
                                <td>
                                    @if($i->status == 1)
                                        <a data-bs-target="" class="btn btn-icon btn-sm btn-edit-serial" data-id="{{$i->id}}" data-serial="{{$i->serial}}"><i class="fa fa-file-edit"></i></a>
                                    @elseif($i->status == 2)
                                        <a class="btn btn-icon btn-sm btn-edit-serial" data-id="{{$i->id}}" data-serial="{{$i->serial}}"><i class="fa fa-file-edit"></i></a>
                                    @elseif($i->status == 3)
                                        <a class="btn btn-icon btn-sm btn-edit-serial" data-id="{{$i->id}}" data-serial="{{$i->serial}}"><i class="fa fa-file-edit"></i></a>
                                    @elseif($i->status == 4)
                                        <a class="btn btn-icon btn-sm btn-edit-serial" data-id="{{$i->id}}" data-serial="{{$i->serial}}"><i class="fa fa-file-edit"></i></a>z
                                    @endif
                                </td>
                                @endcheckHasPermission()
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @checkHasPermission("user.users_management.project.inquery")
                    @if($model->status!=2)
                        <div class="col-md-3">
                            <a class="btn btn-sm btn-warning" href="{{route("user.users_management.project.inquery")}}">استعلام فوری</a>
                        </div>
                    @endif
                    @endcheckHasPermission()
                    <hr/>
                    <div class="gallery-thumbs">
                        <a href="{{route("admin.getFile",["userprojects",$model->picture1])}}" target="_blank"><img class="image-preview" width="128" src="{{route("admin.getFile",["userprojects",$model->picture1])}}" /></a>
                        <a href="{{route("admin.getFile",["userprojects",$model->picture2])}}" target="_blank"><img class="image-preview" width="128" src="{{route("admin.getFile",["userprojects",$model->picture2])}}" /></a>
                        <a href="{{route("admin.getFile",["userprojects",$model->picture3])}}" target="_blank"><img class="image-preview" width="128" src="{{route("admin.getFile",["userprojects",$model->picture3])}}" /></a>
                        @if($model->picture4)
                            <a href="{{route("admin.getFile",["userprojects",$model->picture4])}}" target="_blank"><img class="image-preview" width="128" src="{{route("admin.getFile",["userprojects",$model->picture4])}}" /></a>
                        @endif
                        @if($model->picture5)
                            <a href="{{route("admin.getFile",["userprojects",$model->picture5])}}" target="_blank"><img class="image-preview" width="128" src="{{route("admin.getFile",["userprojects",$model->picture5])}}" /></a>
                        @endif
                    </div>
                    <x-admin.form.text sectionClass="col-md-9" name="comment" label="{{__('general.comment')}}" value="{{$model->comment}}"/>
                    <x-admin.form.select sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" selectedItem="{{$model->status}}" required="true" name="status"/>
                </div>

                <x-admin.form.submit-buttons />
            </form>
        </div>
</div>

<!-- Modal -->
<div id="editItemModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ویرایش سریال</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>
                        سریال محصول
                    </label>
                    <input class="serial-number" name="serial" value=""/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">لغو</button>
                <button type="button" class="btn btn-outline-success edit-btn">ثبت</button>
            </div>
        </div>

    </div>
</div>
@push("scripts")
    <script>
        $(document).ready(function (){
            var id = $(this).attr("data-id");
           $(".btn-edit-serial").on("click", function (e){
               e.preventDefault();
               var value = $(this).attr("data-serial");
               id = $(this).attr("data-id");

               $("#editItemModal .serial-number").val(value);
               $("#editItemModal").modal("show");
           })

            $("#editItemModal .edit-btn").on("click", function (e){
                e.preventDefault();
                var serial = $("#editItemModal .serial-number").val();

                $.post('{{route("user.users_management.project.edit.item")}}',
                    {_token: "{{ csrf_token() }}", serial_number: serial, item_id: id},
                    function(result){
                    if(result.success)
                        window.location.reload();
                    else{
                        toastr.error(result.message);
                        console.log(result);
                    }

                });
            })

        });
    </script>
@endpush

@endsection
