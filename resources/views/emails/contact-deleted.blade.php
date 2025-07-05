<x-mail::message>
# Contato Removido

O seguinte contato foi removido do sistema:

**Nome:** {{ $contact->name }}
**E-mail:** {{ $contact->email }}
**Telefone:** {{ $contact->phone }}

**Data da remoção:** {{ now()->format('d/m/Y H:i:s') }}
</x-mail::message>
