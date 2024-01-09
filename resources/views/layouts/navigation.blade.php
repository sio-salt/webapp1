<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-slate-500">
        <div class="flex-col sm:flex-row">
            <div>
                <div class="flex justify-between items-center h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <!--<div class="shrink-0 flex items-center">-->
                        <div class="shrink-0 items-center">
                            <a href="{{ route('recent_post') }}" class="md:pl-2 py-1 rounded font-bold text-xl text-white">山形大学 勉強会 掲示板</a>
                        </div>
        
                    </div>
                    <div class="flex mx-auto space-x-4">
                        <!-- Navigation Links -->
                        <div class="hidden justify-start sm:space-x-8 sm:-my-px sm:ml-10 sm:flex px-3 py-1 rounded">
                            <x-nav-link :href="route('recent_post')" :active="request()->routeIs('recent_post', 'home')" class="text-white text-lg font-bold flex-shrink-0">
                                {{ __('Latest') }}
                            </x-nav-link>
                            <x-nav-link :href="route('tag_search')" :active="request()->routeIs('tag_search')" class="text-white text-lg font-bold flex-shrink-0">
                                {{ __('Tag Search') }}
                            </x-nav-link>
                        </div>
                    </div>
        
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        {{--
                        <a href="{{ route('help') }}" class="px-1.5 py-1 bg-white text-black rounded border border-black">ⓘ</a>
                        --}}
                        @auth
                        <div class="flex space-x-4">
                            <a href="{{ route('posts.create') }}" class="ml-4 px-2 py-1 rounded bg-sky-500 text-white border border-black hover:bg-sky-600 active:bg-sky-700 focus:outline-none focus:ring :ring-indigo-500">{{ __('▶ New Post') }}</a>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>
            
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
            
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
            
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
            
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        @endauth
                        
                        @guest
                        <div class="flex gap-x-4 space-x-1">
                            <a href="{{ route('login') }}" class="ml-4 px-3 py-1 rounded bg-sky-500 text-white border border-black">{{ __('Log in') }}</a>
                            <a href="{{ route('register') }}" class="px-3 py-1 rounded bg-gray-500 text-white border border-black">{{ __('Register') }}</a>
                        </div>
                        @endguest
                    </div>
        
                    <!-- Hamburger -->
                    <div class="flex items-center sm:hidden bg-white rounded-md">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex block sm:hidden justify-between items-center">
                <div class="mx-auto space-x-4 h-10">
                    <x-nav-link :href="route('recent_post')" :active="request()->routeIs('recent_post', 'home')" class="text-white text-sm font-bold flex-shrink-0">
                        {{ __('Latest') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tag_search')" :active="request()->routeIs('tag_search')" class="text-white text-sm font-bold flex-shrink-0">
                        {{ __('Tag Search') }}
                    </x-nav-link>
                </div>
                
                @auth
                    <div class="flex space-x-4 pb-1">
                        <a href="{{ route('posts.create') }}" class="ml-4 px-2 py-1 rounded bg-sky-500 text-base text-white border border-black hover:bg-sky-600 active:bg-sky-700 focus:outline-none focus:ring :ring-indigo-500">{{ __('▶ New Post') }}</a>
                    </div>
                @endauth
            </div>
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

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
