@extends('layout.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $siswa }}</h3>
                            <p>Jumlah Siswa</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-person"></i>
                        </div>
                        <a href="#" class="small-box-footer">Info Lebih Lanjut <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $guru }}</h3>
                            <p>Jumlah Guru</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Info Lebih Lanjut <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $kelas }}</h3>
                            <p>Jumlah Kelas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Info Lebih Lanjut <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

            </div><!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <div class="box box-info">
                        <div class="box-header">
                            <i class="fa fa-envelope"></i>
                            <h3 class="box-title">Halaman Utama</h3>

                        </div>
                        <div class="box-body text-center">
                            <h1>
                                Selamat Datang Di {{ env('APP_NAME') }}
                            </h1>
                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </section>
                <!-- /.Left col -->
                <section class="col-lg-6 connectedSortable">
                    <div class="box box-info">
                        <div class="box-header">
                            <i class="fa fa-users"></i>
                            <h3 class="box-title">Grafik Siswa Kelas</h3>

                        </div>
                        <div class="box-body">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="box box-info">
                        <div class="box-header with-border">

                            <div class="row">
                                <div class="col-md-5">
                                    <h3 class="box-title">
                                        <i class="fa fa-users"></i>
                                        Grafik Kehadiran Siswa
                                    </h3>
                                </div>

                                <div class="col-md-7">
                                    <div class="pull-right" style="display:flex;gap:8px;">
                                        <select class="form-control input-sm" onchange=" loadKehadiran();" id="tahun_kehadiran" style="width:90px;">
                                            @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                        <select class="form-control input-sm" onchange=" loadKehadiran();" id="bulan_kehadiran" style="width:120px;">
                                            @php
                                                $bulan = [
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'Oktober',
                                                    11 => 'November',
                                                    12 => 'Desember',
                                                ];
                                            @endphp

                                            @foreach ($bulan as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ date('n') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="box-body">
                            <canvas id="kehadiran"></canvas>
                        </div>
                    </div>
                </section>

                <section class="col-lg-12 connectedSortable">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <h3 class="box-title">
                                        <i class="fa fa-users"></i>
                                        Grafik Pelanggaran Siswa
                                    </h3>
                                </div>

                                <div class="col-md-8 col-sm-12">
                                    <div class="pull-right" style="display:flex; gap:10px; align-items:center;">

                                        <select class="form-control" onchange=" loadPelanggaran();" id="tahun_pelanggaran" style="width:120px;">
                                            @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                        <select class="form-control" onchange=" loadPelanggaran();" id="bulan_pelanggaran" style="width:150px;">
                                            @php
                                                $bulan = [
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'Oktober',
                                                    11 => 'November',
                                                    12 => 'Desember',
                                                ];
                                            @endphp

                                            @foreach ($bulan as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ date('n') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <canvas id="pelanggaran"></canvas>
                        </div>

                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            get_data_chart_siswa();
            loadPelanggaran();
            loadKehadiran();
        });
        $('#tahun_kehadiran, #bulan_kehadiran').on('change', function() {
            loadKehadiran();
        });

        const loadKehadiran = () => {
            $.ajax({
                url: BASE_URL + '/api/dashboard/kehadiran',
                type: 'GET',
                dataType: 'json',
                data: {
                    tahun: $('#tahun_kehadiran').val(),
                    bulan: $('#bulan_kehadiran').val()
                },
                success: function(response) {
                    kehadiran(response);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });

        }
        let chartKehadiran = null;

        function kehadiran(response) {
            if (chartKehadiran) {
                chartKehadiran.destroy();
            }
            const ctx = document.getElementById('kehadiran').getContext('2d');
            chartKehadiran = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: 'Jumlah Kehadiran',
                        data: response.data,
                        backgroundColor: '#3c8dbc',
                        borderColor: '#3c8dbc',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
        get_data_chart_siswa = () => {
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/dashboard/chart-siswa`,
                dataType: "JSON",
                success: function(response) {
                    siswa_chart(response);
                }
            });
        }
        siswa_chart = (response) => {
            const ctx = document.getElementById('myChart');
            // Hapus chart lama jika sudah ada
            if (window.siswaChart) {
                window.siswaChart.destroy();
            }
            window.siswaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.dataKelas,
                    datasets: [{
                            label: 'Laki-laki',
                            data: response.laki,
                            backgroundColor: '#3498db',
                            borderColor: '#2980b9',
                            borderWidth: 1
                        },
                        {
                            label: 'Perempuan',
                            data: response.perempuan,
                            backgroundColor: '#e91e63',
                            borderColor: '#c2185b',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

        }

        const loadPelanggaran=()=> {
            $.ajax({
                url: BASE_URL + '/api/dashboard/pelanggaran',
                type: 'GET',
                data: {
                    tahun: $('#tahun_pelanggaran').val(),
                    bulan: $('#bulan_pelanggaran').val()
                },
                success: function(response) {
                    pelanggaran(response);
                }
            });

        }

        $('#tahun_pelanggaran, #bulan_pelanggaran').on('change', function() {
            loadPelanggaran();
        });

        let chartPelanggaran = null;

        function pelanggaran(response) {

            if (chartPelanggaran) {
                chartPelanggaran.destroy();
            }

            const ctx = document.getElementById('pelanggaran').getContext('2d');

            chartPelanggaran = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: 'Jumlah Pelanggaran',
                        data: response.data,
                        backgroundColor: '#dd4b39',
                        borderColor: '#dd4b39',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
