<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                         <img src="{{ asset('images/wiralab-logo.png') }}" alt="Wiralab Logo" class="block h-12 w-auto"> {{-- Logo Wiralab --}}
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Admin Links --}}
                    {{-- Link ke Daftar Kategori --}}
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Kategori Produk') }}
                    </x-nav-link>

                    {{-- Link ke Daftar Item (diganti dari products ke items) --}}
                    <x-nav-link :href="route('admin.items.index')" :active="request()->routeIs('admin.items.*')">
                        {{ __('Produk') }} {{-- Ganti teks jika perlu --}}
                    </x-nav-link>

                    {{-- Link Blog (Gunakan route name yg benar jika sudah dibuat) --}}
                    <x-nav-link :href="route('admin.blog.index')" :active="request()->routeIs('admin.blog.*')">
                        {{ __('Blog') }}
                    </x-nav-link>

                    {{-- Link Pelatihan (Placeholder) --}}
                    <x-nav-link href="#" :active="request()->is('admin/pelatihan*')">
                        {{ __('Pelatihan') }}
                    </x-nav-link>

                    {{-- Link E-Katalog (Placeholder) --}}
                    <x-nav-link href="#" :active="request()->is('admin/e-katalog*')">
                        {{ __('E-Katalog') }}
                    </x-nav-link>

                    {{-- Link Karir (Gunakan route name yg benar jika sudah dibuat) --}}
                    <x-nav-link :href="route('admin.careers.index')" :active="request()->routeIs('admin.careers.*')">
                        {{ __('Karir') }}
                    </x-nav-link>

                    {{-- Link Kontak (Placeholder) --}}
                    <x-nav-link href="#" :active="request()->is('admin/kontak*')">
                        {{ __('Kontak') }}
                    </x-nav-link>
                    {{-- End Admin Links --}}
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- Tombol Dark Mode --}}
                <button id="theme-toggle" type="button" class="ms-3 inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <span class="sr-only">Toggle dark mode</span>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

             {{-- Responsive Admin Links --}}
             <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                 {{ __('Kategori') }}
             </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('admin.items.index')" :active="request()->routeIs('admin.items.*')">
                 {{ __('Produk/Aplikasi') }}
             </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('admin.blog.index')" :active="request()->routeIs('admin.blog.*')">
                 {{ __('Blog') }}
             </x-responsive-nav-link>
             <x-responsive-nav-link href="#" :active="request()->is('admin/pelatihan*')">
                 {{ __('Pelatihan') }}
             </x-responsive-nav-link>
             <x-responsive-nav-link href="#" :active="request()->is('admin/e-katalog*')">
                 {{ __('E-Katalog') }}
             </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('admin.careers.index')" :active="request()->routeIs('admin.careers.*')">
                 {{ __('Karir') }}
             </x-responsive-nav-link>
             <x-responsive-nav-link href="#" :active="request()->is('admin/kontak*')">
                 {{ __('Kontak') }}
             </x-responsive-nav-link>
            {{-- End Responsive Admin Links --}}
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>