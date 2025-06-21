@extends('admin.layouts.app')

@section('title', 'Manajemen Jenis Dokumen')
@section('header', 'Detail Dokumen' . ' - ' . $document->title)

@section('content')
    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Informasi Dokumen -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4 h-100">
                    <div class="card-header bg-gradient-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 fw-bold">Informasi Dokumen</h6>
                        @if($document->status == 'under_review')
                            <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reviewModal" aria-label="Review Dokumen">
                                <i class="bi bi-check-circle me-1"></i> Review Dokumen
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h2 class="h3 fw-bold mb-1 text-dark">{{ $document->title }}</h2>
                                <p class="text-muted small mb-0">{{ $document->authors->pluck('name')->join(', ') ?: 'Tidak ada penulis' }}</p>
                            </div>
                            <span class="badge bg-{{ $document->status == 'published' ? 'success' : ($document->status == 'under_review' ? 'warning' : 'danger') }} rounded-pill px-3 py-2 fw-semibold">
                            {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                        </span>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <dl class="mb-0">
                                    <dt class="text-dark fw-semibold small">Penulis</dt>
                                    <dd class="mb-3 text-muted">{{ $document->user->name ?? 'Tidak tersedia' }}</dd>
                                    <dt class="text-dark fw-semibold small">Fakultas</dt>
                                    <dd class="mb-3 text-muted">{{ $document->faculty->name ?? 'Tidak tersedia' }}</dd>
                                    <dt class="text-dark fw-semibold small">Departemen</dt>
                                    <dd class="mb-0 text-muted">{{ $document->department->name ?? 'Tidak tersedia' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="mb-0">
                                    <dt class="text-dark fw-semibold small">Jenis Dokumen</dt>
                                    <dd class="mb-3 text-muted">{{ $document->documentType->name ?? 'Tidak tersedia' }}</dd>
                                    <dt class="text-dark fw-semibold small">Tahun Publikasi</dt>
                                    <dd class="mb-3 text-muted">{{ $document->publication_year ?? 'Tidak tersedia' }}</dd>
                                    <dt class="text-dark fw-semibold small">Lisensi</dt>
                                    <dd class="mb-0 text-muted">{{ $document->license->name ?? 'Tidak tersedia' }}</dd>
                                </dl>
                            </div>
                        </div>

                        <hr class="my-4 border-gray-300">

                        <div class="mb-4">
                            <h5 class="fw-semibold text-dark">Abstrak</h5>
                            <p class="text-justify text-muted">{{ $document->abstract_id ?: 'Tidak ada abstrak tersedia' }}</p>
                        </div>

                        <div>
                            <h5 class="fw-semibold text-dark">Kata Kunci</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($document->keywords as $item)
                                    <span class="badge bg-light border border-primary text-primary rounded-pill px-3 py-2 mb-2">{{ $item->keyword }}</span>
                                @empty
                                    <p class="text-muted">Tidak ada kata kunci</p>
                                @endforelse
                            </div>
                        </div>

                        @if($document->status == 'rejected' && $document->rejection_reason)
                            <div class="alert alert-danger mt-4 rounded-3 alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading fw-semibold">Alasan Penolakan</h5>
                                <p class="mb-0">{{ $document->rejection_reason }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Preview Dokumen -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 mb-4 h-100">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="m-0 fw-bold">Preview Dokumen</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item rounded-3" src="{{ Storage::url($document->file_path) }}" allowfullscreen title="Preview Dokumen"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Dokumen dan Statistik -->
            <div class="col-12">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-gradient-primary text-white py-3">
                                <h6 class="m-0 fw-bold">File Dokumen</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-file-alt text-primary me-3 fa-2x"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fw-semibold text-truncate" title="{{ basename($document->file_path) }}"><strong>Nama File:</strong> {{ basename($document->file_path) }}</p>
                                        <p class="mb-0 text-muted"><strong>Ukuran:</strong> {{ number_format($document->file_size / 1024 , 2) }} MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 p-4 pt-0">
                                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-primary rounded-pill px-4 w-100" aria-label="Unduh Dokumen">
                                    <i class="bi bi-download me-2"></i>Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-gradient-primary text-white py-3">
                                <h6 class="m-0 fw-bold">Statistik</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row text-center g-4">
                                    <div class="col-6 border-end">
                                        <div class="stat-block p-2 rounded-3">
                                            <i class="bi bi-download text-primary fa-2x mb-2"></i>
                                            <div class="h4 fw-bold">{{ $document->download_count }}</div>
                                            <div class="text-muted small text-uppercase">Total Unduhan</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-block p-2 rounded-3">
                                            <i class="bi bi-eye text-primary fa-2x mb-2"></i>
                                            <div class="h4 fw-bold">{{ $document->view_count }}</div>
                                            <div class="text-muted small text-uppercase">Total Dilihat</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- Review Modal (Unchanged) -->--}}
{{--    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content rounded-3">--}}
{{--                <div class="modal-header bg-gradient-primary text-white">--}}
{{--                    <h5 class="modal-title" id="reviewModalLabel">Review Dokumen</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <!-- Modal content remains unchanged -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
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
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure iframe loads correctly
            const iframe = document.querySelector('iframe');
            iframe.addEventListener('error', function() {
                iframe.parentElement.innerHTML = '<div class="text-center text-muted">Gagal memuat preview dokumen</div>';
            });
        });
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
