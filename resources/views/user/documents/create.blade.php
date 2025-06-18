@extends('landing.layouts.app')

@section('title', 'Unggah Dokumen Baru')

@section('content')
    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Unggah Dokumen Baru</h2>
                    <a href="{{ route('user.documents.index') }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        Kembali ke Daftar Dokumen
                    </a>
                </div>
                <p class="text-sm text-gray-600 mt-1">Isi formulir di bawah ini untuk menambahkan karya ilmiah Anda ke repositori.</p>
            </div>

            {{-- Mengubah action ke route 'store' dan menghapus method 'PUT' --}}
            <form action="{{ route('user.documents.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Dokumen <span
                                    class="text-red-500">*</span></label>
                            {{-- Menghapus value $document->title --}}
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('title') border-red-300 text-red-900 @enderror">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="document_type_id" class="block text-sm font-medium text-gray-700">Jenis Dokumen
                                <span class="text-red-500">*</span></label>
                            <select name="document_type_id" id="document_type_id" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('document_type_id') border-red-300 text-red-900 @enderror">
                                <option value="">Pilih Jenis Dokumen</option>
                                {{-- Menghapus value $document->document_type_id --}}
                                @foreach ($documentTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('document_type_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="faculty_id" class="block text-sm font-medium text-gray-700">Fakultas <span
                                        class="text-red-500">*</span></label>
                                <select name="faculty_id" id="faculty_id" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('faculty_id') border-red-300 text-red-900 @enderror">
                                    <option value="">Pilih Fakultas</option>
                                    {{-- Menggunakan fakultas user yang login sebagai default jika ada --}}
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}"
                                            {{ old('faculty_id', auth()->user()->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                                @error('faculty_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700">Program Studi
                                    <span class="text-red-500">*</span></label>
                                <select name="department_id" id="department_id" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('department_id') border-red-300 text-red-900 @enderror">
                                    <option value="">Pilih Program Studi</option>
                                    {{-- Opsi ini akan diisi oleh Javascript --}}
                                </select>
                                @error('department_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="publication_year" class="block text-sm font-medium text-gray-700">Tahun Terbit
                                    <span class="text-red-500">*</span></label>
                                {{-- Menggunakan tahun sekarang sebagai default --}}
                                <input type="number" name="publication_year" id="publication_year" min="2000"
                                    max="{{ date('Y') }}"
                                    value="{{ old('publication_year', date('Y')) }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('publication_year') border-red-300 text-red-900 @enderror">
                                @error('publication_year')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700">Bahasa <span
                                        class="text-red-500">*</span></label>
                                <select name="language" id="language" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('language') border-red-300 text-red-900 @enderror">
                                    <option value="id"
                                        {{ old('language') == 'id' ? 'selected' : '' }}>Bahasa
                                        Indonesia</option>
                                    <option value="en"
                                        {{ old('language') == 'en' ? 'selected' : '' }}>English
                                    </option>
                                    <option value="both"
                                        {{ old('language') == 'both' ? 'selected' : '' }}>Kedua Bahasa
                                    </option>
                                </select>
                                @error('language')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">File Dokumen
                                (PDF) <span class="text-red-500">*</span></label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file</span>
                                            {{-- Menambahkan 'required' --}}
                                            <input id="file" name="file" type="file" class="sr-only"
                                                accept=".pdf" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p id="file-name" class="text-sm text-gray-600"></p>
                                    <p class="text-xs text-gray-500">PDF maksimal 10MB</p>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="abstract_id" class="block text-sm font-medium text-gray-700">Abstrak (Bahasa Indonesia)
                        <span class="text-red-500">*</span></label>
                    <textarea name="abstract_id" id="abstract_id" rows="5" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('abstract_id') border-red-300 text-red-900 @enderror">{{ old('abstract_id') }}</textarea>
                    @error('abstract_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="abstract_en" class="block text-sm font-medium text-gray-700">Abstract (English)</label>
                    <textarea name="abstract_en" id="abstract_en" rows="5"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('abstract_en') border-red-300 text-red-900 @enderror">{{ old('abstract_en') }}</textarea>
                    @error('abstract_en')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Wajib diisi jika bahasa dipilih "English" atau "Kedua Bahasa"</p>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Kata Kunci <span
                            class="text-red-500">*</span></label>
                    {{-- Menghapus loop foreach untuk kata kunci --}}
                    <div id="keywords-container" class="mt-2 flex flex-wrap gap-2">
                        {{-- Container kosong untuk diisi oleh Javascript --}}
                    </div>
                    <div class="mt-2 flex rounded-md shadow-sm">
                        <input type="text" id="keyword-input"
                            class="focus:ring-blue-500 focus:border-blue-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                            placeholder="Tambahkan kata kunci">
                        <button id="add-keyword" type="button"
                            class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            Tambah
                        </button>
                    </div>
                    @error('keywords')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Minimal 3 kata kunci, maksimal 10 kata kunci</p>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('user.documents.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    {{-- Mengubah teks tombol submit --}}
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Unggah Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- DYNAMIC DEPARTMENT DROPDOWN ---
            const facultySelect = document.getElementById('faculty_id');
            const departmentSelect = document.getElementById('department_id');
            const oldDepartmentId = "{{ old('department_id', auth()->user()->department_id) }}";

            function fetchDepartments(facultyId, selectedDepartmentId) {
                departmentSelect.innerHTML = '<option value="">Memuat...</option>';

                if (!facultyId) {
                    departmentSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                    return;
                }

                fetch(`/api/faculties/${facultyId}/departments`)
                    .then(response => response.json())
                    .then(data => {
                        departmentSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                        data.forEach(department => {
                            const option = document.createElement('option');
                            option.value = department.id;
                            option.textContent = department.name;
                            if (department.id == selectedDepartmentId) {
                                option.selected = true;
                            }
                            departmentSelect.appendChild(option);
                        });
                    });
            }

            // Initial load if a faculty is pre-selected
            if (facultySelect.value) {
                fetchDepartments(facultySelect.value, oldDepartmentId);
            }

            // Event listener for faculty change
            facultySelect.addEventListener('change', function() {
                fetchDepartments(this.value, null);
            });


            // --- KEYWORDS MANAGEMENT ---
            document.getElementById('add-keyword').addEventListener('click', addKeyword);
            document.getElementById('keyword-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addKeyword();
                }
            });

            function addKeyword() {
                const input = document.getElementById('keyword-input');
                const keyword = input.value.trim();
                const keywordCount = document.querySelectorAll('input[name="keywords[]"]').length;

                if (keyword && keywordCount < 10) {
                    const container = document.getElementById('keywords-container');

                    // Check for duplicates
                    let isDuplicate = false;
                    document.querySelectorAll('input[name="keywords[]"]').forEach(hiddenInput => {
                        if (hiddenInput.value.toLowerCase() === keyword.toLowerCase()) {
                            isDuplicate = true;
                        }
                    });

                    if(isDuplicate) {
                        input.value = ''; // Clear input even if duplicate
                        // Optionally, show a small error message
                        return;
                    }

                    const badge = document.createElement('span');
                    badge.className =
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'keywords[]';
                    hiddenInput.value = keyword;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className =
                        'ml-1.5 inline-flex text-blue-400 hover:text-blue-600 focus:outline-none remove-keyword';
                    removeBtn.innerHTML = `
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                `;
                    removeBtn.addEventListener('click', function() {
                        badge.remove();
                    });

                    badge.appendChild(document.createTextNode(keyword));
                    badge.appendChild(hiddenInput);
                    badge.appendChild(removeBtn);

                    container.appendChild(badge);
                    input.value = '';
                    input.focus();
                }
            }

            // Remove keyword buttons (using event delegation for dynamically added elements)
            document.getElementById('keywords-container').addEventListener('click', function(e) {
                const removeButton = e.target.closest('.remove-keyword');
                if (removeButton) {
                    removeButton.closest('span').remove();
                }
            });

            // --- FILE INPUT NAME DISPLAY ---
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name');
            if(fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                    } else {
                        fileNameDisplay.textContent = '';
                    }
                });
            }
        });
    </script>
@endpush