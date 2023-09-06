@component("mail::message")
#Welcome
{{$name}}
Thanks, <br>
    {{ config('app.name') }}
@endcomponent
