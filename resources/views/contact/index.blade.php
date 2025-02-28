@extends('layouts.app')

@section('content')
<div class="w-full mx-auto">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-primary text-white py-4 px-6">
            <h1 class="text-2xl font-bold text-center">Liên Hệ UBND Xã</h1>
        </div>
        
        <div class="flex flex-col space-y-6 p-6">
            {{-- Contact Information --}}
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold text-primary mb-4 border-b pb-2">Thông Tin Liên Hệ</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-700">Địa Chỉ: UBND Xã [Tên Xã], Huyện [Tên Huyện]</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-700">Điện Thoại: [Số Điện Thoại]</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-lienjoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">Email: [Email Chính Thức]</span>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold text-primary mb-4 border-b pb-2">Gửi Tin Nhắn</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và Tên</label>
                        <input type="text" id="name" name="name" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Số Điện Thoại (Tùy chọn)</label>
                        <input type="tel" id="phone" name="phone" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Nội Dung Tin Nhắn</label>
                        <textarea id="message" name="message" rows="4" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <button type="submit" 
                            class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-primary-dark transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                            Gửi Tin Nhắn
                        </button>
                    </div>
                </form>
            </div>

            {{-- Google Maps Embed --}}
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold text-primary mb-4 border-b pb-2">Vị Trí</h3>
                <div class="aspect-w-16 aspect-h-9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3841.6855976687193!2d107.70058597459223!3d15.661721950219363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x316a0ce3658dbb1b%3A0x5b1db9046c6ac799!2sT%C3%A0%20B&#39;Hing%20Commune%20People&#39;s%20Committee!5e0!3m2!1sen!2s!4v1740706359337!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Add client-side form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const message = document.getElementById('message');

        if (!name.value.trim()) {
            e.preventDefault();
            alert('Vui lòng nhập Họ và Tên');
            name.focus();
            return;
        }

        if (!email.value.trim() || !email.value.includes('@')) {
            e.preventDefault();
            alert('Vui lòng nhập Email hợp lệ');
            email.focus();
            return;
        }

        if (!message.value.trim()) {
            e.preventDefault();
            alert('Vui lòng nhập Nội Dung Tin Nhắn');
            message.focus();
            return;
        }
    });
</script>
@endpush