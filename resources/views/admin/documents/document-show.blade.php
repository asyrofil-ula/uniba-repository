@extends('admin.layouts.app')

@section('title', 'Manajemen Jenis Dokumen')
@section('header', 'Detail Dokumen' . ' - ' . $document->title)

@section('content')
    <div class="container-fluid py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-gradient-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 fw-bold">Informasi Dokumen</h6>
                        @if($document->status == 'under_review')
                            <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                <i class="bi bi-check-circle me-1"></i> Review Dokumen
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h2 class="h4 fw-bold mb-1">{{ $document->title }}</h2>
                                <p class="text-muted small mb-0">{{ $document->authors->pluck('name')->join(', ') }}</p>
                            </div>
                            <span class="badge bg-{{ $document->status == 'published' ? 'success' : ($document->status == 'under_review' ? 'warning' : 'danger') }} rounded-pill px-3 py-2 fw-normal">
                            {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                        </span>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <dl class="mb-0">
                                    <dt class="text-dark fw-semibold">Penulis</dt>
                                    <dd class="mb-3 text-muted">{{ $document->user->name ?? '-' }}</dd>

                                    <dt class="text-dark fw-semibold">Fakultas</dt>
                                    <dd class="mb-3 text-muted">{{ $document->faculty->name ?? '-' }}</dd>

                                    <dt class="text-dark fw-semibold">Departemen</dt>
                                    <dd class="mb-0 text-muted">{{ $document->department->name ?? '-' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="mb-0">
                                    <dt class="text-dark fw-semibold">Jenis Dokumen</dt>
                                    <dd class="mb-3 text-muted">{{ $document->documentType->name ?? '-' }}</dd>

                                    <dt class="text-dark fw-semibold">Tahun Publikasi</dt>
                                    <dd class="mb-3 text-muted">{{ $document->publication_year }}</dd>

                                    <dt class="text-dark fw-semibold">Lisensi</dt>
                                    <dd class="mb-0 text-muted">{{ $document->license->name ?? '-' }}</dd>
                                </dl>
                            </div>
                        </div>

                        <hr class="my-4 border-gray-200">

                        <div class="mb-4">
                            <h5 class="fw-semibold">Abstrak</h5>
                            <p class="text-justify text-muted">{{ $document->abstract_id ?? '-' }}</p>
                        </div>

                        <div>
                            <h5 class="fw-semibold">Kata Kunci</h5>
                            <div>
                                @forelse($document->keywords as $item)
                                    <span class="badge bg-light border text-dark rounded-pill px-3 py-1 mb-1 me-1">{{ $item->keyword }}</span>
                                @empty
                                    <p class="text-muted">-</p>
                                @endforelse
                            </div>
                        </div>

                        @if($document->status == 'rejected' && $document->rejection_reason)
                            <div class="alert alert-danger mt-4 rounded-3">
                                <h5 class="alert-heading fw-semibold">Alasan Penolakan</h5>
                                <p class="mb-0">{{ $document->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="m-0 fw-bold">File Dokumen</h6>
                    </div>
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1"><strong><i class="bi bi-file-alt me-2"></i>Nama File:</strong> {{ basename($document->file_path) }}</p>
                            <p class="mb-0 text-muted"><strong><i class="bi bi-database me-2"></i>Ukuran:</strong> {{ number_format($document->file_size / 1024, 2) }} MB</p>
                        </div>
                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-download me-2"></i>Unduh
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="m-0 fw-bold">Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <i class="bi bi-download fa-2x text-primary mb-2"></i>
                                <div class="h4 fw-bold">{{ $document->download_count }}</div>
                                <div class="text-muted small text-uppercase">Total Unduhan</div>
                            </div>
                            <div class="col-6">
                                <i class="bi bi-eye fa-2x text-primary mb-2"></i>
                                <div class="h4 fw-bold">{{ $document->view_count }}</div>
                                <div class="text-muted small text-uppercase">Total Dilihat</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="m-0 fw-bold">Unduhan Terakhir</h6>
                    </div>
                    <div class="card-body p-0">
                        @forelse($document->downloads->take(5) as $download)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 py-3">
                                <span class="fw-semibold">{{ $download->user->name ?? 'Pengguna Anonim' }}</span>
                                <small class="text-muted">{{ $download->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted">Belum ada unduhan.</div>
                        @endforelse
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="m-0 fw-bold">Dilihat Terakhir</h6>
                    </div>
                    <div class="card-body p-0">
                        @forelse($document->views->take(5) as $view)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 py-3">
                                <span class="fw-semibold">{{ $view->user->name ?? 'Pengguna Anonim' }}</span>
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
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow-sm">
                    <form method="POST" action="{{ route('admin.documents.review', $document->id) }}">
                        @csrf
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title fw-bold" id="reviewModalLabel">Review Dokumen</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">Tindakan</label>
                                <select class="form-select rounded-3" id="status" name="status" required>
                                    <option value="published">Publikasikan Dokumen</option>
                                    <option value="rejected">Tolak Dokumen</option>
                                </select>
                            </div>
                            <div class="mb-0" id="rejectionReasonGroup" style="display: none;">
                                <label for="rejection_reason" class="form-label fw-semibold">Alasan Penolakan</label>
                                <textarea class="form-control rounded-3" id="rejection_reason" name="rejection_reason" rows="4" placeholder="Jelaskan mengapa dokumen ini ditolak..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Tindakan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {
            // Show/hide rejection reason field with animation
            $('#status').on('change', function() {
                if ($(this).val() === 'rejected') {
                    $('#rejectionReasonGroup').slideDown(300);
                    $('#rejection_reason').prop('required', true);
                } else {
                    $('#rejectionReasonGroup').slideUp(300);
                    $('#rejection_reason').prop('required', false);
                }
            });

            // Trigger change event on page load
            $('#status').trigger('change');

            // Add hover animation to cards
            $('.card').on('mouseenter', function() {
                $(this).css('transform', 'translateY(-5px)');
            }).on('mouseleave', function() {
                $(this).css('transform', 'translateY(0)');
            });
        });
    </script>
@endpush
