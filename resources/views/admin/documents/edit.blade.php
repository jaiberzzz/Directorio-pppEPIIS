<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Documento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.documents.update', $document->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="title" id="title" value="{{ $document->title }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea name="description" id="description" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $document->description }}</textarea>
                        </div>

                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">Archivo (Dejar en blanco
                                para mantener actual)</label>
                            <div class="mb-2 text-sm text-gray-600">Actual: <a
                                    href="{{ Storage::url($document->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline">Ver archivo</a></div>
                            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.documents.index') }}"
                                class="text-gray-600 hover:underline mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Actualizar
                                Documento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </x-admin-layout>