
<div class="max-w-5xl m-auto bg-white rounded-lg shadow-md dark:bg-gray-300 pb-3">

    <div {{ $cabecera->attributes->merge(['class' => 'flex items-center justify-between py-4 px-6 rounded-t-lg']) }}>        
        <span {{ $titulo->attributes->merge(['class' => 'text-lg font-semibold text-white dark:text-gray-400']) }}>{{$titulo}} </span>
        {{$icono}}
    </div>       
    {{$slot}}  
    {{$equip}}
</div>