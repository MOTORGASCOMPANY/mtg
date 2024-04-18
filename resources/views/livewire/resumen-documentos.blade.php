<div class="bg-gray-200 bg-opacity-25 flex flex-col items-center justify-center px-4">
    <div class="w-full my-4">
        @if(isset($documentos))
          @if ($documentos->count()>0)            
              <div class="flex flex-col">
                  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                      <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light">
                          <thead class="border-b font-medium dark:border-neutral-500 text-indigo-600">                           
                            <tr>
                              <th scope="col" class="px-6 py-4">Documento</th>
                              <th scope="col" class="px-6 py-4">Estado</th>
                              <th scope="col" class="px-6 py-4">Vencimiento</th>
                              <th scope="col" class="px-6 py-4">Acción</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($documentos as $doc)                            
                              <tr class="border-b dark:border-neutral-500">
                                  <td class="whitespace-nowrap px-6 py-4 font-medium">{{$doc->TipoDocumento->nombreTipo}}</td>
                                  
                                  @switch($doc->estadoDocumento)
                                      @case(1)
                                          <td class="whitespace-nowrap px-6 py-4"><span class="font-bold text-green-600"> <i class="fas fa-check-circle"></i> Vigente</span></td>
                                          @break
                                      @case(2)
                                          <td class="whitespace-nowrap px-6 py-4"><span class="font-bold text-orange-600"> <i class="fas fa-exclamation-circle"></i> Vence pronto</span></td>
                                          @break
                                      @case(3)
                                          <td class="whitespace-nowrap px-6 py-4"><span class="font-bold text-red-600"> <i class="fas fa-times-circle"></i> Vencido</span></td>
                                          @break
                                      @default
                                          
                                  @endswitch
                                  <td class="whitespace-nowrap px-6 py-4">{{$doc->fechaExpiracion}}</td>
                                  <td class="whitespace-nowrap px-6 py-4 text-center"><i class="fas fa-file-download"></i></td>
                              </tr>  
                          @endforeach
                                                    
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                
          @else
              <div class="text-center">
                  <p>Aun no se cargo ningún documento del taller</p>
              </div>
          @endif
        @else
              <div class="text-center">
                  <p class="text-sm">Este usuario no cuenta con ningún taller seleccionado, comuniquese con el administrador del sistema para asignarle un taller.</p>
              </div>
        @endif  
        
    </div>
</div>
