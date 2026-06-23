@extends('layout.template')
@section('content')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-4 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $kelas }}</h3>
                        <p>Kelas</p>
                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                        </path>
                    </svg> <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Info Lebih Lanjut <i class="bi bi-link-45deg"></i> </a>
                </div>
                <!--end::Small Box Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-lg-4 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $siswa }}</h3>
                        <p>Siswa</p>
                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                        </path>
                    </svg> <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Info Lebih Lanjut <i class="bi bi-link-45deg"></i> </a>
                </div>
                <!--end::Small Box Widget 2-->
            </div>
            <!--end::Col-->
            <div class="col-lg-4 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $guru }}</h3>
                        <p>Guru</p>
                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                        </path>
                    </svg> <a href="#"
                        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        Info Lebih Lanjut <i class="bi bi-link-45deg"></i> </a>
                </div>
                <!--end::Small Box Widget 3-->
            </div>
            <!--end::Col-->

            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12 connectedSortable">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Informasi</h3>
                    </div>
                    <div class="card-body text-center">
                        <h1>{{ env('APP_NAME') }}</h1>
                    </div>
                </div> <!-- /.card -->
                <!-- DIRECT CHAT -->

            </div> <!-- /.Start col -->
            <div class="col-lg-12 connectedSortable">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Data</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="col-md-12">
                            <div class="row align-items-end mb-3">
                                <div class="col-md-3">
                                    <label for="kelas">Kelas</label>
                                    <select name="kelas" class="form-control" id="kelas">
                                        <option value="">Pilih Kelas</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" class="form-control" id="bulan">
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun" class="form-control" id="tahun">
                                        <option value="">Pilih Tahun</option>
                                        <!-- Tambahkan opsi tahun jika perlu -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary w-100" onclick="makeDashboard()">Tampilkan</button>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start col -->

        </div> <!-- /.row (main row) -->
    </div>
    <!--end::Container-->
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script>
    $(document).ready(function () {
        data_dashboard();
    });
    makeDashboard = () => {
        $.ajax({
            type: "POST",
            url: "{{ route('chart-data-post') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_kelas: $('#kelas').val(),
                bulan: $('#bulan').val(),
                tahun: $('#tahun').val()
            },
            dataType: "JSON",
            success: function (response) {
                makeChart(response);
            },
            error: function (xhr, status, error) {
                error_function(xhr)
            }
        });
    }
    // get class data 
    data_dashboard = () => {
        $.ajax({
            type: "GET",
            url: "{{ route('chart-data') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "JSON",
            success: function (response) {
                if (response.status == true) {
                    let kelas = [];

                    $.each(response.kelas, function (index, item) {
                        kelas.push(`<option value="${item.id}">${item.nama_kelas}</option>`);
                    });
                    $('#kelas').html(`${kelas.join('')}`);
                    let tahun = [];
                    $.each(response.tahun, function (indexInArray, valueOfElement) {
                        tahun.push(
                            `<option value="${valueOfElement.tahun}">${valueOfElement.tahun}</option>`
                            );
                    });
                    $('#tahun').html(`${tahun.join('')}`);
                }
                makeDashboard();
            },
            error: function (xhr, status, error) {
                error_function(xhr);
            }
        });
    }
    let myChart = null;
    const makeChart = (data) => {
        const ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }
      myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: data.label_persentase,
        datasets: [{
            label: `Status Kehadiran Kelas: ${data.nama_kelas} Bulan: ${data.bulan} Tahun: ${data.tahun}`,
            data: data.persentase,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
       options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            datalabels: {
                color: '#fff',
                font: {
                    weight: 'bold',
                    size: 14
                },
                formatter: function(value, context) {
                    return value; // Tampilkan nilai asli
                }
            }
        }
    },  
    plugins: [ChartDataLabels]
});
    }
</script>
@endsection