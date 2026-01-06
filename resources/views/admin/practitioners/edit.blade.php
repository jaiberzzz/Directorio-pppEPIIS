<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Practicante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.practitioners.update', $practitioner->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student User (Readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estudiante</label>
                                <input type="text"
                                    value="{{ $practitioner->user->name }} ({{ $practitioner->user->email }})" disabled
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                            </div>

                            <!-- DNI -->
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                                <input type="text" name="dni" id="dni" value="{{ old('dni', $practitioner->dni) }}"
                                    required maxlength="8"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Code -->
                            <div>
                                <label for="student_code" class="block text-sm font-medium text-gray-700">Código
                                    Estudiante</label>
                                <input type="text" name="student_code" id="student_code"
                                    value="{{ old('student_code', $practitioner->student_code) }}" required
                                    maxlength="6" pattern="\d*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $practitioner->phone) }}" maxlength="9" pattern="\d*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9)"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Semester -->
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semestre</label>
                                <input type="text" name="semester" id="semester"
                                    value="{{ old('semester', $practitioner->semester) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Company -->
                            <div>
                                <label for="company_name"
                                    class="block text-sm font-medium text-gray-700">Empresa</label>
                                <input type="text" name="company_name" id="company_name"
                                    value="{{ old('company_name', $practitioner->company_name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Area -->
                            <div>
                                <label for="practice_area" class="block text-sm font-medium text-gray-700">Área de
                                    Prácticas</label>
                                <input type="text" name="practice_area" id="practice_area"
                                    value="{{ old('practice_area', $practitioner->practice_area) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="por iniciar" {{ $practitioner->status == 'por iniciar' ? 'selected' : '' }}>Por Iniciar</option>
                                    <option value="en proceso" {{ $practitioner->status == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="finalizado" {{ $practitioner->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha
                                    Inicio</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $practitioner->start_date) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $practitioner->end_date) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Supervisor 1 -->
                            <div>
                                <label for="academic_supervisor_1_id"
                                    class="block text-sm font-medium text-gray-700">Supervisor 1</label>
                                <select name="academic_supervisor_1_id" id="academic_supervisor_1_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Ninguno --</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" {{ $practitioner->academic_supervisor_1_id == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Supervisor 2 -->
                            <div>
                                <label for="academic_supervisor_2_id"
                                    class="block text-sm font-medium text-gray-700">Supervisor 2</label>
                                <select name="academic_supervisor_2_id" id="academic_supervisor_2_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Ninguno --</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" {{ $practitioner->academic_supervisor_2_id == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Photo -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="photo" class="block text-sm font-medium text-gray-700">Fotografía
                                    (Actualizar)</label>
                                @if($practitioner->photo_path)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($practitioner->photo_path) }}" alt="Foto actual"
                                            class="h-20 w-20 object-cover rounded">
                                    </div>
                                @endif
                                <input type="file" name="photo" id="photo" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('admin.practitioners.index') }}"
                                class="text-gray-600 hover:underline mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>