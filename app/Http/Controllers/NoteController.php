<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(): View
    {
        $notes = Note::forUser(auth()->user())
            ->active()
            ->latest()
            ->paginate(10);

        return view('notes.index', compact('notes'));
    }

    public function store(StoreNoteRequest $request): RedirectResponse
    {
        $request->user()
            ->notes()
            ->create($request->validated());

        return redirect()
            ->route('notes.index')
            ->with('success', 'Note created.');
    }

    public function update(UpdateNoteRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        return back()->with('success', 'Note updated.');
    }

    public function archive(Note $note): RedirectResponse
    {
        $this->authorize('archive', $note);

        $note->archive();

        return back()->with('success', 'Note archived.');
    }
}
