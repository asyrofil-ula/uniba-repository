@extends('admin.layouts.app')

@section('title', 'Detail Pengguna')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengguna</h1>
        <div>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Details -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle" src="{{ asset('admin/assets/static/images/faces/user.png') }}"  width="120" height="120">
                    </div>

                    <dl class="row">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4">Role</dt>
                        <dd class="col-sm-8">
                            @if($user->role == 'admin')
                                <span class="badge badge-danger">Admin</span>
                            @elseif($user->role == 'librarian')
                                <span class="badge badge-primary">Pustakawan</span>
                            @elseif($user->role == 'lecturer')
                                <span class="badge badge-info">Dosen</span>
                            @else
                                <span class="badge badge-secondary">Mahasiswa</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Fakultas</dt>
                        <dd class="col-sm-8">{{ $user->faculty->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Departemen</dt>
                        <dd class="col-sm-8">{{ $user->department->name ?? '-' }}</dd>

                        @if($user->role == 'student')
                            <dt class="col-sm-4">NIM</dt>
                            <dd class="col-sm-8">{{ $user->student_id ?? '-' }}</dd>
                        @endif

                        @if($user->role == 'lecturer')
                            <dt class="col-sm-4">NIDN</dt>
                            <dd class="col-sm-8">{{ $user->lecturer_id ?? '-' }}</dd>
                        @endif

                        <dt class="col-sm-4">Nomor Telepon</dt>
                        <dd class="col-sm-8">{{ $user->phone ?? '-' }}</dd>

                        <dt class="col-sm-4">ORCID ID</dt>
                        <dd class="col-sm-8">{{ $user->orcid_id ?? '-' }}</dd>

                        <dt class="col-sm-4">Terdaftar pada</dt>
                        <dd class="col-sm-8">{{ $user->created_at->format('d M Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- User Documents -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dokumen</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Dokumen yang Diunggah</h5>
                        <div class="list-group">
                            @forelse($user->documents as $document)
                                <a href="{{ route('admin.documents.show', $document->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $document->title }}</h6>
                                        <small>{{ $document->created_at->diffForHumans() }}</small>
                                    </div>
                                    <small>
                                        <span class="badge badge-{{ $document->status == 'published' ? 'success' : ($document->status == 'under_review' ? 'warning' : 'danger') }}">
                                            {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                                        </span>
                                    </small>
                                </a>
                            @empty
                                <div class="alert alert-info">Belum ada dokumen yang diunggah</div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h5>Dokumen sebagai Penulis</h5>
                        <div class="list-group">
                            @forelse($user->authoredDocuments as $document)
                                <a href="{{ route('admin.documents.show', $document->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $document->title }}</h6>
                                        <small>{{ $document->created_at->diffForHumans() }}</small>
                                    </div>
                                    <small>
                                        <span class="badge badge-{{ $document->status == 'published' ? 'success' : ($document->status == 'under_review' ? 'warning' : 'danger') }}">
                                            {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                                        </span>
                                    </small>
                                </a>
                            @empty
                                <div class="alert alert-info">Belum ada dokumen sebagai penulis</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
