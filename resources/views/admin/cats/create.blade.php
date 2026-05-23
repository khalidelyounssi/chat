@extends('layouts.admin')

@section('title', 'Nouveau chat - Admin')
@section('page-title', 'Ajouter un chat')

@section('content')
    <form action="{{ route('admin.cats.store') }}" method="POST" enctype="multipart/form-data" class="admin-panel p-5 sm:p-6 lg:p-8">
        @csrf
        @include('admin.cats._form')
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageInput = document.getElementById('cat_image');
            const imagePreview = document.getElementById('cat-image-preview');
            const galleryInput = document.getElementById('cat_gallery');
            const galleryPreview = document.getElementById('cat-gallery-preview');

            imageInput?.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Apercu">`;
                };
                reader.readAsDataURL(file);
            });

            galleryInput?.addEventListener('change', (event) => {
                const files = Array.from(event.target.files || []);
                galleryPreview.innerHTML = '';

                files.forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-20 w-full rounded-lg object-cover';
                        img.alt = 'Apercu galerie';
                        galleryPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endpush
