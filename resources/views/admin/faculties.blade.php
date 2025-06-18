@extends('admin.layouts.app')

@section('title', 'Manajemen Dokumen')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 border-bottom pb-3">
            <div>
                <h1 class="mt-4">Manajemen Category</h1>
                <p class="text-muted">Kelola semua category dalam sistem"</p>
            </div>
            <div class="d-flex flex-wrap gap-3">
                {{-- form search --}}
                <form action="{{ route('admin.faculties') }}" method="GET" class="d-flex">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" placeholder="Cari dokumen..." value=""
                            class="form-control border-0 bg-light">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                {{-- add button --}}
                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                    data-bs-target="#addModal">
                    <i><i class="bi bi-plus-circle"></i></i> Tambah Fakultas
                </button>
            </div>
        </div>
        {{-- session --}}

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-table me-1"></i>
                        Daftar Fakultas
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col" class="ps-4">Nama Fakultas</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col" class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakultas as $data)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $data->code }}</td>
                                        <td class="align-middle ps-4">{{ $data->name }}</td>
                                        {{-- icon from storage --}}
                                        <td class="align-middle">
                                                <img src="{{ asset('storage/faculties/' . $data->icon) }}" alt="icon" class="figure-img">

                                        </td>
                                        <td class="align-middle text-end pe-4">
                                            {{-- modal edit button --}}
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $data->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            {{-- modal delete button --}}
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $data->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal tambah Nama Fakultas --}}
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary bg-opacity-10 border-0">
                        <h5 class="modal-title text-primary fw-bold">
                            <i class="bi bi-file-earmark-plus me-2"></i>Tambah Fakultas Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.faculties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label for="code" class="form-label fw-medium">Kode Fakultas</label>
                                <input type="text" class="form-control bg-light border-0" name="code"></label>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Nama Fakultas</label>
                                <input type="text" class="form-control bg-light border-0" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="icon" class="form-label fw-medium">Icon</label>
                                <input type="file" class="form-control bg-light border-0" name="icon" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- modal edit --}}
        @foreach ($fakultas as $data)
            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary bg-opacity-10 border-0">
                            <h5 class="modal-title text-primary fw-bold">
                                <i class="bi bi-pencil-square me-2"></i>Edit Fakultas
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.faculties.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label for="code" class="form-label fw-medium">Kode Fakultas</label>
                                    <input type="text" class="form-control bg-light border-0" name="code"
                                        value="{{ $data->code }}"></label>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-medium">Nama Fakultas</label>
                                    <input type="text" class="form-control bg-light border-0" name="name"
                                        value="{{ $data->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="icon" class="form-label fw-medium">Icon</label>
                                    <input type="file" class="form-control bg-light border-0" name="icon" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- modal delete --}}
        @foreach ($fakultas as $data)
            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger bg-opacity-10 border-0">
                            <h5 class="modal-title text-danger fw-bold">Hapus Nama Fakultas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.faculties.destroy', $data->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <p class="fw-medium">Anda yakin ingin menghapus Nama Fakultas ini?</p>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
