<!-- Sidebar Filters -->
<div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
    <h3 class="text-2xl font-medium text-gray-800 tracking-widest mb-2">Categorías</h3>
    <ul class="space-y-4">
        @foreach ($categories as $category)
        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
            <a href="{{ route('category.show', $category->slug) }}" class="flex items-center w-full">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                    <img src="{{ asset($category->icon_url) }}" alt="{{ $category->name }}" class="w-6 h-6" loading="lazy">
                </div>
                <span class="ml-3 font-medium">{{ $category->name }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>

{{-- {{ route('category.show', $category->slug) }} --}}