@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="w-full">

        <div class="flex gap-2 items-center justify-between sm:hidden">

            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed leading-5 rounded-xl">
                    &laquo; {{ app()->getLocale() === 'en' ? 'Previous' : 'Sebelumnya' }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 leading-5 rounded-xl hover:text-[#0e7c47] hover:bg-emerald-50 focus:outline-none transition ease-in-out duration-150 shadow-2xs">
                    &laquo; {{ app()->getLocale() === 'en' ? 'Previous' : 'Sebelumnya' }}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 leading-5 rounded-xl hover:text-[#0e7c47] hover:bg-emerald-50 focus:outline-none transition ease-in-out duration-150 shadow-2xs">
                    {{ app()->getLocale() === 'en' ? 'Next' : 'Selanjutnya' }} &raquo;
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed leading-5 rounded-xl">
                    {{ app()->getLocale() === 'en' ? 'Next' : 'Selanjutnya' }} &raquo;
                </span>
            @endif

        </div>

        <div class="hidden sm:flex-1 sm:flex sm:gap-2 sm:items-center sm:justify-between bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs">

            <div>
                <p class="text-xs sm:text-sm text-slate-600 leading-5">
                    @if(app()->getLocale() === 'en')
                        Showing
                        @if ($paginator->firstItem())
                            <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span>
                            to
                            <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span>
                        @else
                            {{ $paginator->count() }}
                        @endif
                        of
                        <span class="font-bold text-slate-900">{{ $paginator->total() }}</span>
                        results
                    @else
                        Menampilkan
                        @if ($paginator->firstItem())
                            <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span>
                            sampai
                            <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span>
                        @else
                            {{ $paginator->count() }}
                        @endif
                        dari
                        <span class="font-bold text-slate-900">{{ $paginator->total() }}</span>
                        penawaran
                    @endif
                </p>
            </div>

            <div>
                <span class="inline-flex rtl:flex-row-reverse shadow-2xs rounded-xl overflow-hidden border border-slate-200">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center px-3 py-2 text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed leading-5" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-2 text-xs font-bold text-slate-700 bg-white leading-5 hover:text-[#0e7c47] hover:bg-emerald-50 focus:outline-none transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-3.5 py-2 -ml-px text-xs font-bold text-slate-400 bg-slate-50 border-l border-slate-200 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-3.5 py-2 -ml-px text-xs font-black text-white bg-[#0e7c47] border-l border-slate-200 cursor-default leading-5 shadow-xs">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-3.5 py-2 -ml-px text-xs font-bold text-slate-700 bg-white border-l border-slate-200 leading-5 hover:text-[#0e7c47] hover:bg-emerald-50 focus:outline-none transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-2 -ml-px text-xs font-bold text-slate-700 bg-white border-l border-slate-200 leading-5 hover:text-[#0e7c47] hover:bg-emerald-50 focus:outline-none transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center px-3 py-2 -ml-px text-xs font-bold text-slate-300 bg-slate-50 border-l border-slate-200 cursor-not-allowed leading-5" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif

                </span>
            </div>
        </div>
    </nav>
@endif
