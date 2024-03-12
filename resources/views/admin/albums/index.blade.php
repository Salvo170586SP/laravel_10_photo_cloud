<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto    px-5 lg:px-8 flex flex-col">
            {{-- create --}}
            <form action="{{ route('admin.albums.store') }}" method="post" class="w-full text-center mb-5 ">
                @csrf
                <input style="--tw-ring-shadow: none" required placeholder="nome album" type="text" name="name_album"
                    class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                <button class="bg-gray-400 hover:bg-gray-500 transition p-2 px-5 text-white rounded-lg mt-5">Crea
                    Album</button>
            </form>
            <div class="h-[50px]">
                @include('admin.partials.messages')
            </div>
            @if(count($albums) === 0)
            <div class="w-full text-center text-slate-400">
                <h2 class="text-3xl font-bold"><i class="fa-solid fa-images mr-2"></i> CREA IL TUO PRIMO ALBUM</h2>
            </div>
            @endif

            @if(count($albums) > 0)
            <h2 class="font-semibold text-3xl my-3 text-gray-800">I Tuoi Albums</h2>
            <div class="py-3 flex items-center">
                <form action="{{ route('admin.albums.index') }}" method="get" class="flex items-center">
                    @csrf
                    <input style="--tw-ring-shadow: none" autocomplete="off" placeholder="cerca per nome" type="text"
                        name="search"
                        class="hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg">
                    <button
                        class="bg-gray-400 hover:bg-gray-500 transition py-2 px-2 mx-1 text-white rounded-lg">Cerca</button>
                    <a class="bg-blue-400 hover:bg-blue-500 transition py-2 px-2 text-white rounded-lg"
                        href="{{ route('admin.albums.index') }}">Reset</a>

                </form>
            </div>
            @endif


            <div class="grid grid-cols-1 gap-x-4 gap-y-4 md:grid-cols-2">
                @foreach($albums as $album)
                <div
                    class="max-w-md  bg-white block   rounded-3xl shadow-md overflow-hidden md:max-w-xl hover:scale-95 transition duration-100">
                    @if ($album->files->isNotEmpty())
                    <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                        <figure class="h-[200px] w-[600px]">
                            <img class="object-cover w-full h-full "
                                src="{{ asset('storage/' . $album->files->first()->img_url) }}" alt="Cover Image">
                        </figure>
                    </a>
                    @else
                    <a href="{{  route('admin.files.albumPage', $album->id) }}" title="vai alla galleria">
                        <figure class="h-[200px] w-[600px]">
                            <img class="object-cover w-full h-full"
                                src="https://i1.wp.com/potafiori.com/wp-content/uploads/2020/04/placeholder.png?ssl=1"
                                alt="placeholder">
                        </figure>
                    </a>
                    @endif

                    <div class="p-6">
                        <div class="flex justify-end items-baseline">
                            @if(count($album->files) == 0)
                            <button data-modal-target="popup-modal-delete{{$album->id}}"
                                data-modal-toggle="popup-modal-delete{{$album->id}}"
                                class="block font-medium"
                                type="button">
                                <i class="fa fa-trash text-red-500 hover:text-red-700 " title="elimina l'album"></i>
                            </button>
                            @else
                            {{-- <div class="text-center">
                                <p style="font-size: 10px">Elimina le foto <br> se vuoi eliminare l'album</p>
                            </div> --}}
                            @endif
                        </div>
                        <div class="flex items-center">
                            <h4 class="mt-1 font-semibold text-lg leading-tight truncate">{{
                                strtoupper($album->name_album)
                                }}</h4>
                            <button data-modal-target="popup-modal-edit{{$album->id}}"
                                data-modal-toggle="popup-modal-edit{{$album->id}}"
                                class="block text-gray-300 hover:text-gray-400 font-medium   text-center ml-2"
                                type="button">
                                <i class="fa fa-edit" title="modifica il nome"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-gray-600">Numero foto: {{ count($album->files) }}</p>
                        <div class="mt-5 mb-0 text-end">
                            <small>aggiornato il: {{ $album->updated_at}}</small>
                        </div>
                    </div>
                </div>

                {{-- modale modifica nome album --}}
                <div id="popup-modal-edit{{$album->id}}" tabindex="-1"
                    class="fixed top-0 bg-opacity-50 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <button type="button"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="popup-modal-edit{{$album->id}}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                            <div class="p-6 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500">Modifica nome</h3>
                                <form action="{{ route('admin.albums.update', $album->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <input placeholder="modifica nome..." type="text" id="name_album" name="name_album"
                                        class="w-full hover:bg-gray-200 focus:bg-gray-200 transition border-gray-200 focus:border-gray-200 rounded-lg"
                                        value="{{$album->name_album}}">
                                    <div class="flex justify-end items-center mt-3">
                                        <button
                                            class="bg-blue-400 hover:bg-blue-500 transition p-2 px-5 text-white rounded-lg mr-2">Modifica</button>
                                        <button data-modal-hide="popup-modal-edit{{$album->id}}" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Annulla</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- modale elimina album --}}
                <div id="popup-modal-delete{{$album->id}}" tabindex="-1"
                    class="fixed top-0 bg-opacity-50 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">

                            <button type="button"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="popup-modal-delete{{$album->id}}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                            <div class="p-4 ">
                                <h3 class="mb-5 text-lg font-normal text-gray-500">Sei sicuro di eliminare l'album {{
                                    $album->name_album }}?</h3>
                                <form action="{{ route('admin.albums.destroy', $album->id) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <div class="flex justify-end items-center mt-3">
                                        <button
                                            class="bg-red-400 hover:bg-red-500 transition p-2 px-5 text-white rounded-lg mr-2">Elimina
                                            Album</button>
                                        <button data-modal-hide="popup-modal-delete{{$album->id}}" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Annulla</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>