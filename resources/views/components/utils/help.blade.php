@props(['text' => null])

@if ($text)
    <small class="form-text text-muted">{{ $text }}</small>
@endif