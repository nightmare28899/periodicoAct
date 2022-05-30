<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tiro') }}
        </h2>
    </x-slot>


    {{-- <x-slot name="header">
		<h2 class="text-center">Laravel 9 Livewire CRUD Demo</h2>
	</x-slot> --}}
    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-none mx-1 mt-3">
                        <div class="antialiased sans-serif">
                            <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                                <div class="container mx-auto px-4">
                                    <div class="mb-5 w-64">
                                        {{-- <label for="datepicker" class="font-bold mb-1 text-gray-700 block">Selecciona la
                                            fecha</label> --}}
                                        <div class="relative">
                                            <form>
                                                <input type="hidden" name="date" x-ref="date" wire:model='date'>
                                                <input type="text"
                                                    x-model="datepickerValue" @click="showDatepicker = !showDatepicker"
                                                    @keydown.escape="showDatepicker = false"
                                                    class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                                                    wire:model='date' id="date" name="date" placeholder="Select date">
                                                <input type="hidden" >
                                                <button wire:click.prevent="date()"
                                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">Enviar</button>
                                            </form>
                                            <div class="absolute top-0 right-0 px-3 py-2">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0"
                                                style="width: 17rem" x-show.transition="showDatepicker"
                                                @click.away="showDatepicker = false">
                                                <div class="flex justify-between items-center mb-2">
                                                    <div>
                                                        <span x-text="MONTH_NAMES[month]"
                                                            class="text-lg font-bold text-gray-800"></span>
                                                        <span x-text="year"
                                                            class="ml-1 text-lg text-gray-600 font-normal"></span>
                                                    </div>
                                                    <div>
                                                        <button type="button"
                                                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                                            :class="{ 'cursor-not-allowed opacity-25': month == 0 }"
                                                            :disabled="month == 0 ? true : false"
                                                            @click="month--; getNoOfDays()">
                                                            <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 19l-7-7 7-7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                                            :class="{ 'cursor-not-allowed opacity-25': month == 11 }"
                                                            :disabled="month == 11 ? true : false"
                                                            @click="month++; getNoOfDays()">
                                                            <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-wrap mb-3 -mx-1">
                                                    <template x-for="(day, index) in DAYS" :key="index">
                                                        <div style="width: 14.26%" class="px-1">
                                                            <div x-text="day"
                                                                class="text-gray-800 font-medium text-center text-xs">
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="flex flex-wrap -mx-1">
                                                    <template x-for="blankday in blankdays">
                                                        <div style="width: 14.28%"
                                                            class="text-center border p-1 border-transparent text-sm">
                                                        </div>
                                                    </template>
                                                    <template x-for="(date, dateIndex) in no_of_days"
                                                        :key="dateIndex">
                                                        <div style="width: 14.28%" class="px-1 mb-1">
                                                            <div @click="getDateValue(date)" x-text="date"
                                                                class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                                                :class="{
                                                                    'bg-blue-500 text-white': isToday(date) ==
                                                                        true,
                                                                    'text-gray-700 hover:bg-blue-200': isToday(
                                                                        date) == false
                                                                }">
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </class=>
                    </div>
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        <input wire:model='keyWord' type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Tiro">
                    </div>
                    {{-- <div class="flex-none mx-1">
                        <a href="{{ url('tarifa') }}"><button
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">{{ __('Tarifa') }}</button></a>
                    </div>
                    <div class="flex-none mx-1">
                        <a href="{{ url('ruta') }}"><button
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">{{ __('Ruta') }}</button></a>
                    </div>
                    <div class="flex-none mx-1">
                        <button wire:click="create()"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
                            Crear Cliente
                        </button>
                    </div> --}}
                </div>
                <br>
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                        role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- @if ($isModalOpen)
                    @include('livewire.clientes.create')
                @endif
                @if ($clienteModalOpen)
                    @include('livewire.domicilios.create')
                @endif
                @if ($ejemplarModalOpen)
                    @include('livewire.ejemplares.create')
                @endif
                @if ($detallesModalOpen)
                    @include('livewire.clientes.detalles')
                @endif --}}
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-slate-800 text-white">
                            <th class="px-4 py-2 w-20">No.</th>
                            <th class="px-4 py-2 w-20">Cliente</th>
                            <th class="px-4 py-2 w-20">Lunes</th>
                            <th class="px-4 py-2 w-20">Martes</th>
                            <th class="px-4 py-2 w-20">Miércoles</th>
                            <th class="px-4 py-2 w-20">Jueves</th>
                            <th class="px-4 py-2 w-20">Viernes</th>
                            <th class="px-4 py-2 w-20">Sábado</th>
                            <th class="px-4 py-2 w-20">Domingo</th>
                            <th class="px-4 py-2 w-20">Fecha</th>
                            <th class="px-4 py-2 w-20">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ejemplares as $ejemplar)
                            <tr>
                                <td class="border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $ejemplar->cliente_id }}</td>
                                <td class="border">{{ $ejemplar->lunes }}</td>
                                <td class="border">{{ $ejemplar->martes }}</td>
                                <td class="border">{{ $ejemplar->miercoles }}</td>
                                <td class="border">{{ $ejemplar->jueves }}</td>
                                <td class="border">{{ $ejemplar->viernes }}</td>
                                <td class="border">{{ $ejemplar->sabado }}</td>
                                <td class="border">{{ $ejemplar->domingo }}</td>
                                <td class="border">
                                    {{ \Carbon\Carbon::parse($ejemplar->created_at)->format('d/m/Y') }}</td>
                                <input type="hidden" id="dates"
                                    value="{{ \Carbon\Carbon::parse($ejemplar->created_at)->format('d/m/Y') }}">
                                <td class="border px-4 py-2 flex-nowrap pt-2">
                                    <x-jet-dropdown align="right" width="48">
                                        <x-slot name="trigger">

                                            <span class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                    Acciones

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </x-slot>

                                        <x-slot name="content">

                                            <button wire:click="date({{ $ejemplar->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-green-600 hover:text-white">Detalles</button>

                                            <div class="border-t border-gray-200"></div>

                                            <button wire:click="edit({{ $ejemplar->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">Editar</button>

                                            <div class="border-t border-gray-200"></div>

                                            <button wire:click="delete({{ $ejemplar->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-red-600 hover:text-white">Eliminar</button>

                                        </x-slot>
                                    </x-jet-dropdown>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{ $ejemplares->links() }}
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
    <script>
        const MONTH_NAMES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
            'Octubre', 'Noviembre', 'Deciembre'
        ];
        const DAYS = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

        function app() {
            return {
                showDatepicker: false,
                datepickerValue: '',

                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],

                initDate() {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                },
                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);

                    return today.toDateString() === d.toDateString() ? true : false;
                },
                getDateValue(date) {
                    let selectedDate = new Date(this.year, this.month, date);
                    this.datepickerValue = selectedDate.toDateString();
                    this.$refs.date.value = ('0' + selectedDate.getDate()).slice(-2) + "/" + ('0' + String(selectedDate
                            .getMonth() + 1)).slice(-2) +
                        "/" + selectedDate.getFullYear();

                    const fechas = document.getElementById("dates").value;
                    console.log('fecha del picker', this.$refs.date.value + " " + "fecha del input" + " " + selectedDate.getDate());
                    

                    this.showDatepicker = false;
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // find where to start calendar day of week
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                }
            }
        }
    </script>
</div>
