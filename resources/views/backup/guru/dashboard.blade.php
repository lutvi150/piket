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
                            <h3>7</h3>
                            <p>Kelas</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg>  <a href="#"
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
                            <h3>10</h3>
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
                            <h3>3</h3>
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
                <!-- Start col -->
             
            </div> <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('script')
    <script>
    </script>
@endsection
