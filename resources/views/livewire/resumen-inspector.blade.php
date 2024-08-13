<div class="bg-gray-200 bg-opacity-25 flex flex-col items-center justify-center px-4">
    <!-- Selector de periodo 
    <div class="p-2">
        <select class="rounded-md mb-4 py-1" wire:model="periodo">
            <option value="dia">Hoy</option>
            <option value="semana">Semana</option>
            <option value="mes">Mes</option>
        </select>
    </div>  
    -->


    <!-- Contenedor para el gráfico circular para Mejor Inspector -->
    <p class="mt-2 pl-2 font-bold text-indigo-600 text-sm">Mejor Inspector:</p>
    <div style="display: flex; justify-content: center; align-items: center; height: 100%; width: 100%;">

        <div style="width: 255px; height: 255px;">
            <canvas id="inspectorPieChart"></canvas>
        </div>
    </div>
    <!--p style="text-align: center; margin-top: 10px;">
        {{ $mejorInspectorNombre }} es el mejor inspector con {{ $mejorInspectorCertificaciones }} certificaciones.
    </p-->

    <!-- Contenedor para el gráfico circular para Mejor Taller -->
    <p class="mt-2 pl-2 font-bold text-indigo-600 text-sm">Mejor Taller:</p>
    <div style="display: flex; justify-content: center; align-items: center; height: 100%; width: 100%;">

        <div style="width: 255px; height: 255px;">
            <canvas id="tallerPieChart"></canvas>
        </div>
    </div>
    <!--p style="text-align: center; margin-top: 10px;">
        {{ $mejorTallerNombre }} es el mejor taller con {{ $mejorTallerCertificaciones }} certificaciones.
    </p-->

    

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const inspectorCtx = document.getElementById('inspectorPieChart').getContext('2d');
            const tallerCtx = document.getElementById('tallerPieChart').getContext('2d');
            let inspectorChart;
            let tallerChart;
    
            function createInspectorChart(dataInspectores, dataCertificaciones) {
                if (inspectorChart) {
                    inspectorChart.destroy();
                }
    
                inspectorChart = new Chart(inspectorCtx, {
                    type: 'doughnut',
                    data: {
                        labels: dataInspectores,
                        datasets: [{
                            data: dataCertificaciones,
                            backgroundColor: [
                                'rgba(210,220,255)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgb(96, 72, 250)', 
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw +
                                            ' certificaciones';
                                    }
                                }
                            }
                        }
                    }
                });
            }
    
            function createTallerChart(dataTalleres, dataTallerCertificaciones) {
                if (tallerChart) {
                    tallerChart.destroy();
                }
    
                tallerChart = new Chart(tallerCtx, {
                    type: 'doughnut',
                    data: {
                        labels: dataTalleres,
                        datasets: [{
                            data: dataTallerCertificaciones,
                            backgroundColor: [
                                'rgba(210,220,255)',  
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgb(96, 72, 250)', 
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw +
                                            ' certificaciones';
                                    }
                                }
                            }
                        }
                    }
                });
            }
    
            // Inicializar los gráficos con los datos por defecto
            createInspectorChart(@json($dataInspectores), @json($dataCertificaciones));
            createTallerChart(@json($dataTalleres), @json($dataTallerCertificaciones));
    
            // Actualizar los gráficos cuando los datos cambien
            Livewire.on('updateChart', (dataInspectores, dataCertificaciones, dataTalleres, dataTallerCertificaciones) => {
                createInspectorChart(dataInspectores, dataCertificaciones);
                createTallerChart(dataTalleres, dataTallerCertificaciones);
            });
        });
    </script>
</div>
