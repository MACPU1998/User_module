@push("styles")
<style>
    .dz-image img {
        width: 100%; /* تنظیم عرض به اندازه کامل */
        height: auto; /* حفظ نسبت تصویر */
        object-fit: contain; /* تصویر به طور کامل در باکس قرار می‌گیرد */
    }
    .dropzone
    {
        border: 2px dashed gray;
    }
    .dz-button
    {
        background: no-repeat;
        border: none;
        color: inherit;
    }
</style>
@endpush
<div class="{{$sectionClass}} pt-2">
    <div class="form-group">
        <label class="form-label" for="{{$id??$name}}">{{$label}} @if($required == "true") <span class="text-danger">*</span> @endif</label>
        <div class="needsclick dropzone" id="{{$id??$name}}">

        </div>
    </div>
    <x-admin.form.error-validation :name="$name"/>
</div>
@php
    if(is_string($allowFileExtensions))
    {
        $allowFileExtensions = explode(",",$allowFileExtensions);
        $allowFileExtensions = array_map(function($item){
            return ".".$item;
        },$allowFileExtensions);
        $allowFileExtensions = implode(",",$allowFileExtensions);
    }
    elseif(is_array($allowFileExtensions)) {
        $allowFileExtensions = array_map(function($item){
            return ".".$item;
        },$allowFileExtensions);
        $allowFileExtensions = implode(",",$allowFileExtensions);
    }
    else {
        throw new Exception("allow file extensions must be array or string!", 1);

    }
@endphp
@push("scripts")
<script>
    const previewTemplate{{$id}} = `<div class="dz-preview dz-file-preview">
    <div class="dz-details">
    <div class="dz-thumbnail">
        <img data-dz-thumbnail>
        <span class="dz-nopreview">No preview</span>
        <div class="dz-success-mark"></div>
        <div class="dz-error-mark"></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="progress">
        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
        </div>
    </div>
    <div class="dz-filename" data-dz-name></div>
    <div class="dz-size" data-dz-size></div>
    </div>
    </div>`;
    var uploaded{{$id}}Map = {}
    Dropzone.options.{{$id}} = {
    dictDefaultMessage: "فایل‌ها را اینجا بکشید و رها کنید",
    dictFallbackMessage: "مرورگر شما از بارگذاری فایل‌ها پشتیبانی نمی‌کند.",
    dictFallbackText: "لطفاً از فرم زیر برای بارگذاری فایل‌ها استفاده کنید.",
    dictFileTooBig: "فایل خیلی بزرگ است (@{{filesize}}MB). حداکثر اندازه: @{{maxFilesize}}MB.",
    dictInvalidFileType: "شما نمی‌توانید فایل‌هایی از این نوع بارگذاری کنید.",
    dictResponseError: "سرور با کد @{{statusCode}} پاسخ داد.",
    dictCancelUpload: "لغو بارگذاری",
    dictCancelUploadConfirmation: "آیا مطمئن هستید که می‌خواهید این بارگذاری را لغو کنید؟",
    dictRemoveFile: "حذف فایل",
    dictMaxFilesExceeded: "شما نمی‌توانید فایل‌های بیشتری بارگذاری کنید.",
    url: '{{$storeUrl}}',
    previewTemplate:  previewTemplate{{$id}},
    maxFilesize: {{$maxFileSize}}, // MB
    acceptedFiles: "{{$allowFileExtensions}}",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
        $("#{{$id??$name}}").parents('form').append('<input type="hidden" name="{{$name}}[]" value="' + response.name + '">')
        uploaded{{$id}}Map[file.name] = response.name
    },
    removedfile: function (file) {
        file.previewElement.remove()
        var name{{$id}} = ''
        if (typeof file.file_name !== 'undefined') {
            name{{$id}} = file.file_name
        } else {
            name{{$id}} = uploaded{{$id}}Map[file.name]
        }
        $("#{{$id??$name}}").parents('form').find('input[name="{{$name}}[]"][value="' + name{{$id}} + '"]').remove()
        checkDisplayDzMessage()
    },
    init: function () {
        @if(isset($value) && $value)
            var files{{$id}} = @json($value);
            for (var i in files{{$id}}) {
                var file{{$id}} = files{{$id}}[i]
                file{{$id}}.url = file{{$id}}.original_url
                this.options.addedfile.call(this, file{{$id}})
                this.options.thumbnail.call(this, file{{$id}}, file{{$id}}.url);
                file{{$id}}.previewElement.classList.add('dz-complete')
                $("#{{$id??$name}}").parents('form').append('<input type="hidden" name="{{$name}}[]" value="' + file{{$id}}.file_name + '">')
            }
        @endif

        this.on("complete", function(file) {
            checkDisplayDzMessage()
        });

    },
}

function checkDisplayDzMessage()
{
    if($("#{{$id??$name}} .dz-preview").length  <  1)
        $(".dz-message").show();
        else
        $(".dz-message").hide();
}
  </script>
@endpush
