@extends('admin.layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 fw-bold text-dark">Edit Pengguna</h1>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h6 class="m-0 fw-bold">Form Edit Pengguna</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="">
                            <div class="form-group mb-4">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="me-3">
                                        <img id="photoPreview" src="{{ asset('admin/assets/static/images/faces/user.png') }}" alt="Profile Preview" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control rounded-3" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control rounded-3" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="role" class="form-label fw-semibold">Role</label>
                                <select id="role" name="role" class="form-select rounded-3" required>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="librarian" {{ old('role', $user->role) == 'librarian' ? 'selected' : '' }}>Pustakawan</option>
                                    <option value="dosen" {{ old('role', $user->role) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                    <option value="mahasiswa" {{ old('role', $user->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                </select>
                                @error('role')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" class="form-control rounded-3" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group mb-4" id="studentIdField" style="{{ old('role', $user->role) == 'mahasiswa' ? '' : 'display: none' }}">
                                <label for="student_id" class="form-label fw-semibold">NIM</label>
                                <input type="text" class="form-control rounded-3" id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}">
                                @error('student_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-4" id="lecturerIdField" style="{{ old('role', $user->role) == 'dosen' ? '' : 'display: none' }}">
                                <label for="lecturer_id" class="form-label fw-semibold">NIP</label>
                                <input type="text" class="form-control rounded-3" id="lecturer_id" name="lecturer_id" value="{{ old('lecturer_id', $user->lecturer_id) }}">
                                @error('lecturer_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="faculty_id" class="form-label fw-semibold">Fakultas</label>
                                <select id="faculty_id" name="faculty_id" class="form-select rounded-3" required>
                                    <option value="">Pilih Fakultas</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" {{ old('faculty_id', $user->faculty_id) == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                                @error('faculty_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="department_id" class="form-label fw-semibold">Departemen</label>
                                <select id="department_id" name="department_id" class="form-select rounded-3" required>
                                    <option value="">Pilih Departemen</option>
                                </select>
                                @error('department_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="password" class="form-label fw-semibold">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                <div class="input-group">
                                    <input type="password" class="form-control rounded-start" id="password" name="password">
                                    <button type="button" class="btn btn-outline-secondary rounded-end" id="togglePassword">
                                        <i class="bi bi-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control rounded-start" id="password_confirmation" name="password_confirmation">
                                    <button type="button" class="btn btn-outline-secondary rounded-end" id="togglePasswordConfirmation">
                                        <i class="bi bi-eye" id="passwordConfirmationIcon"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-warning rounded-pill px-4" id="resetPassword">
                                <i class="bi bi-arrow-repeat me-2"></i> Reset Password ke "unibamadura"
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(90deg, #007bff, #00aaff);
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #00aaff);
            border: none;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #007bff);
        }

        .btn-warning {
            background: linear-gradient(90deg, #ffca2c, #ffab00);
            border: none;
            transition: background 0.3s;
        }

        .btn-warning:hover {
            background: linear-gradient(90deg, #e0a800, #ffca2c);
        }

        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: border-color 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-outline-secondary {
            border-color: #ced4da;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordConfirmationIcon = document.getElementById('passwordConfirmationIcon');

            const resetPasswordButton = document.getElementById('resetPassword');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                passwordIcon.classList.toggle('bi-eye');
                passwordIcon.classList.toggle('bi-eye-slash');
            });

            togglePasswordConfirmation.addEventListener('click', function() {
                const type = passwordConfirmationInput.type === 'password' ? 'text' : 'password';
                passwordConfirmationInput.type = type;
                passwordConfirmationIcon.classList.toggle('bi-eye');
                passwordConfirmationIcon.classList.toggle('bi-eye-slash');
            });

            resetPasswordButton.addEventListener('click', function() {
                passwordInput.value = 'unibamadura';
                passwordConfirmationInput.value = 'unibamadura';
                passwordInput.type = 'text';
                passwordConfirmationInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
                passwordConfirmationIcon.classList.remove('bi-eye');
                passwordConfirmationIcon.classList.add('bi-eye-slash');
            });

            const facultySelect = document.getElementById('faculty_id');
            const departmentSelect = document.getElementById('department_id');
            const oldDepartmentId = "{{ old('department_id', $user->department_id) }}";

            function fetchDepartments(facultyId, selectedDepartmentId) {
                departmentSelect.innerHTML = '<option value="">Memuat...</option>';

                if (!facultyId) {
                    departmentSelect.innerHTML = '<option value="">Pilih Departemen</option>';
                    return;
                }

                fetch(`/api/faculties/${facultyId}/departments`)
                    .then(response => response.json())
                    .then(data => {
                        departmentSelect.innerHTML = '<option value="">Pilih Departemen</option>';
                        data.forEach(department => {
                            const option = document.createElement('option');
                            option.value = department.id;
                            option.textContent = department.name;
                            if (department.id == selectedDepartmentId) {
                                option.selected = true;
                            }
                            departmentSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching departments:', error);
                        departmentSelect.innerHTML = '<option value="">Gagal memuat departemen</option>';
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
        });

        $(document).ready(function() {
            // Show/hide student/lecturer ID fields with animation
            $('#role').on('change', function() {
                if ($(this).val() === 'mahasiswa') {
                    $('#studentIdField').slideDown(300);
                    $('#lecturerIdField').slideUp(300);
                } else if ($(this).val() === 'dosen') {
                    $('#studentIdField').slideUp(300);
                    $('#lecturerIdField').slideDown(300);
                } else {
                    $('#studentIdField').slideUp(300);
                    $('#lecturerIdField').slideUp(300);
                }
            });

            // Trigger change event on page load
            $('#role').trigger('change');
        });
    </script>
@endpush
