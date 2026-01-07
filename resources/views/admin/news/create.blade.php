<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Noticia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.news.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="title" id="title" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Contenido</label>
                            <textarea name="content" id="content" rows="10" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700">Fecha de
                                Publicación</label>
                            <input type="date" name="published_at" id="published_at" value="{{ date('Y-m-d') }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.news.index') }}"
                                class="text-gray-600 hover:underline mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Crear
                                Noticia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>