@extends('admin.layouts.app')

@section('title', 'Manajemen Dokumen')
@section('header', 'Manajemen Dokumen')
@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Filter -->
                <form action="#" method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under
                                Review</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fakultas</label>
                        <select name="faculty_id" class="form-select">
                            <option value="">Semua Fakultas</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}"
                                    {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="year" class="form-select">
                            <option value="">Semua Tahun</option>
                            {{-- @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                </form>

                <!-- Tabel Dokumen -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Fakultas</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.documents.show', $document->id) }}"
                                            class="text-decoration-none">
                                            {{ Str::limit($document->title, 50) }}
                                        </a>
                                    </td>
                                    <td>{{ $document->user->name }}</td>
                                    <td>{{ $document->faculty->name }}</td>
                                    <td>{{ $document->publication_year }}</td>
                                    <td>
                                        @if ($document->status == 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($document->status == 'under_review')
                                            <span class="badge bg-warning text-dark">Under Review</span>
                                        @elseif($document->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-info" href="{{route('admin.documents.show', $document->id)}}"><i class="bi bi-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination bootstrap -->
                <div class="flex justify-center mt-4">
                    {{ $documents->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

@endsection
