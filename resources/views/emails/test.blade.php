<x-mail::message>
# Titre du mail

Ceci est un exemple de mail, il a été envoyé par {{ $name }}

<x-mail::button :url="route('home')">
Accéder au site
</x-mail::button>

Merci de votre confiance,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
