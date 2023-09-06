<x-mail::message>
# C'est tout bon {{ $user->username }} ✅,

Votre adresse e-mail a été enregistrée avec succès, vous pouvez désormais vous connecter à votre compte.

<x-mail::button :url="config('app.frontend_url')">
    Accéder au site
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
