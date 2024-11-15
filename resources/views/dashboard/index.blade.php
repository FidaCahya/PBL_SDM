@extends('layouts.template')

@section('content')
<div class="content-wrapper" style="margin-left: 0;">
    <section class="content">
        <div class="container-fluid px-3">
            <div class="row mb-3">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalProgramTerdaftar }}</h3>
                            <p>Program Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $totalKegiatan }}</h3>
                            <p>Total Kegiatan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalPenggunaAktif }}</h3>
                            <p>Pengguna Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Progress Kegiatan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Beban Kerja</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kegiatan as $kegiatanItem)
                            <tr>
                                <td>{{ $kegiatanItem->nama_kegiatan }}</td>
                                <td>{{ $kegiatanItem->jenis_kegiatan->nama_jenis_kegiatan }}</td>
                                <td>{{ $kegiatanItem->tanggal_mulai }}</td>
                                <td>{{ $kegiatanItem->tanggal_selesai }}</td>
                                <td>{{ $kegiatanItem->bobot_kerja }}</td>
                                <td>
                                    <div class="progress">
                                        @php
                                            // Ambil progress terakhir jika ada
                                            $lastProgress = $kegiatanItem->progress_kegiatan->last(); 
                                        @endphp
                                        <div class="progress-bar bg-warning" style="width: {{ $lastProgress ? $lastProgress->update_progress : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Statistik Kegiatan</h3>
                </div>
                <div class="card-body">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Aktivitas Terbaru</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Progress</th>
                                <th>Tanggal dan Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentActivities as $activity)
                            <tr>
                                <td>{{ $activity->nama_kegiatan ?? 'Kegiatan tidak ditemukan' }}</td>
                                <td>{{ $activity->update_progress }}%</td>
                                <td>{{ $activity->created_at->format('d/m/Y, H:i') }} WIB</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Script to initialize the chart
    const ctx = document.getElementById('activityChart').getContext('2d');
    const years = {!! json_encode($years) !!}; // Menggunakan json_encode untuk mengonversi PHP array ke JavaScript array
    const months = {!! json_encode($months) !!}; // Pastikan ini ditulis dengan benar
    const dataCounts = {!! json_encode($dataCounts) !!}; // Menggunakan json_encode untuk mengonversi PHP array ke JavaScript array
    
    // Siapkan data untuk grafik
    const datasets = years.map(year => {
        return {
            label: year.toString(), // Menyimpan tahun sebagai label
            data: months.map((_, monthIndex) => dataCounts[year][monthIndex + 1] || 0), // Mengambil data untuk setiap bulan
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            fill: true
        };
    });
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months, // Menggunakan nama bulan dari PHP
            datasets: datasets // Menggunakan data yang diambil dari database
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Kegiatan'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });
    </script>
@endsection