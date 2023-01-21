@if ($paginator->hasPages())

    <nav role="navigation" aria-label="Pagination Navigation" aria-label="flex items-center justify-between">

        <ul class="flex flex-1">

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 leading-5">
                        <span>{!! __('Mostrando del') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('al') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('de') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('resultados') !!}</span>
                    </p>
                </div>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-l-lg">«
                            Anterior
                        </span>
                    @else
                        <a class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 rounded-l-lg focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 hover:bg-gray-200"
                            href="{{ $paginator->previousPageUrl() }}">« Anterior</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 select-none">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($elements))
                            @foreach ($elements as $element)
                                @if (is_string($element))
                                    <span aria-disabled="true">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 select-none">{{ $element }}</span>
                                    </span>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        <span>
                                            @if ($page == $paginator->currentPage())
                                                <span aria-current="page">
                                                    <a
                                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white border border-gray-300 cursor-default leading-5 select-none bg-blue-600">{{ $page }}</a>
                                                </span>
                                            @else
                                                <a class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 hover:bg-gray-200"
                                                    href="{{ $url }}">{{ $page }}</a>
                                            @endif
                                        </span>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    <span>
                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <a class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 rounded-r-lg focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 hover:bg-gray-200"
                                href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente »</a>
                        @else
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-r-lg"
                                href="#">Siguiente »
                            </span>
                        @endif
                    </span>
                </span>
            </div>

        </ul>

@endif
