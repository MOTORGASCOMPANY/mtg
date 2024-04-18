<div
    x-data="datePicker({
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model' ) }},
        @else
            value: {{ \Illuminate\Support\Js::from($value) }},
        @endif

        options: {{ \Illuminate\Support\Js::from($options) }},

        config: { locale: {
            firstDayOfWeek: 1,
            weekdays: {
              shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
              longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
            }, 
            months: {
              shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
              longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            },
          } 
        },
    })"
    wire:ignore.self

    @if ($hasXModel())
        {{ $attributes->whereStartsWith('x-model') }}
        x-modelable="__value"
    @endif

    class="date-picker-root"
>
    <div
        class="{{ $containerClass }}"
        x-date-picker:container

        {{-- we are going to use a MutationObserver on this element to clone these attributes to the input since it is being wire:ignored --}}
        @if ($hasErrorsAndShow($name))
            aria-invalid="true"
        @endif
        {!! $ariaDescribedBy() !!}    >
        
        
        @includeWhen(! $toggleIcon, 'form-components::partials.leading-addons')
            
        <input
            @if ($name) name="{{ $name }}" @endif
            @if ($id) id="{{ $id }}" @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            {{ $attributes->except(['type', 'aria-describedby'])->whereDoesntStartWith(['wire:model', 'x-model'])->class($inputClass) }}
            x-date-picker:input
            wire:ignore
            {{ $extraAttributes ?? '' }}       
        />       
        
    </div>

    {{ $end ?? '' }}
</div>
