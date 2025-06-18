@extends('admin.layouts.app')
@section('title', 'Manajemen Dokumen')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Dokumen</h1>
        <a href="{{ route('admin.documents') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Dokumen</h6>
                    @if($document->status == 'under_review')
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#reviewModal">
                            <i class="bi bi-check fa-sm"></i> Review Dokumen
                        </button>
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h2 class="h4 font-weight-bold mb-1">{{ $document->title }}</h2>
                            <p class="text-muted mb-0">{{ $document->authors->pluck('name')->join(', ') }}</p>
                        </div>
                        <span class="badge badge-pill badge-{{ $document->status == 'published' ? 'success' : ($document->status == 'under_review' ? 'warning' : 'danger') }} px-3 py-2">
                            {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                        </span>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <dl class="mb-0">
                                <dt class="text-dark font-weight-bold">Penulis</dt>
                                <dd class="mb-3">{{ $document->user->name ?? '-' }}</dd>

                                <dt class="text-dark font-weight-bold">Fakultas</dt>
                                <dd class="mb-3">{{ $document->faculty->name ?? '-' }}</dd>

                                <dt class="text-dark font-weight-bold">Departemen</dt>
                                <dd class="mb-0">{{ $document->department->name ?? '-' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-dark font-weight-bold">Jenis Dokumen</dt>
                                <dd class="mb-3">{{ $document->documentType->name ?? '-' }}</dd>

                                <dt class="text-dark font-weight-bold">Tahun Publikasi</dt>
                                <dd class="mb-3">{{ $document->publication_year }}</dd>

                                <dt class="text-dark font-weight-bold">Lisensi</dt>
                                <dd class="mb-0">{{ $document->license->name ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <h5 class="font-weight-bold">Abstrak</h5>
                        <p class="text-justify">{{ $document->abstract_id ?? '-' }}</p>
                    </div>

                    <div>
                        <h5 class="font-weight-bold">Kata Kunci</h5>
                        <div>
                            @forelse($document->keywords as $item)
                                <span class="badge badge-light border text-dark font-weight-normal mr-1 mb-1">{{ $item->keyword }}</span>
                            @empty
                                <p class="text-muted">-</p>
                            @endforelse
                        </div>
                    </div>

                    @if($document->status == 'rejected' && $document->rejection_reason)
                    <div class="alert alert-danger mt-4">
                        <h5 class="alert-heading font-weight-bold">Alasan Penolakan</h5>
                        <p class="mb-0">{{ $document->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">File Dokumen</h6>
                </div>
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1"><strong><i class="bi bi-file-alt mr-2"></i>Nama File:</strong> {{ basename($document->file_path) }}</p>
                        <p class="mb-0 text-muted"><strong><i class="bi bi-database mr-2"></i>Ukuran:</strong> {{ number_format($document->file_size / 1024, 2) }} MB</p>
                    </div>
                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-primary">
                        <i class="bi bi-download fa-sm mr-2"></i>Unduh
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center border-right">
                            <i class="bi bi-download fa-2x text-primary mb-2"></i>
                            <div class="h4 font-weight-bold">{{ $document->download_count }}</div>
                            <div class="text-muted small text-uppercase">Total Unduhan</div>
                        </div>
                        <div class="col-6 text-center">
                            <i class="bi bi-eye fa-2x text-primary mb-2"></i>
                            <div class="h4 font-weight-bold">{{ $document->view_count }}</div>
                            <div class="text-muted small text-uppercase">Total Dilihat</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Unduhan Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($document->downloads->take(5) as $download)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{ $download->user->name ?? 'Pengguna Anonim' }}</span>
                            <small class="text-muted">{{ $download->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">Belum ada unduhan.</div>
                    @endforelse
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Dilihat Terakhir</h6>
                </div>
                <div class="card-body p-0">
                     @forelse($document->views->take(5) as $view)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{ $view->user->name ?? 'Pengguna Anonim' }}</span>
                            <small class="text-muted">{{ $view->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">Belum ada yang melihat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@if($document->status == 'under_review')
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.documents.review', $document->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Review Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Tindakan</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="published">Publikasikan Dokumen</option>
                            <option value="rejected">Tolak Dokumen</option>
                        </select>
                    </div>
                    <div class="form-group" id="rejectionReasonGroup" style="display: none;">
                        <label for="rejection_reason" class="font-weight-bold">Alasan Penolakan</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" placeholder="Jelaskan mengapa dokumen ini ditolak..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Tindakan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
{{-- Bootstrap and Popper JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Show/hide rejection reason field based on selected status
    $('#status').change(function() {
        if ($(this).val() === 'rejected') {
            $('#rejectionReasonGroup').slideDown();
            $('#rejection_reason').prop('required', true);
        } else {
            $('#rejectionReasonGroup').slideUp();
            $('#rejection_reason').prop('required', false);
        }
    });

    // Trigger change event on page load to set initial state
    $('#status').trigger('change');
});
</script>
@endpush
