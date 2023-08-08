<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
            {{-- create --}}
            <form action="{{ route('admin.albums.store') }}" method="post" class="ml-4 mb-4 ">
                @csrf
                <input style="--tw-ring-shadow: none" required placeholder="nome album" type="text" name="name_album" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                <button class="bg-gray-400 hover:bg-gray-500 transition p-2 px-5 text-white rounded-lg mt-5">Crea Album</button>
            </form>

            <!-- Table -->
            <div class="w-full hidden md:block m-4  max-w-1xl {{-- mx-auto --}} bg-white {{-- shadow-lg --}} border border-gray-200 rounded-lg">
                <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">I Tuoi Albums</h2>
                    {{-- search --}}
                    <form action="{{ route('admin.albums.index') }}" method="get" class="flex align-center">
                        @csrf
                        <input style="--tw-ring-shadow: none" placeholder="cerca per nome" type="text" name="search" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                        <button class="bg-gray-400 hover:bg-gray-500 transition p-2 px-5 mx-2 text-white rounded-lg">Cerca</button>
                        <a class="bg-blue-400 hover:bg-blue-500 transition py-3 px-5 text-white rounded-lg" href="{{ route('admin.albums.index') }}">Reset</a>

                    </form>
                </header>
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
                                        <div class="text-center font-medium text-gray-500">
                                            @if ($album->files->isNotEmpty())
                                            <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                                                <img width="150" src="{{ asset('storage/' . $album->files->first()->img_url) }}" alt="Cover Image">
                                            </a>
                                            @else
                                            <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                                                <div class="border rounded p-5" style="width: 150px">No Image</div>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center font-medium text-gray-500">
                                            <form action="{{ route('admin.albums.update', $album->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <input style="--tw-ring-shadow: none" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg" type="text" name="name_album" value="{{ old('name_album', $album->name_album) }}">
                                                <button title="modifica" class="bg-blue-600 hover:bg-blue-500 transition p-2 px-3 text-white rounded-lg"><i class="fa-solid fa-check"></i></button>
                                            </form>
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
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>


             {{-- search --}}
             <form action="{{ route('admin.albums.index') }}" method="get" class="block md:hidden flex align-center mt-5 ml-5">
                @csrf
                <input style="--tw-ring-shadow: none" placeholder="cerca per nome" type="text" name="search" class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                <button class="bg-gray-400 hover:bg-gray-500 transition p-2 px-5 mx-2 text-white rounded-lg">Cerca</button>
                <a class="bg-blue-400 hover:bg-blue-500 transition py-3 px-5 text-white rounded-lg" href="{{ route('admin.albums.index') }}">Reset</a>

            </form>
            
            @foreach($albums as $album)
            <div class="max-w-md m-5 bg-white block md:hidden rounded-xl shadow-md overflow-hidden md:max-w-xl">
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
