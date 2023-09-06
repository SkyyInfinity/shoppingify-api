<x-mail::message>
# Bienvenue {{ $user->username }} 🎉,

Merci de vous être inscrit sur {{ config('app.name') }}. Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse e-mail.

<x-mail::button :url="config('app.frontend_url') . '/auth/verify?id=' . $user->id . '&token=' . $token">
    Vérifier mon adresse e-mail
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
