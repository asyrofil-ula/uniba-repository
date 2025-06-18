@extends('admin.layouts.app')

@section('title', 'Detail Pengguna')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengguna</h1>
        <a href="{{ route('admin.users.show', $user->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengguna</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="librarian" {{ old('role', $user->role) == 'librarian' ? 'selected' : '' }}>Pustakawan</option>
                            <option value="lecturer" {{ old('role', $user->role) == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="faculty_id">Fakultas</label>
                        <select id="faculty_id" name="faculty_id" class="form-control" required>
                            <option value="">Pilih Fakultas</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ old('faculty_id', $user->faculty_id) == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="department_id">Departemen</label>
                        <select id="department_id" name="department_id" class="form-control" required>
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6" id="studentIdField" style="{{ old('role', $user->role) == 'student' ? '' : 'display: none;' }}">
                        <label for="student_id">NIM</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}">
                    </div>
                    <div class="form-group col-md-6" id="lecturerIdField" style="{{ old('role', $user->role) == 'lecturer' ? '' : 'display: none;' }}">
                        <label for="lecturer_id">NIDN</label>
                        <input type="text" class="form-control" id="lecturer_id" name="lecturer_id" value="{{ old('lecturer_id', $user->lecturer_id) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="orcid_id">ORCID ID</label>
                    <input type="text" class="form-control" id="orcid_id" name="orcid_id" value="{{ old('orcid_id', $user->orcid_id) }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Show/hide student/lecturer ID fields based on role
    $('#role').change(function() {
        if ($(this).val() === 'student') {
            $('#studentIdField').show();
            $('#lecturerIdField').hide();
        } else if ($(this).val() === 'lecturer') {
            $('#studentIdField').hide();
            $('#lecturerIdField').show();
        } else {
            $('#studentIdField').hide();
            $('#lecturerIdField').hide();
        }
    });

    // Load departments when faculty changes
    $('#faculty_id').change(function() {
        var facultyId = $(this).val();
        if (facultyId) {
            $.get('/admin/faculties/' + facultyId + '/departments', function(data) {
                $('#department_id').empty();
                $('#department_id').append('<option value="">Pilih Departemen</option>');
                $.each(data, function(key, value) {
                    $('#department_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            });
        } else {
            $('#department_id').empty();
            $('#department_id').append('<option value="">Pilih Departemen</option>');
        }
    });
});
</script>
@endpush