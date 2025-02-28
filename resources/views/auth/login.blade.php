<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full mt-6 px-6 py-8 overflow-hidden sm:rounded-lg">
            <div class="flex flex-col items-center mb-6">
                <div class="logo mb-4">
                    <img src="{{ asset('images/quochuy.png') }}" alt="Quốc Huy" class="h-[80px] w-auto mx-auto">
                </div>
                <div class="header-text text-center">
                    <div class="text-xs font-bold text-primary uppercase font-nunito">
                        Ủy Ban Nhân Dân Huyện Nam Giang
                    </div>
                    <div class="text-sm font-bold text-primary uppercase font-merriweather leading-tight">
                        Trang Thông Tin Điện Tử Xã Chà Vàl
                    </div>
                </div>
            </div>

            <!-- Trạng thái phiên -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Địa chỉ Email -->
                <div>
                    <x-input-label for="email" :value="__('Địa chỉ Email')" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mật khẩu -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mật khẩu')" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Ghi nhớ đăng nhập -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" 
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                               name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ghi nhớ đăng nhập') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                           href="{{ route('password.request') }}">
                            {{ __('Quên mật khẩu?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Đăng nhập') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
