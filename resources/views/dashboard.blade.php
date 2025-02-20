@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển')
@section('page_title', 'Tổng Quan Hệ Thống')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    {{-- Content Statistics --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Bài Viết</h3>
                <p class="text-3xl font-bold text-primary">{{ App\Models\Post::count() }}</p>
            </div>
            <i class="ri-article-line text-4xl text-primary-light"></i>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-green-600">
                {{ App\Models\Post::where('created_at', '>=', now()->subDays(7))->count() }} 
                mới trong 7 ngày
            </span>
        </div>
    </div>

    {{-- Photo Library Statistics --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Thư Viện Ảnh</h3>
                <p class="text-3xl font-bold text-primary">{{ App\Models\PhotoLibrary::count() }}</p>
            </div>
            <i class="ri-image-line text-4xl text-primary-light"></i>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-green-600">
                {{ App\Models\PhotoLibrary::where('status', 'published')->count() }} 
                đã xuất bản
            </span>
        </div>
    </div>

    {{-- Video Statistics --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Video</h3>
                <p class="text-3xl font-bold text-primary">{{ App\Models\Video::count() }}</p>
            </div>
            <i class="ri-video-line text-4xl text-primary-light"></i>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-green-600">
                {{ App\Models\Video::where('status', 'published')->count() }} 
                đã xuất bản
            </span>
        </div>
    </div>

    {{-- External Links Statistics --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Liên Kết</h3>
                <p class="text-3xl font-bold text-primary">{{ App\Models\ExternalLink::count() }}</p>
            </div>
            <i class="ri-link text-4xl text-primary-light"></i>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-green-600">
                {{ App\Models\ExternalLink::where('is_active', true)->count() }} 
                đang hoạt động
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Content Distribution Chart --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Phân Bổ Nội Dung</h3>
        <canvas id="contentDistributionChart"></canvas>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Hoạt Động Gần Đây</h3>
        <div class="space-y-4">
            @php
            $recentPosts = App\Models\Post::latest()->take(5)->get();
            $recentPhotos = App\Models\PhotoLibrary::latest()->take(5)->get();
            $recentVideos = App\Models\Video::latest()->take(5)->get();
            $activities = collect()
                ->merge($recentPosts->map(function($item) { 
                    return ['type' => 'Bài Viết', 'title' => $item->title, 'created_at' => $item->created_at]; 
                }))
                ->merge($recentPhotos->map(function($item) { 
                    return ['type' => 'Ảnh', 'title' => $item->title, 'created_at' => $item->created_at]; 
                }))
                ->merge($recentVideos->map(function($item) { 
                    return ['type' => 'Video', 'title' => $item->title, 'created_at' => $item->created_at]; 
                }))
                ->sortByDesc('created_at')
                ->take(5);
            @endphp

            @foreach($activities as $activity)
            <div class="flex items-center justify-between border-b pb-2 last:border-b-0">
                <div>
                    <span class="text-sm font-medium text-gray-600">{{ $activity['type'] }}</span>
                    <p class="text-sm text-gray-900">{{ Str::limit($activity['title'], 30) }}</p>
                </div>
                <span class="text-xs text-gray-500">
                    {{ $activity['created_at']->diffForHumans() }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Content Distribution Chart
    const ctx = document.getElementById('contentDistributionChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Bài Viết', 'Ảnh', 'Video', 'Liên Kết'],
            datasets: [{
                data: [
                    {{ App\Models\Post::count() }},
                    {{ App\Models\PhotoLibrary::count() }},
                    {{ App\Models\Video::count() }},
                    {{ App\Models\ExternalLink::count() }}
                ],
                backgroundColor: [
                    // Soft, sophisticated color palette
                    'rgba(59, 130, 246, 0.7)',   // Soft Blue (Posts)
                    'rgba(236, 72, 153, 0.7)',   // Soft Pink (Photos)
                    'rgba(16, 185, 129, 0.7)',   // Soft Green (Videos)
                    'rgba(245, 158, 11, 0.7)'    // Soft Amber (External Links)
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
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'rgba(0, 0, 0, 0.7)',
                        font: {
                            size: 12,
                            family: "'Nunito', sans-serif"
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Phân Bổ Nội Dung',
                    color: 'rgba(0, 0, 0, 0.8)',
                    font: {
                        size: 16,
                        family: "'Nunito', sans-serif",
                        weight: 'bold'
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection