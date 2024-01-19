<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto    px-5 lg:px-8 flex flex-col">
            {{-- create --}}
            <form action="{{ route('admin.albums.store') }}" method="post" class=" mb-20 ">
                @csrf
                <input style="--tw-ring-shadow: none" required placeholder="nome album" type="text" name="name_album" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                <button class="bg-gray-400 hover:bg-gray-500 transition p-2 px-5 text-white rounded-lg mt-5">Crea Album</button>
            </form>
            <div class="h-[50px]">
                @include('admin.partials.messages')
            </div>
            <h2 class="font-semibold text-3xl my-3 text-gray-800">I Tuoi Albums</h2>
            {{-- search --}}
            <div class="py-3 flex items-center">
                <form action="{{ route('admin.albums.index') }}" method="get" class="flex items-center">
                    @csrf
                    <input style="--tw-ring-shadow: none" autocomplete="off" placeholder="cerca per nome" type="text" name="search" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                    <button class="bg-gray-400 hover:bg-gray-500 transition py-2 px-2 mx-1 text-white rounded-lg">Cerca</button>
                    <a class="bg-blue-400 hover:bg-blue-500 transition py-2 px-2 text-white rounded-lg" href="{{ route('admin.albums.index') }}">Reset</a>
    
                </form>
            </div>
            <!-- Table -->
            <div class="w-full hidden md:block max-w-1xl bg-white shadow-md rounded-lg">
                <div class="p-3">
                    <div class="overflow-x-auto">
                        @if(count($albums) === 0)
                        <h1>Non ci sono album</h1>
                        @else
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>

                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Copertina</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Nome</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Numero foto</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Ultimo aggiornamento</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Actions</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($albums as $album)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="flex justify-center font-medium text-gray-500">
                                            @if ($album->files->isNotEmpty())
                                            <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                                                <img width="80" class="rounded-2xl" src="{{ asset('storage/' . $album->files->first()->img_url) }}" alt="Cover Image">
                                            </a>
                                            @else
                                            <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                                                <div class="border rounded p-5" style="width: 100px">No Image</div>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap  ">
                                        <div class="text-center font-medium text-gray-500  ">
                                            <div class="flex items-center justify-center">
                                                <span class="me-2">{{ $album->name_album }}</span>
                                            </div>                                        
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium text-gray-500">
                                            {{ count($album->files) }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium text-gray-500">{{ $album->updated_at }}</div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">                                     
                                        <div class="flex justify-center">
                                            <button data-modal-target="popup-modal-edit-{{ $album->id }}" data-modal-toggle="popup-modal-edit-{{ $album->id }}" class="block text-white bg-blue-700 me-2 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                <i class="fa-solid fa-edit"></i> modifica
                                            </button>
                                            {{-- modale modifica --}}
                                            <div id="popup-modal-edit-{{ $album->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow">
                                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-edit-{{ $album->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-6 text-center">
                                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Qui puoi modificare il nome del tuo album</h3>
                                                            <div class="flex items-center justify-between">

                                                                <form action="{{ route('admin.albums.update', $album->id) }}" method="post">
                                                                    @csrf
                                                                    @method('put')
                                                                    <input style="--tw-ring-shadow: none" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg" type="text" name="name_album" value="{{ old('name_album', $album->name_album) }}">
                                                                    <button title="modifica" class="bg-blue-600 hover:bg-blue-500 transition text-white rounded-lg px-5 py-2.5 ">Modifica</button>
                                                                </form>
                                                                <button data-modal-hide="popup-modal-edit-{{ $album->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Annulla</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @if(count($album->files) == 0) --}}

                                            <button data-modal-target="popup-modal-trash-{{ $album->id }}" data-modal-toggle="popup-modal-trash-{{ $album->id }}" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                                <i class="fa-solid fa-trash"></i> Elimina Album
                                            </button>

                                            <div id="popup-modal-trash-{{ $album->id }}" tabindex="-1" class="fixed bg-opacity-50 top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow">
                                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-trash-{{ $album->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-6 text-center">
                                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Qui puoi modificare il nome del tuo album</h3>
                                                            <div class="flex items-center justify-around items-center">

                                                                <form action="{{ route('admin.albums.destroy', $album->id) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button title="elimina album" class="bg-red-400 hover:bg-red-500 transition p-2 px-3 text-white rounded-lg"><i class="fa fa-trash"></i> Elimina album</button>
                                                                </form>
                                                                <button data-modal-hide="popup-modal-trash-{{ $album->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Annulla</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                           {{--  @else
                                            <div class="text-center">
                                                <p style="font-size: 10px">Elimina le foto <br> se vuoi eliminare l'album</p>
                                            </div> --}}
                                           {{--  @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

            @foreach($albums as $album)
            <div class="max-w-md my-5 bg-white block md:hidden rounded-xl shadow-md overflow-hidden md:max-w-xl">
                @if ($album->files->isNotEmpty())
                <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                    <img class="object-cover w-full h-48" {{--  width="150" --}} src="{{ asset('storage/' . $album->files->first()->img_url) }}" alt="Cover Image">
                </a>
                @else
                <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                    <div class="border rounded flex items-center justify-center p-5 object-cover w-full h-48">No Image</div>
                </a>
                @endif

                <div class="p-6">
                    <div class="flex justify-end items-baseline">
                        @if(count($album->files) == 0)
                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button title="elimina album" class="bg-red-400 hover:bg-red-500 transition p-2 px-3 text-white rounded-lg"><i class="fa fa-trash"></i> Elimina album</button>
                        </form>
                        @else
                        <div class="text-center">
                            <p style="font-size: 10px">Elimina le foto <br> se vuoi eliminare l'album</p>
                        </div>
                        @endif
                    </div>

                    <h4 class="mt-1 font-semibold text-lg leading-tight truncate">{{ $album->name_album }}</h4>

                    <p class="mt-2 text-gray-600">Numero foto: {{ count($album->files) }}</p>
                </div>
            </div>
            @endforeach




        </div>
    </div>
</x-app-layout>
