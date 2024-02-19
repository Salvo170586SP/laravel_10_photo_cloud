<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto    px-5 lg:px-8 flex flex-col">
            {{-- create --}}
            <form action="{{ route('admin.albums.store') }}" method="post" class=" mb-5 ">
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
            <div class=" w-18 text-slate-600">
                <h2 class="text-lg font-bold">CREA IL TUO PRIMO ALBUM</h2>
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
                            <form action="{{ route('admin.albums.destroy', $album->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button title="elimina album"
                                    class="bg-red-400 hover:bg-red-500 transition p-2 px-3 text-white rounded-lg"><i
                                        class="fa fa-trash"></i> Elimina album</button>
                            </form>
                            @else
                            <div class="text-center">
                                <p style="font-size: 10px">Elimina le foto <br> se vuoi eliminare l'album</p>
                            </div>
                            @endif
                        </div>

                        <h4 class="mt-1 font-semibold text-lg leading-tight truncate">{{ strtoupper($album->name_album)
                            }}</h4>

                        <p class="mt-2 text-gray-600">Numero foto: {{ count($album->files) }}</p>
                        <div class="mt-5 mb-0 text-end">
                            <small>aggiornato il: {{ $album->updated_at}}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


        </div>
    </div>
</x-app-layout>