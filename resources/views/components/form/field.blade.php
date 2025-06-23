<!-- requirements: form.css -->

@if ($type == 'select')
    <div class="input-group">
        <label for="{{ $id ?? ' '}}">{{ $label ?? ' '}}</label>
        <select id="{{ $id ?? ' ' }}" name="{{ $name ?? ' ' }}" class="auth-input" required>
            {{ $slot }}
        </select>
        @if($error)
            <div class="error-message">{{ $error ?? ' '}}</div>
        @endif
    </div>
@else
    <div class="input-group">
        <label>{{ $label ?? ''}}</label>
        <input type="{{ $type ?? ''}}" id="{{ $id ?? ' ' }}" name="{{ $name ?? ' ' }}"
            placeholder="{{ $placeholder ?? ' ' }}" class="auth-input" value="{{ old($name ?? ' ') }}" required>
        @if($error)
            <div class="error-message">{{ $error ?? ' '}}</div>
        @endif

    </div>
@endif