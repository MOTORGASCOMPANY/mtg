<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\MemorandoController;
use App\Http\Livewire\AsignacionMateriales;
use App\Http\Livewire\PruebaDocumentosTaller;
use App\Http\Livewire\CreateSolicitud;
use App\Http\Livewire\Expedientes;
use App\Http\Livewire\Ingresos;
use App\Http\Livewire\Inventario;
use App\Http\Livewire\RecepcionMateriales;
use App\Http\Livewire\Talleres;
use App\Http\Livewire\RevisionExpedientes;
use App\Http\Livewire\Salidas;
use App\Http\Livewire\Servicio;
use App\Http\Livewire\Solicitud;
use App\Http\Livewire\VistaSolicitud;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\uploadController;
use App\Http\Livewire\ActualizarPrecios;
use App\Http\Livewire\ActualizarPreciosGasol;
use App\Http\Livewire\AdministracionCertificaciones;
use App\Http\Livewire\AdminPermisos;
use App\Http\Livewire\AdminRoles;
use App\Http\Livewire\Arreglando;
use App\Http\Livewire\Cambiar;
use App\Http\Livewire\CargaFotos;
use App\Http\Livewire\CargaImagenes;
use App\Http\Livewire\ConsultarHoja;
use App\Http\Livewire\ContratosTrabajos;
use App\Http\Livewire\EditarEmpleado;
use App\Http\Livewire\EditarTaller;
use App\Http\Livewire\EditarVacacion;
use App\Http\Livewire\Empleados;
use App\Http\Livewire\FinalizarPreConversion;
use App\Http\Livewire\ImportarAnuales;
use App\Http\Livewire\ImportarConversiones;
use App\Http\Livewire\ImportarDesmontes;
use App\Http\Livewire\ListaCertificaciones;
use App\Http\Livewire\ListaCertificacionesPendientes;
use App\Http\Livewire\ListaDesmontes;
use App\Http\Livewire\ListadoChips;
use App\Http\Livewire\ListaMemorandos;
use App\Http\Livewire\Logona;
use App\Http\Livewire\ManualFunciones;
use App\Http\Livewire\Memorandos;
use App\Http\Livewire\NotificacionesPendientes;
use App\Http\Livewire\Organigramas;
use App\Http\Livewire\PreciospoInspector;
use App\Http\Livewire\PrestamoMateriales;
use App\Http\Livewire\Prueba;
use App\Http\Livewire\PruebaExcel;
use App\Http\Livewire\Reportes\AdministracionDeServiciosImportados;
use App\Http\Livewire\Reportes\Rentabilidad;
use App\Http\Livewire\Reportes\ReporteCalcular;
use App\Http\Livewire\Reportes\ReporteCalcularChip;
use App\Http\Livewire\Reportes\ReporteCalcularGasol;
use App\Http\Livewire\Reportes\ReporteDocumentosTaller;
use App\Http\Livewire\Reportes\ReporteFotosPorInspector;
use App\Http\Livewire\Reportes\ReporteGeneralGnv;
use App\Http\Livewire\Reportes\ReporteMateriales;
use App\Http\Livewire\Reportes\ReporteSalidaMateriales;
use App\Http\Livewire\Reportes\ReporteServiciosPorInspector;
use App\Http\Livewire\Reportes\ReportesGasolution;
use App\Http\Livewire\Reportes\ReportesMtg;
use App\Http\Livewire\RevisionInventario;
use App\Http\Livewire\ServicioModi;
use App\Http\Livewire\TallerRevision;
use App\Http\Livewire\Tablas\Tiposservicios;
use App\Http\Livewire\TiposDocumentosEmple;
use App\Http\Livewire\TiposManual;
use App\Http\Livewire\Usuarios;
use App\Http\Livewire\VacacionesAsignadas;
use App\Http\Livewire\VistaEliminacion;
use App\Http\Livewire\VistaSolicitudAnul;
use App\Http\Livewire\VistaSolicitudMemorando;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return redirect()->to('/login');
});*/

//Route::get('register',[Auth::class, 'showLoginForm'])->name('register');


Route::get('/', function () {
    return view('index');
});
Route::get('index', function () {
    return view('index');
});
Route::get('about', function () {
    return view('about');
});
Route::get('services', function () {
    return view('services');
});
Route::get('contact', function () {
    return view('contact');
});


// Rutas para QR (ver PDF) Anual-GNV
Route::get('/certificado-anual-gnv/{id}/temp', [PdfController::class, 'generaPdfAnualGnv'])->name("verPdfAnual");
Route::get('/duplicado-anual-gnv/{id}/temp', [PdfController::class, 'generaDuplicadoAnualGnv'])->name("verPdfAnualDupli");
Route::get('/duplicado-anual-ex-gnv/{id}/temp', [PdfController::class, 'generaDuplicadoExternoAnualGnv'])->name("verPdfAnualDupliExt");

// Rutas para QR (ver PDF) Inicial-GNV
Route::get('/certificado-inicial-gnv/{id}/temp', [PdfController::class, 'generaPdfInicialGnv'])->name("verPdfInicial");
Route::get('/duplicado-inicial-gnv/{id}/temp', [PdfController::class, 'generaDuplicadoInicialGnv'])->name("verPdfInicialDupli");
Route::get('/duplicado-inicial-ex-gnv/{id}/temp', [PdfController::class, 'generaDuplicadoExternoInicialGnv'])->name("verPdfInicialDupliExt");

//Rutas para QR preconversion GNV
Route::get('/preConver-gnv/{id}/temp', [PdfController::class, 'generaPdfPreGnv'])->name("verPdfPreGnvPdf");

// Rutas para QR (ver PDF) Anual-GLP
Route::get('/certificado-anual-glp/{id}/temp', [PdfController::class, 'generaPdfAnualGlp'])->name("verPdfAnualGlp");

// Rutas para QR (ver PDF) Inicial-GLP
Route::get('/certificado-inicial-glp/{id}/temp', [PdfController::class, 'generaPdfInicialGlp'])->name("verPdfInicialGlp");

// Rutas para QR (ver PDF) PRE-Inicial-GLP
Route::get('/certificado-Pre-inicial-glp/{id}/temp', [PdfController::class, 'generaPdfPreGlp'])->name("verPdfPreInicialGlp");


//Rutas para QR (ver PDF) Modificacion
Route::get('/certificado-modificacion/{id}/temp', [PdfController::class, 'generaPdfModificacion'])->name("verPdfModificacion");


Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {

        Route::get('/Expedientes', Expedientes::class)->middleware('can:expedientes')->name('expedientes');
        //Route::get('/Servicio',Servicio::class)->middleware('can:servicio')->name('servicio');
        Route::get('/Talleres', Talleres::class)->middleware('can:talleres')->name('talleres');
        Route::get('/Ingresos', Ingresos::class)->middleware('can:ingresos')->name('ingresos');
        Route::get('/Salidas', Salidas::class)->middleware('can:salidas')->name('salidas');
        Route::get('/Inventario', Inventario::class)->middleware('can:inventario')->name('inventario');
        Route::get('/Asignacion-de-materiales', AsignacionMateriales::class)->middleware('can:asignacion')->name('asignacion');

        Route::get('/Prestamo-de-materiales', PrestamoMateriales::class)->middleware('can:materiales.prestamo')->name('materiales.prestamo');


        Route::get('/Recepcion-de-materiales', RecepcionMateriales::class)->middleware('can:recepcion')->name('recepcion');
        Route::get('/Solicitud-de-materiales', Solicitud::class)->middleware('can:solicitud')->name('solicitud');
        Route::get('/Crear-solicitud', CreateSolicitud::class)->middleware('can:nuevaSolicitud')->name('nuevaSolicitud');
        Route::get('/RevisionExpedientes', RevisionExpedientes::class)->middleware('can:revisionExpedientes')->name('revisionExpedientes');
        /*Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');*/
        Route::get('/Listado-Certificaciones', ListaCertificaciones::class)->middleware('can:certificaciones')->name('certificaciones');
        Route::get('/ListadoChips', ListadoChips::class)->name('ListadoChips'); //->middleware('can:ListadoChips')
        Route::get('/Administracion-de-certificaciones', AdministracionCertificaciones::class)->middleware('can:admin.certificaciones')->name('admin.certificaciones');

        Route::get('/certificados-pendientes', ListaCertificacionesPendientes::class)->middleware('can:certificaciones.pendientes')->name('certificaciones.pendientes');
        Route::get('/certificados-desmontes', ListaDesmontes::class)->middleware('can:certificaciones.desmontes')->name('certificaciones.desmontes');


        Route::get('/Solicitud/{soliId}', VistaSolicitud::class)->name('vistaSolicitud');
        Route::get('/SolicitudAnu/{anuId}/{cerId}/{userId}', VistaSolicitudAnul::class)->name('vistaSolicitudAnul');
        Route::get('/SolicitudEli/{eliId}/{cerId}/{userId}', VistaEliminacion::class)->name('vistaSolicitudEli');
        Route::get('/Memorando/{memoId}', VistaSolicitudMemorando::class)->name('vistaSolicitudMemorando');
        Route::get('/Notificaciones', NotificacionesPendientes::class)->name('Notificaciones');
        //Route::get('/Recepcion-de-materiales',RecepcionMateriales::class)->middleware('can:recepcion')->name('recepcion');

        Route::get('/Servicio', Prueba::class)->middleware('can:servicio')->name('servicio');
        //para servicio modificacion
        Route::get('/ServicioModi', ServicioModi::class)->middleware('can:ServicioModi')->name('ServicioModi');

        //PRECIOS PARA INSPECTOR
        Route::get('/PreciosInspector', PreciospoInspector::class)->middleware('can:PreciosInspector')->name('PreciosInspector');


        Route::get('/Solucion', Arreglando::class)->name('solucion');
        Route::get('/TalleresRevision', TallerRevision::class)->name('talleres.revision');
        Route::get('/Taller/edit/{idTaller}', EditarTaller::class)->name('editar-taller');
        Route::post('/Solucion/upload-images', [uploadController::class, 'uploadImagesExpediente'])->name('expediente.upload-images');
        Route::get('/Taller/Documents/{id}/download', [DocumentosController::class, 'downloadDocumentoTaller'])->name('download_doctaller');

        Route::get('/Inventario-revision', RevisionInventario::class)->middleware('can:inventario.revision')->name('inventario.revision');

        Route::get('/finalizarPreConversion/{idCertificacion}', FinalizarPreConversion::class)->name('finalizarPreconver');

        Route::get('/mailable', function () {
            $user = App\Models\User::find(47);
            return new App\Mail\CustomMail($user);
        });

        //Rutas para importacion de Servicios
        Route::get('/Importar-anuales', ImportarAnuales::class)->middleware('can:importar.anuales')->name('importar.anuales');
        Route::get('/Importar-conversiones', ImportarConversiones::class)->name('importar.conversiones');
        Route::get('/Importar-desmontes', ImportarDesmontes::class)->name('importar.desmontes');

        //Rutas modulo de Usuarios y Roles
        Route::get('/Usuarios', Usuarios::class)->name('usuarios');
        Route::get('/Roles', AdminRoles::class)->name('usuarios.roles');
        Route::get('/Permisos', AdminPermisos::class)->name('usuarios.permisos');

        //Rutas modulo de reportes de GNV
        Route::get('/Admin-servicios-importados', AdministracionDeServiciosImportados::class)->name('reportes.adminServiciosImportados'); // servicios de servicios importados(gasolution)
        Route::get('/Reporte-general-gnv', ReporteGeneralGnv::class)->name('reportes.reporteGeneralGnv'); // reporte general revisar 
        Route::get('/Reporte-de-materiales', ReporteMateriales::class)->name('reportes.reporteMateriales'); // reporte materiales revisar
        Route::get('/Reporte-de-servicios-por-inspector', ReporteServiciosPorInspector::class)->name('reportes.reporteServiciosPorInspector'); // reporte de inspecotres que usan sistema
        Route::get('/Reporte-de-fotos-por-inspector', ReporteFotosPorInspector::class)->name('reportes.reporteFotosPorInspector'); // reporte de inspectores que suben fotos
        Route::get('/Reporte-de-documentos-a-vencer', ReporteDocumentosTaller::class)->name('reportes.reporteDocumentosTaller'); // reporte de documentos vencidos de taller
        //Rutas para ver los reportes de los servicios    
        Route::get('/ReporteCalcular', ReporteCalcularGasol::class)->middleware('can:reportes.reporteCalcularGasol')->name('reportes.reporteCalcularGasol'); //1 Reporte externo
        Route::get('/ReporteCalcular-taller', ReporteCalcularChip::class)->middleware('can:reportes.reporteCalcularChip')->name('reportes.reporteCalcularChip'); //2 Reporte taller mejorar diseño excell
        Route::get('/Reporte-semanal', ReporteCalcular::class)->middleware('can:reportes.reporteCalcular')->name('reportes.reporteCalcular'); //3 Reporte Semanal
        Route::get('/Reporte-MTG', ReportesMtg::class)->middleware('can:reportes.reporteMTG')->name('reportes.reporteMTG'); //4 Reporte detallado MTG mejorar descarga excell
        Route::get('/Reporte-Gasol', ReportesGasolution::class)->middleware('can:reportes.reporteGasol')->name('reportes.reporteGasol'); //5 Reporte detallado Gasol
        Route::get('/Reporte-actualizar-mtg', ActualizarPrecios::class)->middleware('can:reportes.reporteActualizarPrecio')->name('reportes.reporteActualizarPrecio'); //6 Reporte Actualizar MTG
        Route::get('/Reporte-actualizar-gasol', ActualizarPreciosGasol::class)->middleware('can:reportes.reporteActualizarGasol')->name('reportes.reporteActualizarGasol'); //7  Reporte Actualizar GASOL
        //Ruta para ver los reportes de materiales
        Route::get('/Reporte-salida-materiales', ReporteSalidaMateriales::class)->middleware('can:reportes.reporteSalidaMateriales')->name('reportes.reporteSalidaMateriales'); // reporte salida materiales
        Route::get('/ConsultarHoja', ConsultarHoja::class)->middleware('can:ConsultarHoja')->name('ConsultarHoja'); //Consultar Hoja material

        //Ruta para rentabilidad taller
        Route::get('/Rentabilidad', Rentabilidad::class)->name('Rentabilidad');

        //Prueba Fotos
        Route::get('/CargaFotos', CargaFotos::class)->name('CargaFotos');
        Route::get('/CargaImagenes', CargaImagenes::class)->name('CargaImagenes');
        Route::get('/cambiar', Cambiar::class)->name('cambiar');

        //Ruta para adminsitracion de tablas
        Route::get('/Tablas/TiposDeServicios', Tiposservicios::class)->name('table.tiposServicio');
        Route::get('/documentosTaller', PruebaDocumentosTaller::class)->name('documentosTaller');

        //Ruta para los logos
        Route::get('/Logona', Logona::class)->name('Logona');

        //Ruta para Manual de Funciones
        Route::get('/ManualFunciones', ManualFunciones::class)->middleware('can:ManualFunciones')->name('ManualFunciones');
        Route::get('/ManualFunciones/{id}/download', [DocumentosController::class, 'downloadManual'])->name('download_docManual');
        Route::get('/Tablas/TiposManual', TiposManual::class)->name('table.TiposManual');

        //Ruta para Organigrama
        Route::get('/Organigrama', Organigramas::class)->name('Organigrama');
        Route::get('/Organigrama/{id}/download', [DocumentosController::class, 'downloadOrganigrama'])->name('download_docOrganigrama');

        //Ruta para Memorandos
        Route::get('/Memorando', Memorandos::class)->middleware('can:Memorando')->name('Memorando');
        Route::get('/ListaMemorando', ListaMemorandos::class)->middleware('can:ListaMemorando')->name('ListaMemorando');

        //Rutas para contrato trabajo - documentos empleado - vacaciones
        Route::get('/Empleados', Empleados::class)->middleware('can:Empleados')->name('Empleados'); //Lista de empleados
        Route::get('/Contratos', ContratosTrabajos::class)->name('ContratoTrabajo'); //Crear contrato trabajo
        Route::get('/Empleado/{idEmpleado}', EditarEmpleado::class)->name('editar-empleado'); //Para subir sus doc del empleado
        Route::get('/Vacacion/{contratoId}', EditarVacacion::class)->name('EditarVacacion'); //Para asignar sus vacaciones del empleado
        Route::get('/Empleado/{idEmpleado}/download', [DocumentosController::class, 'downloadEmpleado'])->name('download_docEmpleado'); //Para descargar doc de empleado 
        Route::get('/Tablas/TiposDocumentosEmpleados', TiposDocumentosEmple::class)->name('table.TiposDocumentosEmpleados'); //Tabla para tipos de doc de empleado

        // Rutas para emitir comunicado 
        Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [WelcomeController::class, 'index'])->name('dashboard');
        Route::get('/comunicado', [WelcomeController::class, 'showComunicadoForm'])->middleware('can:comunicado.createOrUpdateForm')->name('comunicado.createOrUpdateForm');
        Route::post('/comunicado/store', [WelcomeController::class, 'store'])->name('comunicado.store');
        Route::put('/comunicado/update/{comunicado}', [WelcomeController::class, 'update'])->name('comunicado.update');
        Route::post('/comunicado/deactivate/{comunicado}', [WelcomeController::class, 'deactivate'])->name('comunicado.deactivate');
        Route::post('/comunicado/upload-image', [WelcomeController::class, 'uploadImage'])->name('comunicado.uploadImage');

        //RUTAS PARA STREAM Y DESCARGA DE PDFS
        Route::controller(PdfController::class)->group(function () {

            //Rutas para ver certificado anual GNV
            Route::get('/certificado-anual/{id}', 'generaPdfAnualGnv')->name("certificadoAnualGnv");
            Route::get('/duplicado-anual/{id}', 'generaDuplicadoAnualGnv')->name("duplicadoAnualGnv");
            Route::get('/duplicado-anual-ex/{id}', 'generaDuplicadoExternoAnualGnv')->name("duplicadoExternoAnualGnv");

            //Rutas para descargar certificado anual GNV
            Route::get('/certificado-anual/{id}/descargar', 'descargarPdfAnualGnv')->name("descargarCertificadoAnualGnv");
            Route::get('/duplicado-anual/{id}/descargar', 'descargarDuplicadoAnualGnv')->name("descargarDuplicadoAnualGnv");
            Route::get('/duplicado-anual-ex/{id}/descargar', 'descargarDuplicadoExternoAnualGnv')->name("descargarDuplicadoExternoAnualGnv");

            //Rutas para ver certificado inicial GNV
            Route::get('/certificado-inicial/{id}', 'generaPdfInicialGnv')->name("certificadoInicialGnv");
            Route::get('/duplicado-inicial/{id}', 'generaDuplicadoInicialGnv')->name("duplicadoInicialGnv");
            Route::get('/duplicado-inicial-ex/{id}', 'generaDuplicadoExternoInicialGnv')->name("duplicadoExternoInicialGnv");

            //Rutas para descargar certificado inicial GNV
            Route::get('/certificado-inicial/{id}/descargar', 'descargarPdfInicialGnv')->name("descargarCertificadoInicialGnv");
            Route::get('/duplicado-inicial/{id}/descargar', 'descargarDuplicadoInicialGnv')->name("descargarDuplicadoInicialGnv");
            Route::get('/duplicado-inicial-ex/{id}/descargar', 'descargarDuplicadoExternoInicialGnv')->name("descargarDuplicadoExternoInicialGnv");

            //Rutas para descargar certificado preconversion GNV
            Route::get('/preConver/{id}', 'generaPdfPreGnv')->name("generaPreGnvPdf");
            Route::get('/preConver/{id}/descargar', 'generaDescargaPreGnv')->name("descargarPreGnvPdf");

            //Rutas para ver  y descargar pdf memorando
            Route::get('/memorando/{id}', 'generaPdfMemorando')->name("certificadoMemo");
            Route::get('/memorando/{id}/descargar', 'descargaPdfMemorando')->name("descargarCertiMemo");

            //Rutas para ver y descargar pdf contrato
            Route::get('/contrato/{id}', 'generaPdfContrato')->name("contratoTrabajo");
            Route::get('/contrato/{id}/descargar', 'descargaPdfContrato')->name("descargarContratoTrabajo");



            //Rutas para descargar y ver documentos complementarios de GNV
            Route::get('/fichaTecnicaGnv/{idCert}', 'generarFichaTecnica')->name("fichaTecnicaGnv");
            Route::get('/fichaTecnicaGnv/{idCert}/download', 'descargarFichaTecnica')->name("descargarFichaTecnicaGnv");
            Route::get('/preConversionGnv/{idCert}', 'generarPreConversionGnv')->name("preConversionGnv");
            Route::get('/checkListArriba/{idCert}', 'generarCheckListArribaGnv')->name("checkListArribaGnv");
            Route::get('/checkListAbajo/{idCert}', 'generarCheckListAbajoGnv')->name("checkListAbajoGnv");


            //Rutas para descargar certificado preconversion GLP
            Route::get('/preConverGlp/{id}', 'generaPdfPreGlp')->name("generaPreGlpPdf");
            Route::get('/preConverGlp/{id}/descargar', 'generaDescargaPreGlp')->name("descargarPreGlpPdf");

            //Rutas para ver certificado anual GLP
            Route::get('/certificado-anual-glp/{id}', 'generaPdfAnualGlp')->name("certificadoAnualGlp");

            //Rutas para ver certificado inicial GLP
            Route::get('/certificado-inicial-glp/{id}', 'generaPdfInicialGlp')->name("certificadoInicialGlp");

            //Rutas para descargar certificado anual GLP
            Route::get('/certificado-anual-glp/{id}/descargar', 'descargaPdfAnualGlp')->name("descargarCertificadoAnualGlp");

            //Rutas para descargar certificado inicial GLP
            Route::get('/certificado-inicial-glp/{id}/descargar', 'generaPdfInicialGlp')->name("descargarCertificadoInicialGlp");

            //Rutas para descargar y ver documentos complementarios de GNV
            Route::get('/fichaTecnicaGlp/{idCert}', 'generarFichaTecnicaGlp')->name("fichaTecnicaGlp");
            Route::get('/fichaTecnicaGlp/{idCert}/descargar', 'descargarFichaTecnicaGlp')->name("descargarFichaTecnicaGlp");
            Route::get('/checkListArribaGlp/{idCert}', 'generarCheckListArribaGlp')->name("checkListArribaGlp");
            Route::get('/checkListAbajoGlp/{idCert}', 'generarCheckListAbajoGlp')->name("checkListAbajoGlp");

            //Ruta para ver certificado modificacion
            Route::get('/certificado-modificacion/{id}', 'generaPdfModificacion')->name("certificadoModificacion");
            //Ruta para descargar certificado modificacion
            Route::get('/certificado-modificacion/{id}/descargar', 'descargaPdfModificacion')->name("descargarCertificadoModificacion");

            //Rutas para generar cargo de materiales
            Route::get('/cargo/{id}', 'generaCargo')->name('generaCargo');

            Route::get('/boletoAnalizadorDeGases/{id}', 'generaBoletoDeAnalizador')->name("analizadorGnv");
        });

        //Rutas para los notificaciones
        Route::get("expediente-fotos/{id}/download", "App\Http\Controllers\ZipController@descargaFotosExpediente")->name("descargaFotosExp");
        Route::get("Notification/{idNoti}/{idSoli}", "App\Http\Controllers\NotificationController@marcarUnaNotificación")->name("leerNotificacion");
        Route::get("Notification/{idNoti}anular", "App\Http\Controllers\AnulacionController@marcarAnulacion")->name("leerAnular");
        Route::get("Notification/{idNoti}eliminar", "App\Http\Controllers\EliminacionController@marcarEliminacion")->name("leerEliminar");
        Route::get("Notification/{idNoti}memorando", "App\Http\Controllers\MemorandoController@marcarMemorando")->name("leerMemorando");
        //Route::get('/leer-memorando/{notification}', [MemorandoController::class, 'marcarMemorando'])->name('leerMemorando');


        Route::get('download/{path}', function ($path) {
            return Illuminate\Support\Facades\Storage::download($path);
        })->where('path', '.*');
        Route::get('/CargoPdf/{id}', function ($id) {
            $am = new AsignacionMateriales();
            return  $am->enviar($id);
        })->name('cargoPdf');
        Route::get('/Certificado/{id}', function ($id) {
            $ser = new Servicio();
            return  $ser->generaPdfAnualGnv($id);
        })->name('certificado');
        Route::get('/Certificado/{id}/download', function ($id) {
            $ser = new Servicio();
            return  $ser->descargaPdfAnualGnv($id);
        })->name('descargarCertificado');
        Route::get('/CertificadoInicial/{id}', function ($id) {
            $ser = new Servicio();
            return  $ser->generaPdfInicialGnv($id);
        })->name('certificadoInicial');
        Route::get('/CertificadoInicial/{id}/download', function ($id) {
            $ser = new Servicio();
            return  $ser->descargaPdfInicialGnv($id);
        })->name('descargarInicial');
    });
