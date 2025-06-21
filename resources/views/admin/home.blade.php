@extends('admin.layouts.app')
@section('title', 'Dashboard | Dashboard')
@section('content')
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldDocument"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Published</h6>
                                    <h6 class="font-extrabold mb-0">{{$total_documents}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Views</h6>
                                    <h6 class="font-extrabold mb-0">{{$view_count}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldDownload"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Download</h6>
                                    <h6 class="font-extrabold mb-0">{{$download_count}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldUser"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Author</h6>
                                    <h6 class="font-extrabold mb-0">{{$totalAuthors}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Line Area Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-data"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{asset('admin/assets/static/images/faces/user.png')}}" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{Auth::user()->name}}</h5>
                            <h6 class="text-muted mb-0">{{Auth::user()->email}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Dokumen Terbaru</h4>
                </div>
                <div class="card-content pb-4">
                    @foreach($recent_documents as $item)
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{asset('admin/assets/static/images/faces/user.png')}}">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">{{$item->authors->pluck('name')->join(', ') }}</h5>
                                <h6 class="text-muted mb-0">{{$item->title}}</h6>
                            </div>
                        </div>
                    @endforeach
                    <div class="px-4">
                        <a class='btn btn-block btn-xl btn-outline-primary font-bold mt-3' href="{{route('admin.documents')}}">Lihat Semua Dokumen</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        fetch('/api/chart-data')
            .then(response => response.json())
            .then(data => {
                const options = {
                    series: [
                        {
                            name: 'View',
                            data: data.views,
                        },
                        {
                            name: 'Download',
                            data: data.downloads,
                        }
                    ],
                    chart: {
                        type: 'area',
                        height: 350,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: data.dates,
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yyyy',
                        },
                    }
                };

                const chart = new ApexCharts(document.querySelector("#chart-data"), options);
                chart.render();
            });
    </script>
@endpush
