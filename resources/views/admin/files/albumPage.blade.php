<x-app-layout>
    <div class="py-12" style="animation: rotate-fade 0.5s ease-in-out;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8     mb-10 flex justify-between">
            <h1 class="text-4xl ml-5">Galleria {{ $album->name_album }}</h1>
            <a class="bg-blue-400 hover:bg-blue-500 transition p-2 px-5 mr-5 text-white rounded-lg" href="{{ route('admin.albums.index') }}">Torna gli album</a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
            {{-- create --}}
            <form action="{{ route('admin.files.store') }}" method="post" class="m-5 flex items-center" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="album_id" value="{{ $album->id }}">
                <div class="flex-column my-2">
                    <input name="files[]" type="file" class="mt-2" multiple required>
                </div> --}}
                <input type="hidden" name="album_id" value="{{ $album->id }}">
                <label for="file-input" class="flex items-center p-2 text-white bg-blue-500 rounded cursor-pointer my-5" style="width: 150px">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Sfoglia file 
                </label>
                <input id="file-input" type="file" class="hidden" name="files[]" multiple required>
                <button class="bg-gray-400 hover:bg-gray-500 transition p-2 px-5 text-white rounded ms-2">Aggiungi foto</button>
            </form>

            <!-- Table -->
            <div class="m-5 bg-white {{-- shadow-lg --}} border border-gray-200 rounded-lg">
                <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Foto in {{ $album->name_album }}</h2>
                    @if(count($album->files) > 0)
                    <div x-data="{ modelOpen: false }">
                        <button @click="modelOpen =!modelOpen" class="bg-red-400 hover:bg-red-500 transition p-2 px-5 text-white rounded-lg">Elimina tutti</button>
                        <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                    <div class="flex items-center justify-between space-x-4 mb-10">
                                        <h1 class="text-xl font-medium text-gray-800 ">Sei sicuro di eliminare tutte le foto?</h1>

                                        <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.files.destroyAll') }}" method="post">
                                        @csrf
                                        <button class="bg-red-400 hover:bg-red-500 transition p-2 px-5 text-white rounded-lg">Elimina tutti</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </header>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <div class="flex flex-wrap justify-center md:justify-start">
                            @if(count($files) === 0)
                            <h1 style="font-size: 15px">Non ci sono foto in questo album</h1>
                            @else
                            @foreach($files as $file)
                            <div  x-data="{ show: false }">
                            <figure  @click="show =!show" class="relative group transition overflow-hidden">
                                <img style="width: 180px; height:180px; object-fit: cover; object-position: center" class="  rounded-lg border m-2  transition-transform group-hover:scale-95" src="{{ asset('storage/'. $file->img_url) }}" alt="{{ $file->name }}">
                                
                                
                                <div x-data="{ open: false }">
                                    <button @click="open =!open" style="right: 55px" class="absolute hidden top-4 group-hover:block bg-red-400 hover:bg-red-500 transition p-1 px-3 text-white rounded-md"><i class="fa fa-trash"></i></button>
                                    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                            <div x-cloak @click="open = false" x-show="open" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                <div class="flex items-center justify-between space-x-4 mb-10">
                                                    <h1 class="text-xl font-medium text-gray-800 ">Sei sicuro di eliminare la foto?</h1>

                                                    <button @click="open = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <form action="{{ route('admin.files.destroy', $file->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="bg-red-400 hover:bg-red-500 transition p-1 px-3 text-white rounded-md">Elimina</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <form action="{{ route('admin.files.downloadFile', $file->id) }}" method="post" class="absolute right-4 hidden top-4 group-hover:block ">
                                    @csrf
                                    <button class="bg-gray-400 hover:bg-gray-500 transition p-1 px-3 text-white rounded-md"><i class="fa fa-arrow-down"></i></button>
                                </form>
                            </figure>

                            {{-- SHOW --}}
 
                              {{--   <div @click="show =!show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                        <div x-show="show" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>
                                        
                                        <div x-show="show" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                            <div class="flex items-center justify-between space-x-4 mb-10">
                                                <h1 class="text-xl font-medium text-gray-800 "></h1>
                                                
                                                <button  @click="show = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <img src="{{ asset('storage/' . $file->img_url) }}" alt="file">
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
