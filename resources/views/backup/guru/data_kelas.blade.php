@extends('layout.template')
@section('content')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <!-- /.card -->
                <div class="card mb-12">
                    <div class="card-header">
                        <h3 class="card-title">Data Kelas</h3> <br>
                    </div> <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Kelas</th>
                                    <th>Jumlah Siswa</th>
                                    <th style="width: 40px">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $item)
                                <tr class="align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_kelas }}</td>
                                    <td>
                                        <label for="" class="label label-danger">{{ $item->siswa_count }}</label>
                                    </td>
                                    <td>
                                        <a href="{{ url('guru/absensi/buat-absensi/'.$item->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-hands"></i> Absensi
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div> <!-- /.col -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
    @endsection
    @section('script')
    <script>
    </script>
    @endsection