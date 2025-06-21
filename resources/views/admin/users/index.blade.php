@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 200px;">
                        <form method="GET" action="{{ route('admin.users') }}" class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm" style="max-width: 200px;">
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="form-control rounded-3" placeholder="Cari nama atau email...">
                                <button type="submit" class="input-group-text rounded-end bg-light border">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        </span>
                    </div>
                    <a href="{{ route('admin.users.export') }}"
                       class="btn btn-outline-success btn-sm rounded-pill px-3">
                        <i class="bi bi-download me-2"></i>Ekspor
                    </a>
                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill px-3" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                        <i class="bi bi-upload me-2"></i>Impor
                    </button>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-plus me-2"></i>Tambah Pengguna
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="usersTable">
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
                                    @elseif($user->role == 'dosen')
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
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
        {{--        modal delete--}}
        @foreach($users as $user)
            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                 aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Hapus Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus pengguna "{{ $user->name }}"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content rounded-3">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="importModalLabel">Impor Pengguna dari Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-secondary small">
                            <strong>Panduan Import Pengguna:</strong>
                            <ul class="mb-2">
                                <li>Gunakan file dengan format <strong>.xlsx</strong> atau <strong>.xls</strong>
                                    (maksimal 5MB).
                                </li>
{{--                                <li>Pastikan baris pertama (header) sesuai dengan kolom berikut:</li>--}}
                            </ul>
                            <ul class="list-unstyled">
                                <li><code>Nama</code> — Nama lengkap pengguna</li>
                                <li><code>Email</code> — Alamat email yang unik dan valid</li>
                                <li><code>Role</code> — Peran pengguna: contoh <code>admin</code>,
                                    <code>mahasiswa</code>, <code>dosen</code></li>
                                <li><code>Telepon</code> — Nomor HP aktif (tanpa spasi atau simbol)</li>
                                <li><code>NIM/NIP</code> — Nomor identitas pengguna (mahasiswa/dosen)</li>
                                <li><code>Fakultas</code> — Nama fakultas sesuai sistem</li>
                                <li><code>Departemen</code> — Nama departemen pengguna sistem</li>
                                @foreach($faculties as $faculty)
                                    <li>
                                        <strong>{{ $faculty->name }} </strong>
                                        <ul>
                                            @foreach($faculty->departments as $department)
                                                <li>{{ $department->name }} </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                                <li><code>Password</code> — Sudah terisikan secara default(unibamadura)</li>
                            </ul>
                            <p class="mb-1">⚠️ Jika ada data yang tidak valid atau kosong, proses import akan gagal dan
                                menampilkan pesan error.</p>
                        </div>

                        <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="excel_file" class="form-label fw-semibold">Pilih File Excel</label>
                                <input type="file" class="form-control rounded-3" id="excel_file" name="excel_file"
                                       accept=".xlsx,.xls" required>
                                <small class="text-muted mt-1 d-block">Hanya file .xlsx atau .xls. Maksimal 5MB.</small>
                                @error('excel_file')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="form-group mb-4">
                                    <a href="{{ route('admin.users.export-template') }}"
                                       class="btn btn-outline-info rounded-pill px-4">
                                        <i class="bi bi-download me-2"></i> Unduh Template Excel
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 ">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal
                                </button>
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="bi bi-upload me-2"></i>Impor Data
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
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

        .btn-success {
            background: linear-gradient(90deg, #28a745, #34c759);
            border: none;
            transition: background 0.3s;
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #218838, #28a745);
        }

        .btn-outline-info {
            border-color: #17a2b8;
            color: #17a2b8;
        }

        .btn-outline-info:hover {
            background-color: #e6f7fa;
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #e8f4e8;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .modal-content {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');

            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                for (let i = 1; i < rows.length; i++) {
                    const name = rows[i].cells[0].textContent.toLowerCase();
                    const email = rows[i].cells[1].textContent.toLowerCase();
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            const excelFileInput = document.getElementById('excel_file');
            excelFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const ext = file.name.split('.').pop().toLowerCase();
                    if (!['xlsx', 'xls'].includes(ext)) {
                        alert('Hanya file Excel (.xlsx atau .xls) yang diperbolehkan.');
                        this.value = '';
                    } else if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file tidak boleh lebih dari 5MB.');
                        this.value = '';
                    }
                }
            });
        });
    </script>
@endpush
