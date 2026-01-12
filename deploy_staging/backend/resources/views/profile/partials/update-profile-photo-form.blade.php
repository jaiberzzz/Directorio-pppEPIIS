<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto de Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Actualiza tu foto de perfil para que te identifiquen fácilmente.') }}
        </p>
    </header>

    @if (session('status') === 'photo-updated')
        <p class="mt-2 text-sm text-green-600">
            {{ __('Foto actualizada correctamente.') }}
        </p>
    @elseif(session('status') === 'not-practitioner')
        <p class="mt-2 text-sm text-red-600">
            {{ __('No tienes un perfil de practicante asociado.') }}
        </p>
    @endif

    <form method="post" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data"
        class="mt-6 space-y-6">
        @csrf

        <div class="flex items-center gap-6">
            <div class="shrink-0">
                @if(auth()->user()->practitioner && auth()->user()->practitioner->photo_path)
                    <img class="h-16 w-16 object-cover rounded-full border border-gray-200"
                        src="{{ Storage::url(auth()->user()->practitioner->photo_path) }}" alt="Foto de perfil actual" />
                @else
                    <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="w-full">
                <!-- Recommendations Alert -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-3 mb-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-blue-800">
                                Recomendaciones para tu foto
                            </h3>
                            <div class="mt-1 text-sm leading-5 text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Usar una imagen <strong>cuadrada (1:1)</strong>.</li>
                                    <li>Resolución recomendada: <strong>500x500 px</strong>.</li>
                                    <li>Rostro centrado y bien iluminado.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <label class="block">
                    <span class="sr-only">Elige una foto de perfil</span>
                    <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg, image/gif" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        cursor-pointer
                        " required />
                </label>
                <p class="mt-2 text-xs text-gray-500">
                    <span class="font-bold">Formatos permitidos:</span> JPG, PNG, GIF. (Máx. 2MB)
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar Foto') }}</x-primary-button>
        </div>
    </form>
</section>