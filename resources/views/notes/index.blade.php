<x-layouts.app>
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Create note --}}
        <form method="POST" action="{{ route('notes.store') }}" class="bg-white p-4 rounded shadow space-y-3">
            @csrf

            <div>
                <input type="text" name="title" placeholder="Note title" value="{{ old('title') }}"
                    class="w-full border rounded px-3 py-2">
                @error('title')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <textarea name="body" placeholder="Optional note content" class="w-full border rounded px-3 py-2">{{ old('body') }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Add note
            </button>
        </form>

        {{-- Notes list --}}
        <div class="space-y-4">
            @forelse ($notes as $note)
                <div class="bg-white p-4 rounded shadow space-y-3">

                    {{-- Update --}}
                    <form method="POST" action="{{ route('notes.update', $note) }}" class="space-y-2">
                        @csrf
                        @method('PATCH')

                        <input type="text" name="title" value="{{ $note->title }}"
                            class="w-full border rounded px-3 py-2">

                        <textarea name="body" class="w-full border rounded px-3 py-2">{{ $note->body }}</textarea>

                        <button type="submit" class="text-sm text-blue-600 hover:underline active:font-bold">
                            Save
                        </button>
                    </form>

                    {{-- Archive --}}
                    <form method="POST" action="{{ route('notes.archive', $note) }}">
                        @csrf

                        <button type="submit" class="text-sm text-gray-600 hover:underline active:font-bold">
                            Archive
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-600">No notes yet.</p>
            @endforelse
        </div>

        {{ $notes->links() }}

    </div>
</x-layouts.app>
