<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-slate-500">
        <div class="flex justify-between h-16">
            <!--<div class="flex">-->
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('recent_post') }}" class="sm:pl-2 py-1 rounded font-bold sm:text-xl text-white">山大 勉強会 掲示板</a>
                </div>

                <!-- Settings Dropdown -->
                <div class="flex ml-6 items-center">
                    <div class="flex gap-x-4 space-x-1">
                        <!--<a href="{{ route('help') }}" class="flex px-1.5 py-1 bg-white text-black rounded border border-black">ⓘ</a>-->
                        
                        @guest
                            @if (request()->routeIs('register'))
                                <a href="{{ route('login') }}" class="ml-4 px-3 py-1 rounded bg-sky-500 text-white border border-black">{{ __('Log in') }}</a>
                            @endif
                            @if (request()->routeIs('login'))
                                <a href="{{ route('register') }}" class="flex px-3 py-1 rounded bg-gray-500 text-white border border-black">{{ __('Register') }}</a>
                            @endif
                        @endguest
                    </div>
                </div>
    
                <!-- Hamburger -->
                <!--<div class="-mr-2 flex items-center sm:hidden">-->
                <!--    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">-->
                <!--        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">-->
                <!--            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />-->
                <!--            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />-->
                <!--        </svg>-->
                <!--    </button>-->
                <!--</div>-->
            <!--</div>-->
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @guest
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Log in') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Register') }}
            </x-responsive-nav-link>
            @endguest
        </div>

    </div>
</nav>
