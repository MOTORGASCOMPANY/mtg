<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
    <div class="p-6">
        {{--
        <div class="flex items-center">
            <i class="fas fa-file-archive pl-5"></i>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{ route('expedientes') }}">Expedientes</a></div>
        </div>
        --}}
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                <div class="flex flex-row justify-between">
                    <h1>Total de Expedientes: </h1>
                    @if ($expedientes)
                        <span class="relative inline-block px-3 py-1 font-semibold text-indigo-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-indigo-400 opacity-20 rounded-full"></span>
                            <span class="relative">{{ count($expedientes) }}</span>
                        </span>
                    @else
                        <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-400 opacity-20 rounded-full"></span>
                            <span class="relative">0</span>
                        </span>
                    @endif
                </div>

                <hr class="my-1" />
                <ul>
                    <li class="flex flex-row justify-between">🔍 Por revisar:
                        @if ($porRevisar > 0)
                            <span class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-orange-400 opacity-20 rounded-full"></span>
                                <span class="relative">{{ $porRevisar }}</span>
                            </span>
                        @else
                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-400 opacity-20 rounded-full"></span>
                                <span class="relative">0</span>
                            </span>
                        @endif
                    </li>
                    <hr class="my-1" />
                    <li class="flex flex-row justify-between">👁 Observados:
                        @if ($observados > 0)
                            <span class="relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-blue-400 opacity-20 rounded-full"></span>
                                <span class="relative">{{ $observados }}</span>
                            </span>
                        @else
                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-400 opacity-20 rounded-full"></span>
                                <span class="relative">0</span>
                            </span>
                        @endif
                    </li>
                    <hr class="my-1" />
                    <li class="flex flex-row justify-between">❌ Desaprobados:
                        @if ($desaprobados > 0)
                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-red-400 opacity-20 rounded-full"></span>
                                <span class="relative">{{ $desaprobados }}</span>
                            </span>
                        @else
                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-400 opacity-20 rounded-full"></span>
                                <span class="relative">0</span>
                            </span>
                        @endif
                    </li>
                    <hr class="my-1" />
                    <li class="flex flex-row justify-between">✅ Aprobados:
                        @if ($aprobados > 0)
                            <span class="relative inline-block px-3 py-1 font-semibold text-lime-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-lime-400 opacity-20 rounded-full"></span>
                                <span class="relative">{{ $aprobados }}</span>
                            </span>
                        @else
                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-400 opacity-20 rounded-full"></span>
                                <span class="relative">0</span>
                            </span>
                        @endif
                    </li>
                </ul>
            </div>
            <a href="{{ route('expedientes') }}">
                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                    <div>Revisar Expedientes</div>

                    <div class="ml-1 text-indigo-500">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l text-center">
        <p class="font-bold text-xs text-indigo-600">RESUMEN GRÁFICO DE EXPEDIENTES</p>
        <div style="position: relative; height:30vh; width:100%">
            <canvas id="chartId1" class="w-full m-auto">
            </canvas>
        </div>
    </div>
  
    @push('js')
        <script defer>
            
            window.addEventListener("load", (event) => {
                const chart1 = new Chart(document.getElementById('chartId1'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($labels),
                        datasets: @json($dataset)
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                        },
                        responsive: true,
                    }
                });
            });
        </script>
    @endpush
      {{--
    --}}

</div>
