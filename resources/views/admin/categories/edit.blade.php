@extends('layouts.admin')

@section('title', 'Modifier une catégorie - Admin')
@section('page-title', 'Modifier la catégorie')

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="admin-panel p-6 sm:p-8">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category])
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageInput = document.getElementById('category_image');
            const preview = document.getElementById('category-image-preview');

            imageInput?.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Aperçu">`;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
