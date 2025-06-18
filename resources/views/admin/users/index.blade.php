@extends('admin.layouts.app')

@section('title', 'Manajemen Dokumen')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Pengguna</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users') }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="librarian" {{ request('role') == 'librarian' ? 'selected' : '' }}>Pustakawan</option>
                            <option value="lecturer" {{ request('role') == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="faculty_id">Fakultas</label>
                        <select id="faculty_id" name="faculty_id" class="form-control">
                            <option value="">Semua Fakultas</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Fakultas</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge badge-danger">Admin</span>
                                @elseif($user->role == 'librarian')
                                    <span class="badge badge-primary">Pustakawan</span>
                                @elseif($user->role == 'lecturer')
                                    <span class="badge badge-info">Dosen</span>
                                @else
                                    <span class="badge badge-secondary">Mahasiswa</span>
                                @endif
                            </td>
                            <td>{{ $user->faculty->name ?? '-' }}</td>
                            <td>{{ $user->documents_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada pengguna ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
