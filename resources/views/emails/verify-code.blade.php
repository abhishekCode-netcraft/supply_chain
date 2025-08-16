<x-mail::message>
# Hello {{ $user->name }},

Thank you for registering on **{{ config('app.name') }}**.

Please click the button below to verify your email address:

<x-mail::button :url="route('verify.email', ['code' => $user->email_verification_code])">
Verify Email
</x-mail::button>

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
