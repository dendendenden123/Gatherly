<div class="input-group">
    <label for="{{ $id ?? ''}}">{{ $label ?? ''}}</label>
    <input type="{{ $type ?? ''}}" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" placeholder="{{ $placeholder }}"
        class="auth-input" value="{{ old($name ?? '') }}" required>
    @if($error)
        <div class="error-message">{{ $error ?? ''}}</div>
    @endif
</div>