@component('mail::message')
# {{ $notification->title }}

{{ $notification->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent 