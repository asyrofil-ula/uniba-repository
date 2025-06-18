@extends('admin.layouts.app')

@section('title', 'Manajemen Dokumen')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
    </div>
    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
{{--            search, export import dan tambah user--}}

            <div class="d-flex align-items-center">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-plus me-2"></i>Tambah Pengguna
                </a>
            </div>


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
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role == 'librarian')
                                    <span class="badge bg-primary">Pustakawan</span>
                                @elseif($user->role == 'lecturer')
                                    <span class="badge bg-info">Dosen</span>
                                @else
                                    <span class="badge bg-secondary">Mahasiswa</span>
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
