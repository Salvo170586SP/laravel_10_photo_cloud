@if(session('message'))
<div  x-data="{close : true}">
    <div id="success-alert" x-show="close" class="bg-slate-400 text-white rounded-2xl p-3 flex justify-between items-center">
        <span>
            {{ session('message') }}
        </span>
        <button @click="close = false" class="bg-slate-200 rounded-full text-black px-2 border border-slate-200">X</button>
    </div>
</div>
@endif
