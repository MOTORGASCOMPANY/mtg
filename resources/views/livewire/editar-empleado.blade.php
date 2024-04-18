<div class="container mx-auto py-12">
    <div class="flex flex-row  justify-between items-center">
        <h2 class="mt-8 font-bold text-lg text-indigo-600"> Documentos Del Empleado {{ $empleado->empleado->name }}</h2>
        @hasanyrole('administrador|supervisor|Administrador del sistema')
            @livewire('create-documento-empleado', ['idEmpleado' => $empleado->id])
        @endhasanyrole
    </div>
    <hr class="my-4">
    @if (isset($empleado->Documentos))
        <div>
            @livewire('documentos-empleados', ['idEmpleado' => $empleado->id], key($empleado->idUser . '-' . $empleado->id))
        </div>
    @endif

    <div class="w-full px-4 py-8 flex justify-center space-x-4 ">
        <x-jet-button wire:click="regresar" wire:loading.attr="disabled" wire:target="regresar">
            Regresar
        </x-jet-button>
    </div>


</div>
