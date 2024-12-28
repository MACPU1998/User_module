<div class="form-repeater">
    <div data-repeater-list="file_repeat">
      <div data-repeater-item="">
        {{$slot}}
        <hr>
      </div>
    </div>
    <div class="mb-2">
      <button type="button" class="btn btn-primary" data-repeater-create="">
        <i class="bx bx-plus me-1"></i>
        <span class="align-middle">افزودن</span>
      </button>
    </div>
</div>
