<div class="form-check form-switch">
    <input class="form-check-input toggle-switch" type="checkbox" id="toggleSwitch{{ $val->id }}"
        data-application-id="{{ $val->id }}" @if ($val->status == 1) checked @endif>
</div>
