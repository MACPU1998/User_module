@extends("admin.layout.master")
@section("page_title",__('general.edit_giftshop_product'))

@section("content")
<div class="card">
    <div class="card-body">
        <form method="post" action="{{ route('admin.app-settings.sliders.update',$model) }}" class="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <x-admin.form.text required="true" sectionClass="col-md-12" label="{{__('general.title')}}" required="true" name="title" value="{{$model->title}}"/>
                <x-admin.form.text-area required="true" sectionClass="col-md-12" label="{{__('general.link')}}" required="true" name="description" value="{{$model->link}}"/>
                <x-admin.form.file required sectionClass="col-md-6" label="{{__('general.picture')}}" name="media" preview="{{old('media')}}"/>
                <x-admin.form.select required="true" sectionClass="col-md-3" label="{{__('general.status')}}" :items="$status" required="true" name="status"/>

            </div>

            <x-admin.form.submit-buttons />
        </form>
        </div>
</div>
@push("scripts")
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.mediaDropzone = {
            url: '{{ route('admin.media.store') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="media[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="media[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($model) && $model->media)
                var files = {!! json_encode($model->media) !!};
                for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="media[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }
    </script>
@endpush

@endsection
