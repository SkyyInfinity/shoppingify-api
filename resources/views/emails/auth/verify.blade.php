<x-mail::message>
# Bravo {{ $user->username }},

Votre adresse e-mail a été enregistrée avec succès, vous pouvez désormais vous connecter à votre compte.

<x-mail::button :url="route('home')">
    Accéder au site
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
