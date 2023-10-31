<x-mail::message>
Hello, {{ $first_name }}.<br>

    Your password: {{ $password }}

Thanks for registration,<br>
{{ config('app.name') }}
</x-mail::message>
