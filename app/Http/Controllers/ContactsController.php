<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactsRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ContactsController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        
        $contacts = Contact::when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
            'filters' => request()->only(['search'])
        ]);
    }

    public function store(ContactsRequest $request): Response|RedirectResponse
    {
        $payload = $request->validated();
        $payload['phone'] = preg_replace('/\D/', '', $payload['phone']);

        $contactExists = Contact::where('email', $payload['email'])->withTrashed()->first();

        if ($contactExists) {
            $contactExists->restore();
            $contactExists->update($payload);
            return redirect()->route('contacts.index')->with('success', 'Contato restaurado com sucesso!');
        }

        Contact::create($payload);
        return redirect()->route('contacts.index')->with('success', 'Contato criado com sucesso!');
    }

    public function update(ContactsRequest $request, Contact $contact): Response|RedirectResponse
    {
        $payload = $request->validated();
        $payload['phone'] = preg_replace('/\D/', '', $payload['phone']);

        $contact->update($payload);

        return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contact $contact): Response|RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contato removido com sucesso!');
    }
}
