<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparansi APBD</title>
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('niceadmin/vendor/apexcharts/apexcharts.min.js') }}"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Transparansi Anggaran Desa</h1>
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">Kembali ke Beranda</a>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Grafik Realisasi APBD</h5>
            <div id="apbdChart"></div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Data Realisasi APBD</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Nama Item</th>
                            <th>Anggaran</th>
                            <th>Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apbds as $apbd)
                            <tr>
                                <td>{{ $apbd->kategori }}</td>
                                <td>{{ $apbd->nama_item }}</td>
                                <td>Rp {{ number_format($apbd->anggaran, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($apbd->realisasi, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#apbdChart"), {
            series: [{
                name: 'Anggaran',
                data: {!! json_encode($apbds->pluck('anggaran')) !!}
            }, {
                name: 'Realisasi',
                data: {!! json_encode($apbds->pluck('realisasi')) !!}
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! json_encode($apbds->pluck('nama_item')) !!},
            },
            yaxis: {
                title: {
                    text: 'Rupiah (Rp)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val
                    }
                }
            }
        }).render();
    });
</script>
<script src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
