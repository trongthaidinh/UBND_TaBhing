@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển')
@section('page_title', 'Tổng Quan Hệ Thống')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .dashboard-card {
        @apply bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1;
    }
    .dashboard-icon {
        @apply text-4xl opacity-70 text-primary-light;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Visits Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="dashboard-card p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-700">Lượt Truy Cập Hôm Nay</h2>
                    <p class="text-3xl font-bold text-primary">{{ $todayVisits }}</p>
                </div>
                <i class="ri-line-chart-line dashboard-icon"></i>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <span class="text-green-600">
                    {{ number_format(($todayVisits / max($totalVisits, 1)) * 100, 2) }}% 
                    tổng lượt truy cập
                </span>
            </div>
        </div>
        
        <div class="dashboard-card p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-700">Tổng Lượt Truy Cập</h2>
                    <p class="text-3xl font-bold text-primary">{{ $totalVisits }}</p>
                </div>
                <i class="ri-bar-chart-line dashboard-icon"></i>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <span class="text-blue-600">
                    Tổng số lượt truy cập từ trước đến nay
                </span>
            </div>
        </div>
    </div>

    {{-- Content Statistics Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
        $contentTypes = [
            'posts' => ['icon' => 'ri-article-line', 'title' => 'Bài Viết', 'route' => 'admin.posts.index'],
            'photos' => ['icon' => 'ri-image-line', 'title' => 'Thư Viện Ảnh', 'route' => 'admin.photo-library.index'],
            'videos' => ['icon' => 'ri-video-line', 'title' => 'Video', 'route' => 'admin.videos.index'],
            'links' => ['icon' => 'ri-link', 'title' => 'Liên Kết', 'route' => 'admin.external-links.index']
        ];
        @endphp

        @foreach($contentTypes as $type => $config)
        <div class="dashboard-card p-6">
            <a href="{{ route($config['route']) }}" class="block">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $config['title'] }}</h3>
                        <p class="text-3xl font-bold text-primary">{{ $contentStats[$type]['total'] }}</p>
                    </div>
                    <i class="{{ $config['icon'] }} dashboard-icon"></i>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <span class="text-green-600">
                        {{ $contentStats[$type]['published'] ?? $contentStats[$type]['active'] }} 
                        {{ $type == 'links' ? 'đang hoạt động' : 'đã xuất bản' }}
                    </span>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Content Distribution Chart --}}
        <div class="dashboard-card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Phân Bổ Nội Dung</h3>
            <canvas id="contentDistributionChart" class="w-full h-64"></canvas>
        </div>

        {{-- Monthly Content Trend --}}
        <div class="dashboard-card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Xu Hướng Nội Dung Năm {{ now()->year }}</h3>
            <canvas id="monthlyContentTrendChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Content Distribution Chart
    const distributionCtx = document.getElementById('contentDistributionChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Bài Viết', 'Ảnh', 'Video', 'Liên Kết'],
            datasets: [{
                data: [
                    {{ $contentStats['posts']['total'] }},
                    {{ $contentStats['photos']['total'] }},
                    {{ $contentStats['videos']['total'] }},
                    {{ $contentStats['links']['total'] }}
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',   // Soft Blue
                    'rgba(236, 72, 153, 0.7)',   // Soft Pink
                    'rgba(16, 185, 129, 0.7)',   // Soft Green
                    'rgba(245, 158, 11, 0.7)'    // Soft Amber
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(236, 72, 153, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Monthly Content Trend Chart
    const trendCtx = document.getElementById('monthlyContentTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [
                {
                    label: 'Bài Viết',
                    data: {{ json_encode($monthlyContentTrend['posts']) }},
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4
                },
                {
                    label: 'Ảnh',
                    data: {{ json_encode($monthlyContentTrend['photos']) }},
                    borderColor: 'rgba(236, 72, 153, 1)',
                    backgroundColor: 'rgba(236, 72, 153, 0.2)',
                    tension: 0.4
                },
                {
                    label: 'Video',
                    data: {{ json_encode($monthlyContentTrend['videos']) }},
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush