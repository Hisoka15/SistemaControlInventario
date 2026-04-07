@php(
    $showNumeration = $showNummeration ?? true
)
@if(count($rows) === 0)
    <div class="w-full h-auto bg-white rounded text-xs text-center flex flex-col justify-center items-center gap-2 px-4 py-8 border-2 border-dashed border-zinc-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-open-icon lucide-package-open"><path d="M12 22v-9"/><path d="M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"/><path d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"/><path d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z"/></svg>
        <p>Sin registros para mostrar</p>
    </div>
@else
    <table class="w-full h-auto bg-white rounded text-left">
        <thead class="rounded bg-zinc-100 text-zinc-400 text-xs uppercase">
            <tr class="">
                @if($paginate && $showNumeration)
                    <th class="pl-4 rounded-l-lg">No.</th>
                @endif
                @foreach ($headers as $header)
                    <th class="py-2 @if(!$paginate || !$showNumeration) rounded-l-lg pl-4 @endif">{{ $header }}</th>
                @endforeach
                @if(($links && count($links) > 0) || $childComponent)
                    <th class="py-2 text-center rounded-r-lg">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr class="border-b-[1px] border-zinc-200 text-xs @if(!$loop->odd) bg-zinc-50 @endif">
                    @if($paginate && $showNumeration)
                        <td class="py-2 text-center font-semibold">{{ $loop->iteration + ($currentPage - 1) * $rows->perPage() }}</td>
                    @endif
                    @foreach ($columns as $column)
                        @if($column == 'status')
                            <td class="py-2 font-semibold w-full flex justify-start items-center">
                                @if($row[$column] == "active")
                                    <span class="text-white font-semibold bg-green-500 py-1 px-2 ml-1 rounded-full">Activo</span>
                                @else
                                    <span class="text-white font-semibold bg-red-500 py-1 px-2 rounded-full">Inactivo</span>
                                @endif
                            </td>
                        @else
                            <td class="py-2 font-semibold pl-4">{{ $row[$column] }}</td>
                        @endif
                    @endforeach
                    @if(($links && count($links) > 0) || $childComponent)
                        <td class="py-2 flex justify-center items-center gap-2">
                            @foreach($links as $link)
                                <a class="py-1 px-2 font-semibold rounded text-xs bg-blue-500 text-white my-1 border-[1px]" href="{{route($link['route_name'], [$link['name_params'] => $row['id']])}}">{{$link['name']}}</a>
                            @endforeach
                            @if($childComponent)
                                @include($childComponent, ['selected' => $row, 'dataChildComponent' => $dataChildComponent])
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($paginate)
        @include('components.paginate', ['lastPage' => $lastPage, 'currentPage' => $currentPage, 'data' => $data])
    @endif
@endif
