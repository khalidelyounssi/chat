@extends('layouts.admin')

@section('title', 'Nouvelle categorie - Admin')
@section('page-title', 'Ajouter une categorie')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="admin-panel p-6 sm:p-8">
        @csrf
        @include('admin.categories._form')
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
                    preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Apercu">`;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
