@extends('layouts.marketplace')

@section('title', 'Post an item')

@section('content')

    <h1 class="text-2xl font-bold mb-4">Post an item</h1>

    {{-- enctype is REQUIRED, or the photo will not be sent --}}
    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data"
          class="bg-white rounded shadow p-5 max-w-2xl space-y-4">

        {{-- security token. Laravel rejects the form without it --}}
        @csrf

        {{-- Title --}}
        <div>
            <label class="block font-semibold mb-1">Title</label>
            {{-- old('title') puts back what the user typed if validation failed --}}
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border rounded px-3 py-2">
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Category --}}
        <div>
            <label class="block font-semibold mb-1">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Price --}}
        <div>
            <label class="block font-semibold mb-1">Price (UGX)</label>
            <input type="number" name="price" value="{{ old('price') }}" min="0"
                   class="w-full border rounded px-3 py-2">
            @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Condition --}}
        <div>
            <label class="block font-semibold mb-1">Condition</label>
            <select name="condition" class="w-full border rounded px-3 py-2">
                {{-- old('condition', 'used') means: use "used" if nothing was chosen yet --}}
                @foreach (['new', 'like new', 'used'] as $option)
                    <option value="{{ $option }}" @selected(old('condition', 'used') == $option)>
                        {{ ucfirst($option) }}
                    </option>
                @endforeach
            </select>
            @error('condition') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block font-semibold mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Photo (optional) --}}
        <div>
            <label class="block font-semibold mb-1">Photo (optional, JPG or PNG, up to 4 MB)</label>
            <input type="file" name="image" accept="image/png, image/jpeg">
            @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded">Post item</button>
            <a href="{{ route('listings.index') }}" class="px-5 py-2 border rounded">Cancel</a>
        </div>
    </form>

@endsection