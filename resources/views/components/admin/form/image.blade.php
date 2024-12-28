<div class="{{$sectionClass}} imageInputSection  pt-2">
<label class="form-label" for="">تصویر @if($required == "true") <span class="text-danger">*</span> @endif</label>
    <div class="d-flex align-items-start align-items-sm-center gap-4">
        @php
        $default_image = $value ?? asset('assets/img/avatars/default.jpg');
        @endphp
        <img src="{{$default_image}}" data-default-image="{{asset('assets/img/avatars/default.jpg')}}" alt="user-avatar" class="d-block rounded" height="100" width="100">
        <div class="button-wrapper">
          <label for="{{$id ?? $name}}" class="btn btn-primary me-2 mb-4" tabindex="0">
            <span class="d-none d-sm-block">ارسال تصویر جدید</span>
            <i class="bx bx-upload d-block d-sm-none"></i>
            <input type="file" id="{{$id ?? $name}}" name="{{$name}}" class="account-file-input {{$class}}" hidden {{$attributes}}>
          </label>
          <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
            <i class="bx bx-reset d-block d-sm-none"></i>
            <span class="d-none d-sm-block">بازنشانی</span>
          </button>

          <p class="mb-0">فایل‌های JPG، GIF یا PNG مجاز هستند. حداکثر اندازه فایل 800KB.</p>
        </div>
      </div>
      <x-admin.form.error-validation :name="$name"/>
</div>
