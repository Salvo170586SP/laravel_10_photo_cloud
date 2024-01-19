@if ($errors->any())
    <div  class="bg-yellow-500 text-white p-2 rounded-2xl w-full" >
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif