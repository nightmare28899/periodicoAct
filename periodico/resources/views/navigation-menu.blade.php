<nav x-data="{ open: false }" class="border-b bg-white border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-jet-nav-link class="text-gray-700 hover:text-gray-400" href="{{ route('dashboard') }}"
                        :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">

                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-gray-400 focus:outline-none transition">
                                    Menú

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content" class="w-full text-center">
                            <a href="{{ url('cliente') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Cliente') }}</button></a>
                            <a href="{{ url('ruta') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Ruta') }}</button></a>
                            <a href="{{ url('tarifa') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Tarifa') }}</button></a>
                            <a href="{{ url('tiro') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Tiro') }}</button></a>
                            <a href="{{ url('remisiones') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Generar Remisión') }}</button></a>
                            <a href="{{ url('historialR' . '/normal') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Historial Remisiones') }}</button></a>
                            <a href="{{ url('Facturas') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Facturas') }}</button></a>
                            <a href="{{ url('FacturasPPD') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Facturas PPD') }}</button></a>
                            <a href="{{ url('historialF') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Historial Facturas') }}</button></a>
                            <a href="{{ url('historialComplementoPago') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Historial Complemento Pago') }}</button></a>
                            <a href="{{ url('historialR' . '/editar/') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Editar Domicilios Suscripciones Activas') }}</button></a>
                            <a href="{{ url('agregarDiasSuscripcion') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Agregar Días al Contrato') }}</button></a>
                            <a href="{{ url('suspenderSuscripcion') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Suspención Suscripción') }}</button></a>
                            <a href="{{ url('CancelarVenta' . '/venta') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Cancelar Ventas') }}</button></a>
                            <a href="{{ url('CancelarSuscripciones' . '/suscri') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Cancelar Suscripciones') }}</button></a>
                        </x-slot>
                    </x-jet-dropdown>

                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">

                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-gray-400 focus:outline-none transition">
                                    Reportes

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content" class="w-full text-center">
                            <a href="{{ url('remisionesRangoFecha') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Remisiones Rango Fecha') }}</button></a>
                            <a href="{{ url('devolucionInforme') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Devoluciones Ventas') }}</button></a>
                            <a href="{{ url('reporte-relacionCR') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Relación Clientes por Ruta') }}</button></a>
                            <a href="{{ url('reporteSuscripcionSuspendida') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Suscripciones Suspendidas') }}</button></a>
                            <a href="{{ url('reporteSuscripcionVencimiento') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Suscripciones Vencimiento') }}</button></a>
                            <a href="{{ url('historialVentas') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Historial Ventas') }}</button></a>
                            <a href="{{ url('historialSuscripciones') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Historial Suscripciones') }}</button></a>
                            <a href="{{ url('reportVentaPFacturas') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Facturas') }}</button></a>
                            <a href="{{ url('reporteSaldos') }}"><button
                                    class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Reporte Saldos') }}</button></a>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700  hover:text-gray-400 focus:outline-none transition">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link
                                        href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-gray-500 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
