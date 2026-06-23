@extends('layout.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data
                <small>Data</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Data</a></li>
                <li class="active"></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Mata Pelajaran</h3>

                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background: #eee;
                                    padding: 20px;
                                }

                                h2 {
                                    text-align: center;
                                    margin-bottom: 10px;
                                }

                                table {
                                    border-collapse: collapse;
                                    margin: auto;
                                    background: white;
                                }

                                th,
                                td {
                                    border: 1px solid #000;
                                    padding: 6px;
                                    text-align: center;
                                    font-size: 12px;
                                    min-width: 45px;
                                }

                                th {
                                    background: #f5f5f5;
                                }

                                .kelas {
                                    font-weight: bold;
                                    min-width: 70px;
                                }

                                .hari {
                                    font-weight: bold;
                                    background: #ddd;
                                }
                            </style>
                            <h2>JADWAL PBM MTsN 5 KOTA PADANG</h2>

                            <table>
                                <!-- Header Hari -->
                                <tr>
                                    <th rowspan="2">Kelas</th>
                                    <th class="hari" colspan="10">Senin</th>
                                    <th class="hari" colspan="10">Selasa</th>
                                    <th class="hari" colspan="10">Rabu</th>
                                    <th class="hari" colspan="8">Kamis</th>
                                    <th class="hari" colspan="6">Jumat</th>
                                </tr>

                                <!-- Nomor Jam -->
                                <tr>
                                    <!-- Senin -->
                                    <script>
                                        for (let i = 1; i <= 10; i++) document.write("<th>" + i + "</th>");
                                        for (let i = 1; i <= 10; i++) document.write("<th>" + i + "</th>");
                                        for (let i = 1; i <= 10; i++) document.write("<th>" + i + "</th>");
                                        for (let i = 1; i <= 8; i++) document.write("<th>" + i + "</th>");
                                        for (let i = 1; i <= 6; i++) document.write("<th>" + i + "</th>");
                                    </script>
                                </tr>

                                <!-- Contoh Data -->
                                <tr>
                                    <td class="kelas">VII.1</td>
                                    <td>IPA</td>
                                    <td>PJK</td>
                                    <td>SKI</td>
                                    <td>MTK</td>
                                    <td>SBK</td>
                                    <td>ING</td>
                                    <td>QH</td>
                                    <td>AA</td>
                                    <td>BI</td>
                                    <td>BA</td>

                                    <td>IPA</td>
                                    <td>MTK</td>
                                    <td>PKN</td>
                                    <td>BK</td>
                                    <td>FQ</td>
                                    <td>TIK</td>
                                    <td>BI</td>
                                    <td>IPS</td>
                                    <td></td>
                                    <td></td>

                                    <td>IPA</td>
                                    <td>MTK</td>
                                    <td>BA</td>
                                    <td>BI</td>
                                    <td>ING</td>
                                    <td>SKI</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td>IPA</td>
                                    <td>BA</td>
                                    <td>BI</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td>BI</td>
                                    <td>IPS</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td class="kelas">VII.2</td>
                                    <td>PKN</td>
                                    <td>QH</td>
                                    <td>PJK</td>
                                    <td>IPS</td>
                                    <td>MTK</td>
                                    <td>BA</td>
                                    <td>FQ</td>
                                    <td>SBK</td>
                                    <td>MTK</td>
                                    <td>BI</td>

                                    <td>ING</td>
                                    <td>BK</td>
                                    <td>BI</td>
                                    <td>IPA</td>
                                    <td>SKI</td>
                                    <td>TIK</td>
                                    <td>AA</td>
                                    <td>IPA</td>
                                    <td></td>
                                    <td></td>

                                    <td colspan="10"></td>
                                    <td colspan="8"></td>
                                    <td colspan="6"></td>
                                </tr>

                            </table>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
@endsection
@section('script')
@endsection
