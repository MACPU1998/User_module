@extends("admin.layout.master")
@section("page_title",__('general.edit_order'))
@section("content")
<div class="card">
    <div class="card-body">
        <form method="post" action="{{ route('admin.sale_partners_management.orders.update',$model) }}" class="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <span class="text text-bg-gray" style="font-size: 16px !important;padding: 5px">{{__('general.order_code')}} {{$model->code}}</span>
                <x-admin.form.text readonly="" sectionClass="col-md-3" label="{{__('general.sale_partner')}}" value="{{$model->salepartner->first_name}} {{$model->salepartner->last_name}}"/>
                <x-admin.form.text readonly="" sectionClass="col-md-12" label="{{__('general.description')}}" value="{{$model->description}}"/>
                <table class="mt-5 table table-bordered table-hover table-responsive">
                    <thead>
                    <th>تصویر محصول</th>
                    <th>عنوان محصول</th>
                    <th>تعداد</th>
{{--                    <th>گزینه ها</th>--}}
                    </thead>
                    <tbody>
                    @foreach($model->goods as $i)
                        <tr>
                            <td>
                                <img class="image-preview" src="{{$i->good?->thumbnail_url}}" width="64" />
                            </td>
                            <td>
                                {{$i->good?->title}}
                            </td>
                            <td>
                                {{$i->quantity}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <x-admin.form.text sectionClass="col-md-9" name="comment" label="{{__('general.comment')}}" value="{{$model->comment}}"/>
                <x-admin.form.select sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" selectedItem="{{$model->status}}" required="true" name="status"/>
            </div>

            <x-admin.form.submit-buttons />
        </form>
        </div>
</div>
{{--@push("scripts")--}}
{{--    <script>--}}
{{--        var uploadedDocumentMap = {}--}}
{{--        Dropzone.options.mediaDropzone = {--}}
{{--            url: '{{ route('admin.media.store') }}',--}}
{{--            maxFilesize: 2, // MB--}}
{{--            addRemoveLinks: true,--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': "{{ csrf_token() }}"--}}
{{--            },--}}
{{--            success: function (file, response) {--}}
{{--                $('form').append('<input type="hidden" name="media[]" value="' + response.name + '">')--}}
{{--                uploadedDocumentMap[file.name] = response.name--}}
{{--            },--}}
{{--            removedfile: function (file) {--}}
{{--                file.previewElement.remove()--}}
{{--                var name = ''--}}
{{--                if (typeof file.file_name !== 'undefined') {--}}
{{--                    name = file.file_name--}}
{{--                } else {--}}
{{--                    name = uploadedDocumentMap[file.name]--}}
{{--                }--}}
{{--                $('form').find('input[name="media[]"][value="' + name + '"]').remove()--}}
{{--            },--}}
{{--            init: function () {--}}
{{--                @if(isset($model) && $model->media)--}}
{{--                var files = {!! json_encode($model->media) !!};--}}
{{--                for (var i in files) {--}}
{{--                    var file = files[i]--}}
{{--                    this.options.addedfile.call(this, file)--}}
{{--                    file.previewElement.classList.add('dz-complete')--}}
{{--                    $('form').append('<input type="hidden" name="media[]" value="' + file.file_name + '">')--}}
{{--                }--}}
{{--                @endif--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endpush--}}

@endsection
