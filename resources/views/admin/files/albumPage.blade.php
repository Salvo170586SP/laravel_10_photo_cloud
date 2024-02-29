<x-app-layout>
    <div class="py-12" style="animation: rotate-fade 0.5s ease-in-out;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5 flex justify-between items-center">
            <div>
                <h1 class="text-4xl  ">Galleria {{ $album->name_album }} </h1>
                <small class="bg-gray-600 text-white rounded px-3 py-1">{{count($files)}} FOTO</small>
            </div>
            <a class="bg-blue-400 hover:bg-blue-500 transition p-2 px-5 mr-5 text-white rounded-lg"
                href="{{ route('admin.albums.index') }}">Torna gli album</a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
            <div>
                @include('admin.partials.messages')
            </div>
            {{-- create --}}
            @include('admin.partials.errors')
            <form action="{{ route('admin.files.store') }}" method="post" class="flex items-center"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="album_id" value="{{ $album->id }}">
                <label for="url_file" class="flex items-center p-2 text-white bg-blue-500 rounded cursor-pointer my-5"
                    style="width: 150px">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Sfoglia file
                </label>
                <input id="url_file" type="file" class="hidden" name="files[]" multiple required>
                <button id="button2" style="display: none"
                    class="bg-gray-400  hover:bg-gray-500 transition p-2 px-5 text-white rounded ms-2">Aggiungi
                    foto</button>
            </form>

            <!-- dropzone drug & drop -->
            <form id="myForm" action="{{ route('admin.dropzone.store') }}" method="post"
                class="dropzone   border-gray-400 rounded-lg shadow-md mb-5" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="album_id" value="{{ $album->id }}">
            </form>

            <!-- Table -->
            <div class="bg-white  shadow-md rounded-xl">
                <header class="px-5 py-4   flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800"> </h2>
                    @if(count($album->files) > 1)
                    <button data-modal-target="popup-modal-delete-all" data-modal-toggle="popup-modal-delete-all"
                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        type="button">
                        Elimina tutti
                    </button>
                    {{-- modale elimina tutti --}}
                    <div id="popup-modal-delete-all" tabindex="-1"
                        class="fixed top-0 bg-opacity-50 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow">
                                <button type="button"
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="popup-modal-delete-all">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                                <div class="p-6 text-center">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Vuoi eliminare tutte le foto in
                                        questo album?</h3>
                                    <div class="flex items-center justify-between">
                                        <form action="{{ route('admin.files.destroyAll', $album->id) }}" method="post">
                                            @csrf
                                            <button
                                                class="bg-red-400 hover:bg-red-500 transition p-2 px-5 text-white rounded-lg">Elimina
                                                tutti</button>
                                        </form>
                                        <button data-modal-hide="popup-modal-delete-all" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Annulla</button>
                                    </div>
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
                            <div class="relative group">
                                <div class="  cursor-pointer " data-modal-target="popup-modal-show-{{ $file->id }}"
                                    data-modal-toggle="popup-modal-show-{{ $file->id }}">
                                    <figure class="  transition overflow-hidden">
                                        <img style="width: 180px; height:180px; object-fit: cover; object-position: center"
                                            class=" rounded-2xl border m-1  transition-transform group-hover:scale-95"
                                            src="{{ asset('storage/'. $file->img_url) }}" alt="{{ $file->name }}">
                                    </figure>
                                </div>
                                <form action="{{ route('admin.files.downloadFile', $file->id) }}" method="post"
                                    class="absolute right-5 hidden top-5 group-hover:block ">
                                    @csrf
                                    <button class="bg-gray-400 hover:bg-gray-500  p-1 px-3 text-white rounded-md"><i
                                            class="fa fa-arrow-down"></i></button>
                                </form>
                                <div class="absolute hidden right-14 me-1 top-5 group-hover:block">
                                    <button data-modal-target="popup-modal-delete-{{ $file->id }}"
                                        data-modal-toggle="popup-modal-delete-{{ $file->id }}"
                                        class="p-1 px-3 text-white rounded-md bg-red-700 hover:bg-red-800  focus:outline-none focus:ring-blue-300"
                                        type="button">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>

                                {{-- modal elimina uno --}}
                                <div id="popup-modal-delete-{{ $file->id }}" tabindex="-1"
                                    class="fixed p-5 top-0 bg-opacity-50 left-0 right-0 z-50 hidden overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-white bg-red-600 rounded-lg text-sm w-10 h-10 ml-auto inline-flex justify-center items-center"
                                                data-modal-hide="popup-modal-delete-{{ $file->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <h1 class="text-xl font-medium text-gray-800 ">Sei sicuro di eliminare
                                                    la foto?</h1>
                                                <form action="{{ route('admin.files.destroy', $file->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                        class="bg-red-400 hover:bg-red-500 transition p-1 px-3 text-white rounded-md">Elimina</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SHOW --}}
                                <div id="popup-modal-show-{{ $file->id }}" tabindex="-1"
                                    class="fixed p-5 top-0 left-0 right-0 z-50 hidden bg-opacity-50  overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative">
                                        <div class="relative bg-white rounded-lg shadow">
                                            <button type="button"
                                                class="absolute top-3 right-2.5 text-white bg-red-600 rounded-lg text-sm w-10 h-10 ml-auto inline-flex justify-center items-center"
                                                data-modal-hide="popup-modal-show-{{ $file->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <div class="flex items-center justify-between">
                                                    <figure class="w-[500px] h-[500px]">
                                                        <img src="{{ asset('storage/'. $file->img_url) }}"
                                                            class="w-full h-full object-contain"
                                                            alt="{{ $file->name }}">
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<script>
    Dropzone.options.myForm = {
        acceptedFiles: ".jpeg, .jpg", //estensioni accettate
        maxFilesize: 1, //MB
        maxFiles: 5, //numero massimo di upload 
        dictDefaultMessage: "Clicca o trascina i file qui",

        //ricarica la pagina se caricati correttamente i files
        init: function(){
            var th = this;
            this.on('queuecomplete', function(){
                location.reload();
            }) 
        }
    }
 
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlFile = document.getElementById('url_file');
        urlFile.addEventListener('input', function(e) {
            const button = document.getElementById('button2');
            const file = urlFile.value;
            console.log(file);
            trueDis = urlFile.disabled = false;
            button.style.display = file !== '' ? 'block' : 'none';
        });
    })
</script>