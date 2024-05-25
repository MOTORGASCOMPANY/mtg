<div class="container mx-auto py-12 mt-4">
    <div class="flex flex-row  justify-between items-center">
        <h2 class="mt-8 font-bold text-lg text-indigo-600"> Vacaciones del Empleado {{ $empleado->empleado->name ?? '' }}</h2>
        <div class="flex space-x-2">
            @hasanyrole('administrador|Administrador del sistema')
                @livewire('vacaciones-asignadas', ['contratoId' => $empleado->id ?? ''])
            @endhasanyrole

            <button data-tooltip-target="tooltip-dark" type="button" wire:click="regresar" wire:target="regresar"
                class="group flex py-4 px-4 text-center rounded-md bg-indigo-400 font-bold text-white cursor-pointer hover:bg-indigo-500 hover:animate-pulse">
                <i class="fa-solid fa-rotate-left"></i>
                <span
                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute left-1/2-translate-x-1/2 translate-y-full opacity-0 m-4 mx-auto z-100">
                    Regresar
                </span>
            </button>
        </div>

    </div>
    <hr class="my-4">
    @if (isset($empleado->vacaciones))
        <div>
            @livewire('registro-vacacion', ['contratoId' => $empleado->id], key($empleado->idUser . '-' . $empleado->id))
        </div>
    @endif


</div>
