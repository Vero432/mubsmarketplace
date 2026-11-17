@extends('layouts.marketplace')

@section('title', 'Edit listing')

@section('content')

    <h1 class="text-2xl font-bold mb-4">Edit listing</h1>

    <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data"
          class="bg-white rounded shadow p-5 max-w-2xl space-y-4">
        @csrf
        {{-- HTML forms only send GET or POST, so we say "this is really a PUT" --}}
        @method('PUT')

        <div>
            <label class="block font-semibold mb-1">Title</label>
            {{-- old('title', $listing->title) = what the user typed, otherwise the saved value --}}
            <input type="text" name="title" value="{{ old('title', $listing->title) }}"
                   class="w-full border rounded px-3 py-2">
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $listing->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Price (UGX)</label>
            <input type="number" name="price" min="0" value="{{ old('price', $listing->price) }}"
                   class="w-full border rounded px-3 py-2">
            @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Condition</label>
            <select name="condition" class="w-full border rounded px-3 py-2">
                @foreach (['new', 'like new', 'used'] as $option)
                    <option value="{{ $option }}"
                        @selected(old('condition', $listing->condition) == $option)>
                        {{ ucfirst($option) }}
                    </option>
                @endforeach
            </select>
            @error('condition') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-3 py-2">{{ old('description', $listing->description) }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Photo</label>
            @if ($listing->image)
                <img src="{{ asset('uploads/' . $listing->image) }}" class="h-32 rounded mb-2" alt="Current photo">
                <p class="text-sm text-gray-500 mb-1">Choose a new photo only if you want to replace this one.</p>
            @endif
            <input type="file" name="image" accept="image/png, image/jpeg">
            @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded">Save changes</button>
            <a href="{{ route('listings.mine') }}" class="px-5 py-2 border rounded">Cancel</a>
        </div>
    </form>

@endsection