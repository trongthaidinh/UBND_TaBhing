@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Sơ Đồ Cổng</h1>
    
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 space-y-4">
        <div class="border-l-4 border-blue-500 pl-4 py-2">
            <div 
                x-data="{ isOpen: true }"
                class="cursor-pointer select-none"
            >
                <div 
                    @click="isOpen = !isOpen" 
                    class="flex items-center justify-between text-lg font-semibold text-gray-700 hover:text-blue-600 transition duration-300"
                >
                    <div class="flex items-center">
                        <svg 
                            x-show="!isOpen" 
                            class="w-5 h-5 mr-2 transform rotate-0 transition-transform" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <svg 
                            x-show="isOpen" 
                            class="w-5 h-5 mr-2 transform rotate-90 transition-transform" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span>Trang Chính</span>
                    </div>
                </div>
                
                <div 
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="pl-6 mt-2 space-y-2"
                >
                    <div class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <a href="{{ route('home') }}" class="text-current">Trang Chủ</a>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <a href="{{ route('posts.index') }}" class="text-current">Bài Viết</a>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="{{ route('contact.index') }}" class="text-current">Liên Hệ</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-l-4 border-green-500 pl-4 py-2">
            <div 
                x-data="{ isOpen: true }"
                class="cursor-pointer select-none"
            >
                <div 
                    @click="isOpen = !isOpen" 
                    class="flex items-center justify-between text-lg font-semibold text-gray-700 hover:text-green-600 transition duration-300"
                >
                    <div class="flex items-center">
                        <svg 
                            x-show="!isOpen" 
                            class="w-5 h-5 mr-2 transform rotate-0 transition-transform" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <svg 
                            x-show="isOpen" 
                            class="w-5 h-5 mr-2 transform rotate-90 transition-transform" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span>Danh Mục</span>
                    </div>
                </div>
                
                <div 
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="pl-6 mt-2 space-y-2"
                >
                    @php
                        $categories = \App\Models\Category::all();
                    @endphp
                    @foreach($categories as $category)
                        <div class="flex items-center space-x-3 text-gray-600 hover:text-green-600 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            <a href="{{ route('categories.show', $category->slug) }}" class="text-current">
                                {{ $category->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="border-l-4 border-purple-500 pl-4 py-2">
            <div 
                x-data="{ isOpen: true }"
                class="cursor-pointer select-none"
            >
                <div 
                    @click="isOpen = !isOpen" 
                    class="flex items-center justify-between text-lg font-semibold text-gray-700 hover:text-purple-600 transition duration-300"
                >
                    <div class="flex items-center">
                        <svg 
                            x-show="!isOpen" 
                            class="w-5 h-5 mr-2 transform rotate-0 transition-transform" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <svg 
                            x-show="isOpen" 
                            class="w-5 h-5 mr-2 transform rotate-90 transition-transform" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span>Tài Khoản</span>
                    </div>
                </div>
                
                <div 
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="pl-6 mt-2 space-y-2"
                >
                    <div class="flex items-center space-x-3 text-gray-600 hover:text-purple-600 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <a href="{{ route('profile.edit') }}" class="text-current">Hồ Sơ Cá Nhân</a>
                    </div>
                    
                    @guest
                        <div class="flex items-center space-x-3 text-gray-600 hover:text-purple-600 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <a href="{{ route('login') }}" class="text-current">Đăng Nhập</a>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-600 hover:text-purple-600 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <a href="{{ route('register') }}" class="text-current">Đăng Ký</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush