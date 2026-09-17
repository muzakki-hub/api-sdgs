@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard SDGs Desa</h1>
    </div>
    {{-- Grafik Distribusi Kategori --}}
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keterangan Survey</h6>
                </div>
                <div class="card-body">
                    <p><strong>Survey Aktif : </strong> {{ $surveyAktif ?? '-' }}</p>
                    <p><strong>Tanggal Mulai : </strong> {{ $mulai ?? '-' }}</p>
                    <p><strong>Batas Pengisian : </strong> {{ $batas ?? '-' }}</p>
                    <p><strong>Status : </strong>
                        <span class="badge badge-success">{{ $statusSurvey ?? 'Belum Dimulai' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Total Desa --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Desa / Data
                                Seharusnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDesa->count() ?? 0 }} / 1</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total RukunTetangga --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total RT / Data
                                Seharusnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRukunTetangga ?? 0 }} / 50</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Keluarga --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Keluarga / Data
                                Seharusnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKeluarga ?? 0 }} / 700</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Individu --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Individu / Data
                                Seharusnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalIndividu ?? 0 }} / 1300</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress Survey --}}
        {{-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Progress Survey</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $progressSurvey ?? 0 }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>



    {{-- Grafik Progress P1–P10 --}}
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Progress Pengisian SDGs Tingkat Desa (P2 – P10)</h6>
                </div>
                <div class="card-body">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Progress P1–P10
        const ctx1 = document.getElementById('progressChart');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['P2', 'P3', 'P4', 'P5', 'P6', 'P7', 'P8', 'P9', 'P10'],
                datasets: [{
                    label: 'Progress (%)',
                    data: @json($progressP),
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
@endpush
