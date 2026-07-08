@extends('layout.template')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Absen Guru
                <small>Absen hanya untuk akun Anda</small>
            </h1>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">

                    <div class="box box-primary" style="border-radius:10px;">

                        <div class="box-body text-center">

                            <img src="{{ $guru->foto_url ?? asset('assets/images/default.png') }}"
                                style="width:80px;height:80px;border-radius:50%;object-fit:cover;">

                            <h4 style="margin-top:10px;">
                                {{ strtoupper($guru->nama_guru) }}
                            </h4>

                            <p>
                                <small>{{ $guru->nip }}</small>
                            </p>

                            {{-- TANGGAL --}}
                            <p>
                                <span class="label label-default">
                                    {{ date('d F Y') }}
                                </span>
                            </p>

                            {{-- STATUS --}}
                            <p id="status">
                                <span class="label label-info">Belum Absen</span>
                            </p>

                            {{-- 2x ABSEN --}}
                            <div class="row">

                                <div class="col-xs-6">

                                    <button type="button" id="btnMasuk" onclick="absen('masuk')"
                                        class="btn btn-success btn-block">

                                        <i id="iconMasuk" class="fa fa-sign-in fa-2x"></i>

                                        <div style="margin-top:8px">
                                            <strong>Masuk</strong><br>
                                            <small id="jamMasuk">--:--:--</small>
                                        </div>

                                    </button>

                                </div>

                                <div class="col-xs-6">

                                    <button type="button" id="btnKeluar" onclick="absen('keluar')"
                                        class="btn btn-primary btn-block">

                                        <i id="iconKeluar" class="fa fa-sign-out fa-2x"></i>

                                        <div style="margin-top:8px">
                                            <strong>Keluar</strong><br>
                                            <small id="jamKeluar">--:--:--</small>
                                        </div>

                                    </button>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12">

                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">History Absen</h3>
                    </div>

                    <div class="box-body table-responsive">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="historyAbsen">
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            loadHistory();
            checkAbsen();
        });
        const absen = async (tipe) => {
            // const now = new Date();
            // const tanggal = [
            //     now.getFullYear(),
            //     String(now.getMonth() + 1).padStart(2, "0"),
            //     String(now.getDate()).padStart(2, "0"),
            // ].join("-");

            // const jam = [
            //     String(now.getHours()).padStart(2, "0"),
            //     String(now.getMinutes()).padStart(2, "0"),
            //     String(now.getSeconds()).padStart(2, "0"),
            // ].join(":");
            // const payload = {
            //     tanggal: tanggal,
            //     status: "H",
            // };
            // if (tipe === "masuk") {
            //     payload.jam_masuk = jam;
            // } else {
            //     payload.jam_keluar = jam;
            // }
            Notiflix.Loading.circle("Memproses absensi...");
            $(".btn").prop("disabled", true);

            try {
                const response = await $.ajax({
                    url: `${BASE_URL}/absensi-guru-api`,
                    type: "POST",
                    // data: payload,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });
                Notiflix.Loading.remove();

                Notiflix.Notify.success(response.msg);

                $("#status").html(`
            <span class="label label-success">
                ${response.msg}
            </span>
        `);
        
                checkAbsen();
                loadHistory();
            } catch (xhr) {
                console.error(xhr);
                Notiflix.Loading.remove();
                if (xhr.status === 422) {
                    if (xhr.responseJSON.errors) {
                        Object.values(xhr.responseJSON.errors).forEach(error => {
                            Notiflix.Notify.failure(error[0]);
                        });
                    } else {
                        Notiflix.Notify.failure(xhr.responseJSON.msg);
                    }
                } else {
                    Notiflix.Notify.failure(
                        xhr.responseJSON?.msg ?? "Terjadi kesalahan pada server."
                    );
                }
            } finally {
                $(".btn").prop("disabled", false);

            }

        };


        async function loadHistory() {
            const tbody = document.getElementById("historyAbsen");
            tbody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center">
                <i class="fa fa-spinner fa-spin"></i> Memuat data...
            </td>
        </tr>
    `;
            try {
                const response = await fetch("absensi-guru-api", {
                    method: "GET",
                    headers: {
                        "Accept": "application/json",
                    }
                });
                const result = await response.json();
                if (!result.status) {
                    Notiflix.Notify.failure(result.msg);

                    tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada data
                    </td>
                </tr>
            `;
                    return;
                }
                if (result.data.length === 0) {
                    tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data absensi
                    </td>
                </tr>
            `;
                    return;
                }

                tbody.innerHTML = "";
                result.data.forEach((item, index) => {
                    let status = "";
                    switch (item.status) {
                        case "H":
                            status = '<span class="label label-success">Hadir</span>';
                            break;

                        case "I":
                            status = '<span class="label label-warning">Izin</span>';
                            break;

                        case "S":
                            status = '<span class="label label-info">Sakit</span>';
                            break;

                        default:
                            status = '<span class="label label-danger">Alpha</span>';
                    }
                    tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.tanggal}</td>
                    <td>${item.jam_masuk ?? "-"}</td>
                    <td>${item.jam_keluar ?? "-"}</td>
                    <td>${status}</td>
                </tr>
            `;
                });

            } catch (error) {

                console.error(error);

                Notiflix.Notify.failure("Gagal mengambil data.");
                tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-danger">
                    Gagal memuat data.
                </td>
            </tr>
        `;
            }

        }
        async function checkAbsen() {

            try {

                const response = await fetch("absensi-guru-api/check-status", {
                    headers: {
                        "Accept": "application/json"
                    }
                });

                const result = await response.json();

                const today = result.today;
                if (!today) {
                    $("#jamMasuk").text("--:--:--");
                    $("#jamKeluar").text("--:--:--");
                    $("#btnMasuk")
                        .prop("disabled", false)
                        .removeClass("btn-default")
                        .addClass("btn-success");

                    $("#iconMasuk")
                        .removeClass("fa-check")
                        .addClass("fa-sign-in");

                    $("#btnKeluar")
                        .prop("disabled", true)
                        .removeClass("btn-default")
                        .addClass("btn-primary");

                    $("#iconKeluar")
                        .removeClass("fa-check")
                        .addClass("fa-sign-out");
                    return;
                }

                $("#jamMasuk").text(today.jam_masuk ?? "--:--:--");
                $("#jamKeluar").text(today.jam_keluar ?? "--:--:--");

                if (today.jam_masuk && !today.jam_keluar) {
                    $("#btnMasuk")
                        .attr("disabled", true)
                        .prop("disabled", true)
                        .removeClass("btn-success")
                        .addClass("btn-default");

                    $("#iconMasuk")
                        .removeClass("fa-sign-in")
                        .addClass("fa-check");

                    $("#btnKeluar")
                        .removeAttr("disabled")
                        .prop("disabled", false);

                } else if (today.jam_keluar) {

                    $("#btnMasuk")
                        .attr("disabled", true)
                        .prop("disabled", true)
                        .removeClass("btn-success")
                        .addClass("btn-default");

                    $("#iconMasuk")
                        .removeClass("fa-sign-in")
                        .addClass("fa-check");

                    $("#btnKeluar")
                        .attr("disabled", true)
                        .prop("disabled", true)
                        .removeClass("btn-primary")
                        .addClass("btn-default");

                    $("#iconKeluar")
                        .removeClass("fa-sign-out")
                        .addClass("fa-check");
                }

            } catch (error) {
                console.error(error);
                Notiflix.Notify.failure("Gagal mengecek status absensi.");

            }

        }
    </script>
@endsection
