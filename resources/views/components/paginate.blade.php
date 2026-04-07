<div>
    <div class="flex justify-center items-center gap-2">
        @if($currentPage > 1)
            <a href="{{ $data->previousPageUrl() }}" class="w-6 h-6 text-xs border-2 border-zinc-100 text-zinc-900 rounded flex justify-center items-center">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
            </a>
        @endif

        @for($page = 1; $page <= $lastPage; $page++)
            <a href="{{ $data->url($page) }}" class="w-6 h-6 text-xs text-zinc-900 rounded flex justify-center items-center @if($page == $currentPage) bg-zinc-100 @endif">
                {{ $page }}
            </a>
        @endfor

        @if($currentPage < $lastPage)
            <a href="{{ $data->nextPageUrl() }}" class="w-6 h-6 text-xs border-2 border-zinc-100 text-zinc-900 rounded flex justify-center items-center">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
            </a>
        @endif
    </div>
</div>
