@extends('layouts.app')

@section('title', 'Overview KPI Marketing - Trusmi Group')

@section('content')
    @php
        $totalTask = collect($statusLeadtime)->sum('jumlah');
        $ontimeData = collect($statusLeadtime)->firstWhere('status', 'Ontime');
        $lateData = collect($statusLeadtime)->firstWhere('status', 'Late');
        $rataRataKpi = count($kpiKaryawan) > 0 ? round(collect($kpiKaryawan)->avg('kpi_akhir'), 1) : 0;
    @endphp

    <!-- Page Header -->
    <div id="overview" class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Overview</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan performa pencapaian KPI & ketepatan leadtime divisi Marketing.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-7">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/70 shadow-[0_2px_10px_-3px_rgba(15,23,42,0.03)] flex flex-col justify-between">
            <div class="text-sm font-medium text-slate-500">Total Karyawan Marketing</div>
            <div class="mt-5 flex items-center justify-between">
                <div class="text-3xl font-bold text-slate-900">{{ count($kpiKaryawan) }}</div>
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/70 shadow-[0_2px_10px_-3px_rgba(15,23,42,0.03)] flex flex-col justify-between">
            <div class="text-sm font-medium text-slate-500">Rata-Rata Skor KPI Divisi</div>
            <div class="mt-5 flex items-center justify-between">
                <div class="text-3xl font-bold text-slate-900">{{ $rataRataKpi }}%</div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Aktif
                </span>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-7">
        
        <!-- Grafik Soal 3 -->
        <div id="grafik-soal-3" class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/70 shadow-[0_2px_10px_-3px_rgba(15,23,42,0.03)] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Grafik Pencapaian KPI Karyawan (Soal 3)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan Total Bobot Sales, Report, dan Skor KPI Akhir</p>
                </div>
                <a href="#tabel-soal-1" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">Lihat Detail &rarr;</a>
            </div>
            <div class="relative h-80 w-full">
                <canvas id="kpiChart"></canvas>
            </div>
        </div>

        <!-- Grafik Soal 4 -->
        <div id="grafik-soal-4" class="bg-white rounded-2xl p-6 border border-slate-200/70 shadow-[0_2px_10px_-3px_rgba(15,23,42,0.03)] flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                    <h2 class="text-base font-bold text-slate-900">Ketepatan Leadtime (Soal 4)</h2>
                </div>

                <div class="bg-slate-50/90 rounded-xl p-4 text-center border border-slate-100 mb-4">
                    <div class="text-3xl font-extrabold text-slate-900">{{ $totalTask }}</div>
                    <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mt-1">Total Tasklist Marketing</div>
                </div>

                <div class="relative h-44 my-2 flex items-center justify-center">
                    <canvas id="leadtimeChart"></canvas>
                </div>
            </div>

            <div class="space-y-2.5 mt-4">
                <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-emerald-50/70 border border-emerald-100 text-sm">
                    <span class="font-semibold text-emerald-800 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Ontime ({{ $ontimeData->persentase ?? 0 }}%)
                    </span>
                    <span class="font-bold text-emerald-900">{{ $ontimeData->jumlah ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-primary/5 border border-primary/15 text-sm">
                    <span class="font-semibold text-slate-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        Late ({{ $lateData->persentase ?? 0 }}%)
                    </span>
                    <span class="font-bold text-primary">{{ $lateData->jumlah ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekapitulasi KPI -->
    <div id="tabel-soal-1" class="bg-white rounded-2xl border border-slate-200/70 shadow-[0_2px_10px_-3px_rgba(15,23,42,0.03)] overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Rekapitulasi Perhitungan KPI (Data Soal 1)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Detail target, pencapaian, bobot kategori, dan pengurangan keterlambatan</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm text-center">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        <th rowspan="2" class="px-6 py-3.5 text-left border-r border-slate-100">Nama Karyawan</th>
                        <th colspan="6" class="px-4 py-2 text-primary bg-primary/8 border-r border-slate-100">Sales (50%)</th>
                        <th colspan="6" class="px-4 py-2 text-slate-700 bg-slate-100/80 border-r border-slate-100">Report (50%)</th>
                        <th rowspan="2" class="px-5 py-3.5 text-slate-700">Skor KPI</th>
                    </tr>
                    <tr class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 bg-slate-50/40 border-t border-slate-100">
                        <th class="px-3 py-2.5">Target</th>
                        <th class="px-3 py-2.5">Actual</th>
                        <th class="px-3 py-2.5">Achieve</th>
                        <th class="px-3 py-2.5">Bobot</th>
                        <th class="px-3 py-2.5">Late</th>
                        <th class="px-3 py-2.5 border-r border-slate-100 text-slate-600">Total</th>
                        <th class="px-3 py-2.5">Target</th>
                        <th class="px-3 py-2.5">Actual</th>
                        <th class="px-3 py-2.5">Achieve</th>
                        <th class="px-3 py-2.5">Bobot</th>
                        <th class="px-3 py-2.5">Late</th>
                        <th class="px-3 py-2.5 border-r border-slate-100 text-slate-600">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($kpiKaryawan as $row)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 font-semibold text-left text-slate-900 border-r border-slate-100">
                                {{ $row->nama }}
                            </td>

                            <!-- Sales -->
                            <td class="px-3 py-4 text-slate-600">{{ $row->target_sales }}</td>
                            <td class="px-3 py-4 text-slate-600">{{ $row->actual_sales }}</td>
                            <td class="px-3 py-4 text-slate-600">{{ $row->pencapaian_sales }}%</td>
                            <td class="px-3 py-4 text-slate-600">{{ $row->bobot_sales }}%</td>
                            <td class="px-3 py-4 {{ $row->late_sales < 0 ? 'text-primary font-semibold' : 'text-slate-400' }}">
                                {{ $row->late_sales }}%
                            </td>
                            <td class="px-3 py-4 font-bold text-slate-800 border-r border-slate-100">
                                {{ $row->total_bobot_sales }}%
                            </td>

                            <!-- Report -->
                            <td class="px-3 py-4 text-slate-600">{{ $row->target_report }}</td>
                            <td class="px-3 py-4 text-slate-600">{{ $row->actual_report }}</td>
                            <td class="px-3 py-4 text-slate-600">{{ $row->pencapaian_report }}%</td>
                            <td class="px-3 py-4 text-slate-600">{{ $row->actual_bobot_report }}%</td>
                            <td class="px-3 py-4 {{ $row->late_report < 0 ? 'text-primary font-semibold' : 'text-slate-400' }}">
                                {{ $row->late_report }}%
                            </td>
                            <td class="px-3 py-4 font-bold text-slate-800 border-r border-slate-100">
                                {{ $row->total_bobot_report }}%
                            </td>

                            <!-- KPI Akhir Badge -->
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $row->kpi_akhir >= 80 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $row->kpi_akhir }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    Chart.register(ChartDataLabels);

    const kpiData = @json($kpiKaryawan);
    const leadtimeData = @json($statusLeadtime);

    new Chart(document.getElementById('kpiChart'), {
        type: 'bar',
        data: {
            labels: kpiData.map(item => item.nama),
            datasets: [
                {
                    label: 'Total Bobot Sales (%)',
                    data: kpiData.map(item => Number(item.total_bobot_sales)),
                    backgroundColor: '#475569',
                    borderRadius: 6,
                    barPercentage: 0.75
                },
                {
                    label: 'Total Bobot Report (%)',
                    data: kpiData.map(item => Number(item.total_bobot_report)),
                    backgroundColor: '#94a3b8',
                    borderRadius: 6,
                    barPercentage: 0.75
                },
                {
                    label: 'Skor KPI Akhir (%)',
                    data: kpiData.map(item => Number(item.kpi_akhir)),
                    backgroundColor: '#e62129',
                    borderRadius: 6,
                    barPercentage: 0.75
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { top: 24 } },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 110,
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 11 },
                        callback: val => val <= 100 ? val + '%' : ''
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#334155', font: { weight: '600', size: 12 } }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, boxWidth: 8, padding: 20, font: { size: 12 } }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#334155',
                    font: { weight: 'bold', size: 11 },
                    formatter: val => val + '%'
                }
            }
        }
    });

    new Chart(document.getElementById('leadtimeChart'), {
        type: 'doughnut',
        data: {
            labels: leadtimeData.map(item => item.status),
            datasets: [{
                data: leadtimeData.map(item => Number(item.jumlah)),
                backgroundColor: leadtimeData.map(item => item.status === 'Ontime' ? '#10b981' : '#e62129'),
                borderWidth: 3,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '66%',
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#ffffff',
                    font: { weight: 'bold', size: 11 },
                    formatter: (val, ctx) => `${leadtimeData[ctx.dataIndex].persentase}%`
                }
            }
        }
    });
</script>
@endpush