<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anulacion;
use App\Models\Boleta;
use App\Models\CartaAclaratoria;
use App\Models\Certificacion;
use App\Models\CertificacionTaller;
use App\Models\ContratoTrabajo;
use App\Models\Duplicado;
use App\Models\Expediente;
use App\Models\Memorando;
use App\Models\Salida;
use App\Models\User;
use App\Models\VacacionAsignada;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Nette\Utils\Json;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{
    //vista y descarga de ANUALES FICHAS TECNICAS GNV

    public function generarFichaTecnica($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $chip = $certificacion->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
            $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
            //dd($equipos);
            $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
            $fechaCert = $certificacion->created_at;
            $fec = $fechaCert->format("d/m/Y");
            $data = [
                "fecha" => $fec,
                "empresa" => "MOTORGAS COMPANY S.A.",
                "carro" => $certificacion->Vehiculo,
                "taller" => $certificacion->Taller,
                "servicio" => $certificacion->Servicio,
                "hoja" => $hoja,
                "equipos" => $equipos,
                "chip" => $chip,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('fichaTecnicaGnv', $data);
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->stream("FT-" . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
        } else {
            return abort(404);
        }
    }

    public function datosParaFichaTecnica($id)
    {
        $certificacion = Certificacion::find($id);
        $chip = $certificacion->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
        $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
        //dd($equipos);
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
        $fechaCert = $certificacion->created_at;
        $fec = $fechaCert->format("d/m/Y");
        $data = [
            "certificacion" => $certificacion,
            "fecha" => $fec,
            "empresa" => "MOTORGAS COMPANY S.A.",
            "carro" => $certificacion->Vehiculo,
            "taller" => $certificacion->Taller,
            "servicio" => $certificacion->Servicio,
            "hoja" => $hoja,
            "equipos" => $equipos,
            "chip" => $chip,
        ];

        return $data;
    }

    public function descargarFichaTecnica($idCert)
    {
        if (Certificacion::findOrFail($idCert)) {
            $data = $this->datosParaFichaTecnica($idCert);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('fichaTecnicaGnv', $data);
            return  $pdf->download('FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '.pdf');
        } else {
            return abort(404);
        }
    }

    public function generarFichaTecnicaGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            $meses = array(
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            );
            $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
            $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
            $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
            $fechaCert = $certificacion->created_at;
            $fec = $fechaCert->format("d/m/Y");
            $data = [
                "fecha" => $fec,
                "empresa" => "MOTORGAS COMPANY S.A.",
                "carro" => $certificacion->Vehiculo,
                "taller" => $certificacion->Taller,
                "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                "servicio" => $certificacion->Servicio,
                "cargaUtil" => $cargaUtil,
                "hoja" => $hoja,
                "numHoja" => $this->completarConCeros($hoja->numSerie),
                "equipos" => $equipos,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('fichaTecnicaGlp', $data);
            return  $pdf->stream("FT-" . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-glp.pdf');
        } else {
            return abort(404);
        }
    }

    public function descargarFichaTecnicaGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            $meses = array(
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            );
            $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
            $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
            $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
            $fechaCert = $certificacion->created_at;
            $fec = $fechaCert->format("d/m/Y");
            $data = [
                "fecha" => $fec,
                "empresa" => "MOTORGAS COMPANY S.A.",
                "carro" => $certificacion->Vehiculo,
                "taller" => $certificacion->Taller,
                "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                "servicio" => $certificacion->Servicio,
                "cargaUtil" => $cargaUtil,
                "hoja" => $hoja,
                "numHoja" => $this->completarConCeros($hoja->numSerie),
                "equipos" => $equipos,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('fichaTecnicaGlp', $data);
            return  $pdf->download("FT-" . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-glp.pdf');
        } else {
            return abort(404);
        }
    }


    //vistas de CHECKLIST GNV (SOLO VISTAS)

    public function generarCheckListArribaGnv($idCert)
    {
        if (Certificacion::findOrFail($idCert)) {
            $certificacion = Certificacion::find($idCert);
            //$hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();
            $hoja = $certificacion->Hoja;
            //dd($certificacion->Chip);
            $data = [
                'hoja' => $hoja,
                "vehiculo" => $certificacion->Vehiculo,
                "servicio" => $certificacion->Servicio,
                "inspector" => $certificacion->Inspector,
                "taller" => $certificacion->taller,
                "fecha" => $certificacion->created_at->format('d/m/Y'),
                "reductor" => $certificacion->Reductor,
                "chip" => $certificacion->Chip,
                "cilindros" => $certificacion->Cilindros,
                "certificacion" => $certificacion,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('checkListCilindroArribaGnv', $data);
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->stream('CHKL_ARRIBA-' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
        } else {
            return abort(404);
        }
    }

    public function generarCheckListAbajoGnv($idCert)
    {
        if (Certificacion::findOrFail($idCert)) {
            $certificacion = Certificacion::find($idCert);
            //$hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();
            $hoja = $certificacion->Hoja;
            $data = [
                'hoja' => $hoja,
                "vehiculo" => $certificacion->Vehiculo,
                "servicio" => $certificacion->Servicio,
                "inspector" => $certificacion->Inspector,
                "taller" => $certificacion->taller,
                "fecha" => $certificacion->created_at->format('d/m/Y'),
                "reductor" => $certificacion->Reductor,
                "chip" => $certificacion->Chip,
                "cilindros" => $certificacion->Cilindros,
                "certificacion" => $certificacion,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('checkListCilindroAbajoGnv', $data);
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->stream('CHKL_ABAJO-' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
        } else {
            return abort(404);
        }
    }

    //vistas de CHECKLIST GNV (SOLO VISTAS)

    public function generarCheckListArribaGlp($idCert)
    {
        if (Certificacion::findOrFail($idCert)) {
            $certificacion = Certificacion::find($idCert);
            //$hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();
            $hoja = $certificacion->Hoja;
            //dd($certificacion->Chip)
            //para asignar rutaFirma de solo los inspectores autorizados
            $inspector = $certificacion->Inspector;
            $inspectorAutorizado = $inspector->inspectorAutorizado;            
            if ($inspectorAutorizado) {
                $rutaFirma = $inspectorAutorizado->rutaFirma;
                $rutaNombre = $inspectorAutorizado->name;            
            } else {
                $rutaFirma = $certificacion->Inspector->rutaFirma;
                $rutaNombre = $certificacion->Inspector->name;
            }
            //dd($rutaFirma); 

            $data = [
                'hoja' => $hoja,
                "vehiculo" => $certificacion->Vehiculo,
                "servicio" => $certificacion->Servicio,
                "inspector" => $certificacion->Inspector,
                "taller" => $certificacion->taller,
                "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                "fecha" => $certificacion->created_at->format('d/m/Y'),
                "reductor" => $certificacion->ReductorGlp,
                "cilindros" => $certificacion->CilindrosGlp,
                "certificacion" => $certificacion,
                "rutaFirma" => $rutaFirma, // Aquí pasamos la firma que corresponde
                "rutaNombre" => $rutaNombre, 
            ];
            
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('checkListCilindroArribaGlp', $data);
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->stream('CHKL_ARRIBA_GLP-' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
        } else {
            return abort(404);
        }
    }

    public function generarCheckListAbajoGlp($idCert)
    {
        if (Certificacion::findOrFail($idCert)) {
            $certificacion = Certificacion::find($idCert);
            //$hoja=$certificacion->Materiales->where('idTipoMaterial',1)->first();
            $hoja = $certificacion->Hoja;
            //para asignar rutaFirma de solo los inspectores autorizados
            $inspector = $certificacion->Inspector;
            $inspectorAutorizado = $inspector->inspectorAutorizado;            
            if ($inspectorAutorizado) {
                $rutaFirma = $inspectorAutorizado->rutaFirma;
                $rutaNombre = $inspectorAutorizado->name;
            } else {
                $rutaFirma = $certificacion->Inspector->rutaFirma;
                $rutaNombre = $certificacion->Inspector->name;
            }
            //dd($rutaFirma); 
            

            $data = [
                'hoja' => $hoja,
                "vehiculo" => $certificacion->Vehiculo,
                "servicio" => $certificacion->Servicio,
                "inspector" => $certificacion->Inspector,
                "taller" => $certificacion->Taller,
                "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                "fecha" => $certificacion->created_at->format('d/m/Y'),
                "reductor" => $certificacion->ReductorGlp,
                "cilindros" => $certificacion->CilindrosGlp,
                "certificacion" => $certificacion,
                "rutaFirma" => $rutaFirma, // Aquí pasamos la firma que corresponde 
                "rutaNombre" => $rutaNombre, 
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('checkListCilindroAbajoGlp', $data);
            //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
            return  $pdf->stream('CHKL_ABAJO_GLP-' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
        } else {
            return abort(404);
        }
    }



    public function calculaCargaUtil($pesoBruto, $pesoNeto)
    {
        if ($pesoBruto && $pesoNeto) {
            $cu = $pesoBruto - $pesoNeto;
            return ($pesoBruto - $pesoNeto);
        }
    }

    //vista y descarga de Modificacion

    public function generaPdfModificacion($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 5) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 4)->first();
                    // Asegúrate de cargar las relaciones necesarias (modificacion)
                    $certificacion->load('Vehiculo.modificaciones');
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfModificacion', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfModificacion', $id, false);

                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "hoja" => $hoja,
                        "fechaCert" => $fechaCert,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "modificacion" => $certificacion->Vehiculo->modificaciones->last(),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('modificacion', $data);
                    return $pdf->stream($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-modificacion.pdf'); //esto de donde saca
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function descargaPdfModificacion($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 5) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 4)->first();
                    // Asegúrate de cargar las relaciones necesarias (modificacion)
                    $certificacion->load('Vehiculo.modificaciones');
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfModificacion', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "hoja" => $hoja,
                        "fechaCert" => $fechaCert,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "modificacion" => $certificacion->Vehiculo->modificaciones->last(),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('modificacion', $data);
                    return $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-modificacion.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    //vista y descarga de ANUALES GNV

    public function generaPdfAnualGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 2) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnual', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "hoja" => $hoja,
                        "fechaCert" => $fechaCert,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    //$data['qrCode'] = $qrCode;
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('anualGnv', $data);
                    return $pdf->stream($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    function completarConCeros($numero, $longitudDeseada = 7)
    {
        // Convierte el número a una cadena y completa con ceros a la izquierda
        return str_pad((string)$numero, $longitudDeseada, '0', STR_PAD_LEFT);
    }

    //pdfs glp
    public function generaPdfAnualGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 4) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualGlp', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "cargaUtil" => $cargaUtil,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                        "hoja" => $hoja,
                        "numHoja" => $this->completarConCeros($hoja->numSerie),
                        "fechaCert" => $fechaCert,
                        "equipos" => $equipos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('anualGlp', $data);
                    return $pdf->stream($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual-glp.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function descargaPdfAnualGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 4) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualGlp', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "cargaUtil" => $cargaUtil,
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                        "hoja" => $hoja,
                        "numHoja" => $this->completarConCeros($hoja->numSerie),
                        "fechaCert" => $fechaCert,
                        "equipos" => $equipos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('anualGlp', $data);
                    return $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual-glp.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function generaPdfInicialGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 3) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialGlp', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "cargaUtil" => $cargaUtil,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                        "hoja" => $hoja,
                        "numHoja" => $this->completarConCeros($hoja->numSerie),
                        "fechaCert" => $fechaCert,
                        "equipos" => $equipos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('conversionGlp', $data);
                    return $pdf->stream($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial-glp.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function descargaPdfInicialGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 3) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialGlp', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "cargaUtil" => $cargaUtil,
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                        "hoja" => $hoja,
                        "numHoja" => $this->completarConCeros($hoja->numSerie),
                        "fechaCert" => $fechaCert,
                        "equipos" => $equipos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('conversionGlp', $data);
                    return $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial-glp.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function devuelveDatoParseado($num)
    {
        $str = (string) $num;
        if (substr($num, -1) != 0) {
            return rtrim($num);
        } else {
            return  bcdiv($num, '1', 2);
        }
    }

    public function descargarPdfAnualGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);

            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = $certificacion->created_at;
            $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
            $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
            // Genera el código QR
            $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnual', $id, false);
            $qrCode = QrCode::size(70)->generate($urlDelDocumento);
            $data = [
                "fecha" => $fecha,
                "empresa" => "MOTORGAS COMPANY S.A.",
                "carro" => $certificacion->Vehiculo,
                "taller" => $certificacion->Taller,
                "hoja" => $hoja,
                "fechaCert" => $fechaCert,
                "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                "qrCode" => $qrCode,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('anualGnv', $data);
            return $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual.pdf');
        } else {
            return abort(404);
        }
    }

    //vista y descarga de INCIALES GNV

    public function generaPdfInicialGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 1 || $certificacion->Servicio->tipoServicio->id == 10) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $chip = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    //dd($chip);
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicial', $id, false); // Reemplaza 'certificadoAnualGnv' con el nombre correcto de tu ruta
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "fechaCert" => $fechaCert,
                        "pesos" => $certificacion->calculaPesos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('conversionGnv', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->stream($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }


    public function descargarPdfInicialGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = $certificacion->created_at;
            $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
            $chip = $certificacion->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
            $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
            $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
            // Genera el código QR
            $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicial', $id, false);
            $qrCode = QrCode::size(70)->generate($urlDelDocumento);
            $data = [
                "fecha" => $fecha,
                "empresa" => "MOTORGAS COMPANY S.A.",
                "carro" => $certificacion->Vehiculo,
                "taller" => $certificacion->Taller,
                "hoja" => $hoja,
                "equipos" => $equipos,
                "chip" => $chip,
                "fechaCert" => $fechaCert,
                "pesos" => $certificacion->calculaPesos,
                "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                "qrCode" => $qrCode,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('conversionGnv', $data);
            return  $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial.pdf');
        } else {
            return abort(404);
        }
    }


    //Vista y descarga de PRE-CONVERSIONES

    public function generaPdfPreGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 12) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $chip = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfPreGnvPdf', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "fechaCert" => $fechaCert,
                        "cargaUtil" => $cargaUtil,
                        "pesos" => $certificacion->calculaPesos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('preConverGnv', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->stream('Pre-Conver' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie);
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function generaPdfPreGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 13) //este es el error
                {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfPreInicialGlp', $id, false); //tu ruta es para inicial no para preconver
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "cargaUtil" => $cargaUtil,
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "tallerauto" => $certificacion->TallerAuto, // para taller autorizado
                        "hoja" => $hoja,
                        "numHoja" => $this->completarConCeros($hoja->numSerie),
                        "fechaCert" => $fechaCert,
                        "equipos" => $equipos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    //dd($certificacion->Vehiculo);
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('conversionGlp', $data);

                    return $pdf->stream($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual-glp.pdf');
                }

                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function generaDescargaPreGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 12) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $certificacion->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $chip = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    //dd($chip);
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfPreGnvPdf', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "fechaCert" => $fechaCert,
                        "pesos" => $certificacion->calculaPesos,
                        "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('preConverGnv', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->download('Pre-Conver' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie);
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    //vista y descarga de DUPLICADOS ANUALES GNV

    public function generaDuplicadoAnualGnv($id)
    {

        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $antiguo = Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($duplicado->Servicio->tipoServicio->id) {
                if ($antiguo->Servicio->tipoServicio->id == 2) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $duplicado->created_at;
                    $fechaAntiguo = $antiguo->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $duplicado->Hoja;
                    $hojaAntiguo = $antiguo->Hoja;
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualDupli', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $duplicado->Vehiculo,
                        "taller" => $antiguo->Taller,
                        "hoja" => $hoja,
                        "fechaCert" => $fechaCert,
                        "fechaAntiguo" => $fechaAntiguo,
                        "hojaAntiguo" => $hojaAntiguo,
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('duplicadoAnualGnv', $data);
                    return $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-anual.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function descargarDuplicadoAnualGnv($id)
    {

        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $antiguo = Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($duplicado->Servicio->tipoServicio->id) {
                if ($antiguo->Servicio->tipoServicio->id == 2) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $duplicado->created_at;
                    $fechaAntiguo = $antiguo->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $duplicado->Hoja;
                    $hojaAntiguo = $antiguo->Hoja;
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualDupli', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $duplicado->Vehiculo,
                        "taller" => $antiguo->Taller,
                        "hoja" => $hoja,
                        "fechaCert" => $fechaCert,
                        "fechaAntiguo" => $fechaAntiguo,
                        "hojaAntiguo" => $hojaAntiguo,
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('duplicadoAnualGnv', $data);
                    return $pdf->download($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-anual.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    //vista y descarga de DUPLICADOS INICIALES GNV

    public function generaDuplicadoInicialGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $antiguo = Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($antiguo->Servicio->tipoServicio->id) {
                if ($antiguo->Servicio->tipoServicio->id == 1) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $duplicado->created_at;
                    $fechaAntiguo = $antiguo->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $chip = $duplicado->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $duplicado->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    //dd($equipos);
                    $hoja = $duplicado->Hoja;
                    $hojaAntiguo = $antiguo->Hoja;
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialDupli', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $duplicado->Vehiculo,
                        "taller" => $duplicado->Taller,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "fechaCert" => $fechaCert, //para fecha cert
                        "fechaAntiguo" => $fechaAntiguo,
                        "hojaAntiguo" => $hojaAntiguo,
                        "pesos" => $antiguo->calculaPesos,
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('duplicadoInicialGnv', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-inicial.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function descargarDuplicadoInicialGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $antiguo = Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($antiguo->Servicio->tipoServicio->id) {
                if ($antiguo->Servicio->tipoServicio->id == 1) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $duplicado->created_at;
                    $fechaAntiguo = $antiguo->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $chip = $duplicado->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $duplicado->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    //dd($equipos);
                    $hoja = $duplicado->Hoja;
                    $hojaAntiguo = $antiguo->Hoja;
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialDupli', $id, false);
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                    $data = [
                        "fecha" => $fecha,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $duplicado->Vehiculo,
                        "taller" => $duplicado->Taller,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "fechaCert" => $fechaCert, //para fecha cert
                        "fechaAntiguo" => $fechaAntiguo,
                        "hojaAntiguo" => $hojaAntiguo,
                        "pesos" => $antiguo->calculaPesos,
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('duplicadoInicialGnv', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->download($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-inicial.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    //vista y descarga de DUPLICADOS EXTERNOS ANUALES GNV

    public function generaDuplicadoExternoAnualGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $dupli = Duplicado::find($duplicado->idDuplicado);
            // $fec=$dupli->fecha;
            //$hojaAntiguo=$antiguo->Hoja;
            // dd($dupli->fecha->format("d/m/Y"));
            //dd($duplicado);
            //$antiguo=Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($dupli->servicio == 2) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $fechaCert = $duplicado->created_at;
                //$fechaAntiguo=$antiguo->created_at;
                $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                $hoja = $duplicado->Hoja;
                //$fec=$dupli->fecha;
                //$hojaAntiguo=$antiguo->Hoja;
                // Genera el código QR
                $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualDupliExt', $id, false);
                $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                $data = [
                    "fecha" => $fecha,
                    "empresa" => "MOTORGAS COMPANY S.A.",
                    "carro" => $duplicado->Vehiculo,
                    "taller" => $duplicado->Duplicado->taller,
                    "hoja" => $hoja,
                    "fechaCert" => $fechaCert,
                    "fechaAntiguo" => Carbon::parse($dupli->fecha),
                    //"hojaAntiguo"=>$hojaAntiguo,
                    "qrCode" => $qrCode,
                ];
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('duplicadoExternoAnualGnv', $data);
                return $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicadoEx-anual.pdf');
            }
            return abort(404);
        } else {
            return abort(404);
        }
    }

    public function descargarDuplicadoExternoAnualGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $dupli = Duplicado::find($duplicado->idDuplicado);
            // $fec=$dupli->fecha;
            //$hojaAntiguo=$antiguo->Hoja;
            // dd($dupli->fecha->format("d/m/Y"));
            //dd($duplicado);
            //$antiguo=Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($dupli->servicio == 2) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $fechaCert = $duplicado->created_at;
                //$fechaAntiguo=$antiguo->created_at;
                $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                $hoja = $duplicado->Hoja;
                //$fec=$dupli->fecha;
                //$hojaAntiguo=$antiguo->Hoja;
                // Genera el código QR
                $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualDupliExt', $id, false);
                $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                $data = [
                    "fecha" => $fecha,
                    "empresa" => "MOTORGAS COMPANY S.A.",
                    "carro" => $duplicado->Vehiculo,
                    "taller" => $duplicado->Duplicado->taller,
                    "hoja" => $hoja,
                    "fechaCert" => $fechaCert,
                    "fechaAntiguo" => Carbon::parse($dupli->fecha),
                    //"hojaAntiguo"=>$hojaAntiguo,
                    "qrCode" => $qrCode,
                ];
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('duplicadoExternoAnualGnv', $data);
                return $pdf->download($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicadoEx-anual.pdf');
            }
            return abort(404);
        } else {
            return abort(404);
        }
    }
    //vista y descarga de DUPLICADOS EXTERNOS INICIALES GNV

    public function generaDuplicadoExternoInicialGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $dupli = Duplicado::find($duplicado->idDuplicado);
            if ($dupli->servicio == 1) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $fechaCert = $duplicado->created_at;
                //$fechaAntiguo=$antiguo->created_at;
                $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                $chip = $duplicado->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                $equipos = $duplicado->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                //dd($equipos);
                $hoja = $duplicado->Hoja;
                // $hojaAntiguo=$antiguo->Hoja;
                // Genera el código QR
                $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialDupliExt', $id, false);
                $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                $data = [
                    "fecha" => $fecha,
                    "empresa" => "MOTORGAS COMPANY S.A.",
                    "carro" => $duplicado->Vehiculo,
                    "taller" => $duplicado->Duplicado->taller,
                    "hoja" => $hoja,
                    "fechaCert" => $fechaCert,
                    "equipos" => $equipos,
                    "chip" => $chip,
                    "fechaAntiguo" => Carbon::parse($dupli->fecha),
                    "pesos" => $duplicado->calculaPesos,
                    "qrCode" => $qrCode,
                ];
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('duplicadoExternoInicialGnv', $data);
                //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                return  $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-inicial.pdf');
            }
            return abort(404);
        } else {
            return abort(404);
        }
    }

    public function descargarDuplicadoExternoInicialGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $dupli = Duplicado::find($duplicado->idDuplicado);
            if ($dupli->servicio == 1) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $fechaCert = $duplicado->created_at;
                //$fechaAntiguo=$antiguo->created_at;
                $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                $chip = $duplicado->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                $equipos = $duplicado->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                //dd($equipos);
                $hoja = $duplicado->Hoja;
                // $hojaAntiguo=$antiguo->Hoja;
                // Genera el código QR
                $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialDupliExt', $id, false);
                $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                $data = [
                    "fecha" => $fecha,
                    "empresa" => "MOTORGAS COMPANY S.A.",
                    "carro" => $duplicado->Vehiculo,
                    "taller" => $duplicado->Duplicado->taller,
                    "hoja" => $hoja,
                    "fechaCert" => $fechaCert,
                    "equipos" => $equipos,
                    "chip" => $chip,
                    "fechaAntiguo" => Carbon::parse($dupli->fecha),
                    "pesos" => $duplicado->calculaPesos,
                    "qrCode" => $qrCode,
                ];
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('duplicadoExternoInicialGnv', $data);
                //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                return  $pdf->download($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-inicial.pdf');
            }
            return abort(404);
        } else {
            return abort(404);
        }
    }

    //vista y descarga de FICHAS DE PRECONVERSION GNV
    public function generarPreConversionGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 1 || $certificacion->Servicio->tipoServicio->id == 10) {
                    $chip = $certificacion->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    //dd($equipos);
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
                    $fechaCert = $certificacion->created_at;
                    $fec = $fechaCert->format("d/m/Y");
                    $data = [
                        "fecha" => $fec,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "servicio" => $certificacion->Servicio,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "cilindros" => $this->estadoCilindrosMotor($certificacion->Vehiculo->cilindros),
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('preConversion', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->stream("PreConver-" . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
                }
            }
        } else {
            return abort(404);
        }
    }

    public function descargarPreConversionGnv($id)
    {
        if (Certificacion::findOrFail($id)) {
            $certificacion = Certificacion::find($id);
            if ($certificacion->Servicio->tipoServicio->id) {
                if ($certificacion->Servicio->tipoServicio->id == 1 || $certificacion->Servicio->tipoServicio->id == 10) {
                    $chip = $certificacion->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
                    $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
                    //dd($equipos);
                    $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
                    $fechaCert = $certificacion->created_at;
                    $fec = $fechaCert->format("d/m/Y");
                    $data = [
                        "fecha" => $fec,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $certificacion->Vehiculo,
                        "taller" => $certificacion->Taller,
                        "servicio" => $certificacion->Servicio,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "chip" => $chip,
                        "cilindros" => $this->estadoCilindrosMotor($certificacion->Vehiculo->cilindros),
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('preConversion', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->download("PreConver-" . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '.pdf');
                }
            }
        } else {
            return abort(404);
        }
    }

    //FUNCION PARA PRESION DE CILINDROS
    public function estadoCilindrosMotor($cilindros)
    {
        $cil = new Collection();

        for ($i = 1; $i <= $cilindros; $i++) {
            $presion = mt_rand(145, 175);
            $data =
                [
                    "numeracion" => "Cilindro " . $i,
                    "presion" => $presion,
                ];
            $cil->push($data);
        }

        return $cil;
    }

    public function generaCargo($id)
    {
        $sal = Salida::find($id);

        $materiales = $this->materialesPorAsigancion($sal);
        $cambios = $this->materialesPorCambio($sal);
        $prestamos = $this->materialesPorPrestamo($sal);
        //$series=$this->encuentraSeries($materiales->all());
        $inspector = $sal->usuarioAsignado;
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecSal = $sal->created_at;
        $fecha = $fecSal->format('d') . ' de ' . $meses[$fecSal->format('m') - 1] . ' del ' . $fecSal->format('Y') . '.';
        $data = [
            "date" => $fecha,
            "empresa" => "MOTORGAS COMPANY S.A.",
            "inspector" => $inspector->name,
            "materiales" => $materiales,
            "cambios" => $cambios,
            "prestamos" => $prestamos,
            "salida" => $sal,
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('cargoPDF', $data);
        return $pdf->stream(date('d-m-Y') . '_' . $inspector->name . '-cargo.pdf');
    }

    public function materialesPorAsigancion(Salida $salida)
    {
        $materiales = new Collection();
        $gnvs = $salida->porAsignacion->where("idTipoMaterial", 1);
        $glps = $salida->porAsignacion->where("idTipoMaterial", 3);
        $chips = $salida->porAsignacion->where("idTipoMaterial", 2);
        $modis = $salida->porAsignacion->where("idTipoMaterial", 4);

        //dd($gnvs->get()->pluck("numSerie")->all());
        if ($gnvs->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($gnvs->get()->sortBy("numSerie")->all()), "tipo" => $gnvs->first()->tipo->descripcion, "cantidad" => $gnvs->count(), "motivo" => $gnvs->first()->detalle->motivo]);
        }
        if ($glps->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($glps->get()->all()), "tipo" => $glps->first()->tipo->descripcion, "cantidad" => $glps->count(), "motivo" => $glps->first()->detalle->motivo]);
        }
        if ($chips->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($chips->get()->all()), "tipo" => $chips->first()->tipo->descripcion, "cantidad" => $chips->count(), "motivo" => $chips->first()->detalle->motivo]);
        }

        if ($modis->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($modis->get()->all()), "tipo" => $modis->first()->tipo->descripcion, "cantidad" => $modis->count(), "motivo" => $modis->first()->detalle->motivo]);
        }

        return $materiales;
    }

    public function materialesPorCambio(Salida $salida)
    {
        $materiales = new Collection();
        $gnvs = $salida->porCambio->where("idTipoMaterial", 1);
        $glps = $salida->porCambio->where("idTipoMaterial", 3);
        $chips = $salida->porCambio->where("idTipoMaterial", 2);
        $modis = $salida->porCambio->where("idTipoMaterial", 4);

        //$gnvOrdenado=$gnvs->pluck('numSerie')->sortBy('numSerie')->all();


        //$primero=current($gnvOrdenado);
        //dd($gnvOrdenado);
        if ($gnvs->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($gnvs->get()->sortBy("numSerie")->all()), "tipo" => $gnvs->first()->tipo->descripcion, "cantidad" => $gnvs->count(), "motivo" => $gnvs->first()->detalle->motivo]);
        }
        if ($glps->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($glps->get()->all()), "tipo" => $glps->first()->tipo->descripcion, "cantidad" => $glps->count(), "motivo" => $glps->first()->detalle->motivo]);
        }
        if ($chips->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($chips->get()->all()), "tipo" => $chips->first()->tipo->descripcion, "cantidad" => $chips->count(), "motivo" => $chips->first()->detalle->motivo]);
        }
        if ($modis->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($modis->get()->all()), "tipo" => $modis->first()->tipo->descripcion, "cantidad" => $modis->count(), "motivo" => $modis->first()->detalle->motivo]);
        }
        return $materiales;
    }

    public function materialesPorPrestamo(Salida $salida)
    {
        $materiales = new Collection();
        //dd($salida->porPrestamo);
        $gnvs = $salida->porPrestamo->where("idTipoMaterial", 1);
        $glps = $salida->porPrestamo->where("idTipoMaterial", 3);
        $chips = $salida->porPrestamo->where("idTipoMaterial", 2);
        $modis = $salida->porPrestamo->where("idTipoMaterial", 4);

        //$gnvOrdenado=$gnvs->pluck('numSerie')->sortBy('numSerie')->all();


        //$primero=current($gnvOrdenado);
        //dd($gnvOrdenado);
        if ($gnvs->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($gnvs->get()->sortBy("numSerie")->all()), "tipo" => $gnvs->first()->tipo->descripcion, "cantidad" => $gnvs->count(), "motivo" => $gnvs->first()->detalle->motivo]);
        }
        if ($glps->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($glps->get()->all()), "tipo" => $glps->first()->tipo->descripcion, "cantidad" => $glps->count(), "motivo" => $glps->first()->detalle->motivo]);
        }
        if ($chips->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($chips->get()->all()), "tipo" => $chips->first()->tipo->descripcion, "cantidad" => $chips->count(), "motivo" => $chips->first()->detalle->motivo]);
        }
        if ($modis->count() > 0) {
            $materiales->push(["series" => $this->encuentraSeries($modis->get()->all()), "tipo" => $modis->first()->tipo->descripcion, "cantidad" => $modis->count(), "motivo" => $modis->first()->detalle->motivo]);
        }
        return $materiales;
    }

    public function encuentraSeries($arreglo)
    {
        //dd($arreglo);
        //$arreglo=json_decode($arr);
        $inicio = $arreglo[0]["numSerie"];
        $final = $arreglo[0]["numSerie"];
        $nuevos = [];

        foreach ($arreglo as $key => $rec) {
            if ($key + 1 < count($arreglo)) {
                if ($arreglo[$key + 1]["numSerie"] - $rec["numSerie"] == 1) {
                    //if($rec["numSerie"]+1 == next($arreglo)['numSerie']){
                    //$final=next($arreglo)["numSerie"];
                    $final = $arreglo[$key + 1]["numSerie"];
                } else {
                    array_push($nuevos, ["inicio" => $inicio, "final" => $final]);
                    $inicio = $arreglo[$key + 1]["numSerie"];
                    $final = $arreglo[$key + 1]["numSerie"];
                }
            } else {
                $final = $arreglo[$key]["numSerie"];
                array_push($nuevos, ["inicio" => $inicio, "final" => $final]);
            }
        }
        return $nuevos;
    }

    public function generaBoletoDeAnalizador($id)
    {
        $archivo = fopen("storage/voucherTalleres/plantilla_JR.txt", "r+");
        /*
        fwrite($archivo, "HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAA".$id);

        fclose($archivo);
        echo("todo oK");
        */
        while (!feof($archivo)) {
            $leer = fgets($archivo);
            $saltodelinea = nl2br($leer);
            echo $saltodelinea;
        }
    }

    //Vista y descarga para memorando
    public function generaPdfMemorando($id)
    {
        $memorando = Memorando::findOrFail($id);
        if ($memorando) {
            $usuario = User::findOrFail($memorando->idUser);
            $nombreUsuario = $usuario->name;
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = is_string($memorando->fecha) ? new DateTime($memorando->fecha) : $memorando->fecha;
            $fechaForma = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');

            $data = [
                'idUser' => $nombreUsuario,
                'fecha' => $fechaForma,
                'remitente' => $memorando->remitente,
                'cargo' => $memorando->cargo,
                'cargoremi' => $memorando->cargoremi,
                'motivo' => $memorando->motivo,
            ];

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('memorando', $data);
            return $pdf->stream($memorando->id . '-memorando.pdf');
        } else {
            abort(404);
        }
    }

    public function descargaPdfMemorando($id)
    {
        $memorando = Memorando::findOrFail($id);
        if ($memorando) {
            $usuario = User::findOrFail($memorando->idUser);
            $nombreUsuario = $usuario->name;
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = is_string($memorando->fecha) ? new DateTime($memorando->fecha) : $memorando->fecha;
            $fechaForma = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');
            $data = [
                'idUser' => $nombreUsuario,
                'fecha' => $fechaForma,
                'remitente' => $memorando->remitente,
                'cargo' => $memorando->cargo,
                'cargoremi' => $memorando->cargoremi,
                'motivo' => $memorando->motivo,
            ];

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('memorando', $data);
            return $pdf->download($memorando->id . '-memorando.pdf');
        } else {
            abort(404);
        }
    }

    //Vista y descarga para contrato
    public function generaPdfContrato($id)
    {
        $contrato = ContratoTrabajo::findOrFail($id);
        if ($contrato) {
            $usuario = User::findOrFail($contrato->idUser);
            $nombreUsuario = $usuario->name;
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = is_string($contrato->fechaInicio) ? new DateTime($contrato->fechaInicio) : $contrato->fechaInicio;
            $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');

            $fechaCertInicio = is_string($contrato->fechaIniciodos) ? new DateTime($contrato->fechaIniciodos) : $contrato->fechaIniciodos;
            $fechaInicio = $fechaCertInicio->format('d') . ' de ' . $meses[$fechaCertInicio->format('m') - 1] . ' del ' . $fechaCertInicio->format('Y');

            $fechaCert2 = is_string($contrato->fechaExpiracion) ? new DateTime($contrato->fechaExpiracion) : $contrato->fechaExpiracion;
            $fechaForma2 = $fechaCert2->format('d') . ' de ' . $meses[$fechaCert2->format('m') - 1] . ' del ' . $fechaCert2->format('Y');

            $pagoForma2 = $this->convertirMontoAPalabras($contrato->pago);
            $valorSoles = $contrato->pago % 1000;
            $pagoForma = $contrato->pago . ' - ' . $pagoForma2 . ' con 00/' . $valorSoles . ' soles';

            $data = [
                'nombreEmpleado' => $nombreUsuario,
                'dniEmpleado' => $contrato->dniEmpleado,
                'domicilioEmpleado' => $contrato->domicilioEmpleado,
                'fechaBase' => $fechaForma,
                'fechaInicio' => $fechaInicio,
                'fechaExpiracion' => $fechaForma2,
                'cargo' => $contrato->cargo,
                'pago' => $pagoForma,
            ];

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('contrato', $data);
            return $pdf->stream($contrato->id . '-contrato.pdf');
        } else {
            abort(404);
        }
    }

    public function descargaPdfContrato($id)
    {
        $contrato = ContratoTrabajo::findOrFail($id);
        if ($contrato) {
            $usuario = User::findOrFail($contrato->idUser);
            $nombreUsuario = $usuario->name;
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = is_string($contrato->fechaInicio) ? new DateTime($contrato->fechaInicio) : $contrato->fechaInicio;
            $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');

            $fechaCertInicio = is_string($contrato->fechaIniciodos) ? new DateTime($contrato->fechaIniciodos) : $contrato->fechaIniciodos;
            $fechaInicio = $fechaCertInicio->format('d') . ' de ' . $meses[$fechaCertInicio->format('m') - 1] . ' del ' . $fechaCertInicio->format('Y');

            $fechaCert2 = is_string($contrato->fechaExpiracion) ? new DateTime($contrato->fechaExpiracion) : $contrato->fechaExpiracion;
            $fechaForma2 = $fechaCert2->format('d') . ' de ' . $meses[$fechaCert2->format('m') - 1] . ' del ' . $fechaCert2->format('Y');
            $pagoForma2 = $this->convertirMontoAPalabras($contrato->pago);
            $valorSoles = $contrato->pago % 1000;
            $pagoForma = $contrato->pago . ' - ' . $pagoForma2 . ' con 00/' . $valorSoles . ' soles';

            $data = [
                'nombreEmpleado' => $nombreUsuario,
                'dniEmpleado' => $contrato->dniEmpleado,
                'domicilioEmpleado' => $contrato->domicilioEmpleado,
                'fechaBase' => $fechaForma,
                'fechaInicio' => $fechaInicio,
                'fechaExpiracion' => $fechaForma2,
                'cargo' => $contrato->cargo,
                'pago' => $pagoForma,
            ];

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('contrato', $data);
            return $pdf->download($contrato->id . '-contrato.pdf');
        } else {
            abort(404);
        }
    }

    //Formatear pago de contrato
    private function convertirMontoAPalabras($monto)
    {
        $unidades = array('', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve');
        $decenas = array(20 => 'veinte', 30 => 'treinta', 40 => 'cuarenta', 50 => 'cincuenta', 60 => 'sesenta', 70 => 'setenta', 80 => 'ochenta', 90 => 'noventa');
        $centenas = array(100 => 'cien', 200 => 'doscientos', 300 => 'trescientos', 400 => 'cuatrocientos', 500 => 'quinientos', 600 => 'seiscientos', 700 => 'setecientos', 800 => 'ochocientos', 900 => 'novecientos');
        $miles = array(1000 => 'mil', 1000000 => 'millón', 1000000000 => 'mil millones');
        foreach (array_reverse($miles, true) as $valor => $palabra) {
            if ($monto >= $valor) {
                $parteEntera = floor($monto / $valor); // Obtener la parte entera del monto
                $parteRestante = $monto % $valor; // Obtener la parte restante del monto
                $parteEnteraStr = ($parteEntera == 1 && $valor == 1000) ? '' : $this->convertirMontoAPalabras($parteEntera); // Evitar "uno" para "mil"
                return trim($parteEnteraStr . ' ' . $palabra . ($parteRestante > 0 ? ' ' . $this->convertirMontoAPalabras($parteRestante) : '')); // Devolver la combinación de la parte entera y la parte restante
            }
        }
        if ($monto >= 100) {
            $centena = floor($monto / 100) * 100; // Obtener la centena más cercana
            $decena = $monto - $centena; // Obtener la parte restante (decenas y unidades)
            return $centenas[$centena] . ($decena ? ' ' . $this->convertirMontoAPalabras($decena) : ''); // Devolver la combinación de centena y parte restante
        }
        if ($monto >= 20) {
            $decena = floor($monto / 10) * 10; // Obtener la decena más cercana
            $unidad = $monto % 10; // Obtener la unidad
            return $decenas[$decena] . ($unidad ? ' y ' . $unidades[$unidad] : ''); // Devolver la combinación de decena y unidad
        }
        return $unidades[$monto];
    }

    //Vista para generar constancia de vacacion asignada
    public function generaPdfVacacionAsig($id)
    {
        $vacac = VacacionAsignada::findOrFail($id);
        if ($vacac) {
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fechaCert = is_string($vacac->created_at) ? new DateTime($vacac->created_at) : $vacac->created_at;
            $fechaForma = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');
            $inspector = $vacac->Vacacion->contrato->empleado->name ?? null;
            $cargo = $vacac->Vacacion->contrato->cargo ?? null;

            $emp = is_string($vacac->f_inicio) ? new DateTime($vacac->f_inicio) : $vacac->f_inicio;
            $empieza = $emp->format('d') . ' de ' . $meses[$emp->format('m') - 1] . ' del ' . $emp->format('Y');

            // Sumar los días tomados a la fecha de inicio
            $term = is_string($vacac->f_inicio) ? new DateTime($vacac->f_inicio) : $vacac->f_inicio;
            $term->modify('+' . ($vacac->d_tomados - 1) . ' days');  // Sumar los días tomados
            $termina = $term->format('d') . ' de ' . $meses[$term->format('m') - 1] . ' del ' . $term->format('Y');


            $data = [
                'fechaBase' => $fechaForma,
                'inspector' => $inspector,
                'cargo' => $cargo,
                'empieza' => $empieza,
                'termina' => $termina,
            ];

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('rptacomple', $data);
            return $pdf->stream($vacac->id . '-vacacionAsig.pdf');
        } else {
            abort(404);
        }
    }

    //Genera pdf boleta / vaucher
    public function generaPdfBoleta($id)
    {
        $boleta = Boleta::findOrFail($id);
        $documentos = $boleta->boletaarchivo;

        $data = [
            'documentos' => $documentos,
            'boleta' => $boleta,
        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('boletasimage', $data);
        return $pdf->stream('boleta-' . $id . '.pdf');
    }

    //Vista para generar pdf certificado de inspeccion de taller
    public function generaPdfCerTaller($id)    {

        $certi = CertificacionTaller::findOrFail($id);
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = is_string($certi->created_at) ? new DateTime($certi->created_at) : $certi->created_at;
        $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');
        // Genera el código QR
        $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfCerTaller', $id, false);        
        $qrCode = QrCode::size(70)->generate($urlDelDocumento);
        $data = [
            "certi" => $certi,
            "qrCode" => $qrCode,
            'fecha' => $fechaForma,
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('inspecciontaller', $data);
        // Mostrar el PDF en el navegador
        return $pdf->stream('certificado_taller_' . $id . '.pdf');

    }

    //Vista para generar pdf certa aclaratoria
    public function generaPdfCartaAclaratoria($id)    {

        $certi = CartaAclaratoria::findOrFail($id);
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = is_string($certi->created_at) ? new DateTime($certi->created_at) : $certi->created_at;
        $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');

        $diceData = [];
        $debeDecirData = [];
    
        if ($certi->tipo == 'FORMATO GNV' || $certi->tipo == 'FORMATO GLP') {           
            $diceData = $certi->dice_data;        
            $debeDecirData = $certi->debe_decir_data;       
        } elseif ($certi->tipo == 'MODIFICACION') {
            $diceData = explode("\n", $certi->dice_modificacion); // Convertimos el texto en array
            $debeDecirData = explode("\n", $certi->debe_decir_modificacion); // Convertimos el texto en array
        }        
        
        $data = [
            "certi" => $certi,
            'fecha' => $fechaForma,
            'diceData' => $diceData,
            'debeDecirData' => $debeDecirData,
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('cartaaclaratoria', $data);
        // Mostrar el PDF en el navegador
        return $pdf->stream('carta_aclaratoria_' . $id . '.pdf');

    }

    /*public function generaPdfSolicitudDevolucion($id)
    {
        $anulacion = Anulacion::findOrFail($id);
        $inspector = $anulacion->usuario->name;
        $material = $anulacion->material->descripcion;

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecSal = $anulacion->created_at;
        $fecha = $fecSal->format('d') . ' de ' . $meses[$fecSal->format('m') - 1] . ' del ' . $fecSal->format('Y') . '.';

        $pdfData = [
        "empresa" => "MOTORGAS COMPANY S.A.",
        "inspector" => $inspector,
        "tipoMaterial" => $material,
        "numSerieDesde" => $anulacion->numSerieDesde,
        "numSerieHasta" => $anulacion->numSerieHasta,
        "motivo" => $anulacion->motivo,
        "fecha" => $fecha,
        ];

        // Generar el PDF usando dompdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('cargoAnulacion', $pdfData);

        // Retornar el PDF generado
        return $pdf->stream('cargo_anulacion_' . $id . '.pdf');
    }*/

    public function generaPdfSolicitudDevolucion($cart_id)
    {
        // Obtener todas las anulaciones con el mismo cart_id
        $anulaciones = Anulacion::where('cart_id', $cart_id)->get();
        if ($anulaciones->isEmpty()) {
            // Manejar el caso en que no hay anulaciones para el cart_id dado
            abort(404, 'No se encontraron anulaciones para el identificador de carrito proporcionado.');
        }

        // Obtener el nombre del inspector
        $inspector = $anulaciones->first()->usuario->name;
        $empresa = "MOTORGAS COMPANY S.A.";
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $pdfData = [
            "empresa" => $empresa,
            "inspector" => $inspector,
            "anulaciones" => $anulaciones,
            "fecha" => now()->format('d') . ' de ' . $meses[now()->format('m') - 1] . ' del ' . now()->format('Y') . '.',
        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('cargoAnulacion', $pdfData);

        return $pdf->stream('cargo_anulacion_' . $cart_id . '.pdf');
    }

    
    //vista y descarga de DUPLICADOS ANUALES GLP
    public function generaDuplicadoAnualGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $antiguo = Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($duplicado->Servicio->tipoServicio->id) {
                if ($antiguo->Servicio->tipoServicio->id == 4) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $duplicado->created_at;
                    $fechaAntiguo = $antiguo->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $hoja = $duplicado->Hoja;
                    $hojaAntiguo = $antiguo->Hoja;
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualDupliGlp', $id, false); // cambiar la ruta para QR
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                    $equipos = $duplicado->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($duplicado->Vehiculo->pesoBruto, $duplicado->Vehiculo->pesoNeto);
                    $data = [
                        "fecha" => $fecha,
                        "cargaUtil" => $cargaUtil,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $duplicado->Vehiculo,
                        "taller" => $duplicado->Taller,
                        "tallerauto" => $duplicado->TallerAuto,
                        "hoja" => $hoja,
                        "fechaCert" => $fechaCert,
                        "fechaAntiguo" => $fechaAntiguo,
                        "hojaAntiguo" => $hojaAntiguo,
                        "equipos" => $equipos,
                        "largo" => $this->devuelveDatoParseado($duplicado->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($duplicado->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($duplicado->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('duplicadoAnualGlp', $data); //CAMBIAR LA VISTA PLANTILLA
                    return $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-anual-glp.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    //vista y descarga de DUPLICADOS INICIALES GLP
    public function generaDuplicadoInicialGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $antiguo = Certificacion::find($duplicado->Duplicado->idAnterior);
            if ($antiguo->Servicio->tipoServicio->id) {
                if ($antiguo->Servicio->tipoServicio->id == 3) {
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fechaCert = $duplicado->created_at;
                    $fechaAntiguo = $antiguo->created_at;
                    $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                    $equipos = $duplicado->vehiculo->Equipos->where("idTipoEquipo", "!=", 3)->sortBy("idTipoEquipo");
                    $cargaUtil = $this->calculaCargaUtil($duplicado->Vehiculo->pesoBruto, $duplicado->Vehiculo->pesoNeto);
                    //dd($equipos);
                    $hoja = $duplicado->Hoja;
                    $hojaAntiguo = $antiguo->Hoja;
                    // Genera el código QR
                    $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialDupliGlp', $id, false); // cambiar la ruta para QR
                    $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                    $data = [
                        "fecha" => $fecha,
                        "cargaUtil" => $cargaUtil,
                        "empresa" => "MOTORGAS COMPANY S.A.",
                        "carro" => $duplicado->Vehiculo,
                        "taller" => $duplicado->Taller,
                        "tallerauto" => $duplicado->TallerAuto,
                        "hoja" => $hoja,
                        "equipos" => $equipos,
                        "fechaCert" => $fechaCert, //para fecha cert
                        "fechaAntiguo" => $fechaAntiguo,
                        "hojaAntiguo" => $hojaAntiguo,
                        "pesos" => $antiguo->calculaPesos,
                        "largo" => $this->devuelveDatoParseado($duplicado->Vehiculo->largo),
                        "ancho" => $this->devuelveDatoParseado($duplicado->Vehiculo->ancho),
                        "altura" => $this->devuelveDatoParseado($duplicado->Vehiculo->altura),
                        "qrCode" => $qrCode,
                    ];
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('duplicadoInicialGLP', $data);
                    //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                    return  $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicado-inicial-glp.pdf');
                }
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    //vista y descarga de DUPLICADOS EXTERNOS ANUALES GNV
    public function generaDuplicadoExternoAnualGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $dupli = Duplicado::find($duplicado->idDuplicado);
            if ($dupli->servicio == 4) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $fechaCert = $duplicado->created_at;
                $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                $hoja = $duplicado->Hoja;
                // Genera el código QR
                $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnualDupliExtGlp', $id, false); // cambiar la ruta para QR
                $qrCode = QrCode::size(70)->generate($urlDelDocumento);
                $equipos = $duplicado->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
                $cargaUtil = $this->calculaCargaUtil($duplicado->Vehiculo->pesoBruto, $duplicado->Vehiculo->pesoNeto);

                $data = [
                    "fecha" => $fecha,
                    "cargaUtil" => $cargaUtil,
                    "empresa" => "MOTORGAS COMPANY S.A.",
                    "carro" => $duplicado->Vehiculo,
                    "taller" => $duplicado->Duplicado,
                    "tallerauto" => $duplicado->TallerAuto,
                    "hoja" => $hoja,
                    "fechaCert" => $fechaCert,
                    "fechaAntiguo" => Carbon::parse($dupli->fecha),
                    "equipos" => $equipos,
                    "largo" => $this->devuelveDatoParseado($duplicado->Vehiculo->largo),
                    "ancho" => $this->devuelveDatoParseado($duplicado->Vehiculo->ancho),
                    "altura" => $this->devuelveDatoParseado($duplicado->Vehiculo->altura),
                    "qrCode" => $qrCode,
                ];
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('duplicadoExternoAnualGlp', $data);
                return $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicadoEx-anual-glp.pdf');
            }
            return abort(404);
        } else {
            return abort(404);
        }
    }
    //vista y descarga de DUPLICADOS EXTERNOS INICIALES GNV
    public function generaDuplicadoExternoInicialGlp($id)
    {
        if (Certificacion::findOrFail($id)) {
            $duplicado = Certificacion::find($id);
            $dupli = Duplicado::find($duplicado->idDuplicado);
            if ($dupli->servicio == 3) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $fechaCert = $duplicado->created_at;
                $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
                $equipos = $duplicado->vehiculo->Equipos->where("idTipoEquipo", "!=", 3)->sortBy("idTipoEquipo");                
                $cargaUtil = $this->calculaCargaUtil($duplicado->Vehiculo->pesoBruto, $duplicado->Vehiculo->pesoNeto);
                //dd($equipos);
                $hoja = $duplicado->Hoja;
                // Genera el código QR
                $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfInicialDupliExtGlp', $id, false);
                $qrCode = QrCode::size(70)->generate($urlDelDocumento);

                $data = [
                    "fecha" => $fecha,
                    "cargaUtil" => $cargaUtil,
                    "empresa" => "MOTORGAS COMPANY S.A.",
                    "carro" => $duplicado->Vehiculo,
                    "taller" => $duplicado->Duplicado,
                    "tallerauto" => $duplicado->TallerAuto,
                    "hoja" => $hoja,
                    "fechaCert" => $fechaCert,
                    "fechaAntiguo" => Carbon::parse($dupli->fecha),
                    "equipos" => $equipos,
                    "largo" => $this->devuelveDatoParseado($duplicado->Vehiculo->largo),
                    "ancho" => $this->devuelveDatoParseado($duplicado->Vehiculo->ancho),
                    "altura" => $this->devuelveDatoParseado($duplicado->Vehiculo->altura),
                    "pesos" => $duplicado->calculaPesos,
                    "qrCode" => $qrCode,
                ];
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('duplicadoExternoInicialGlp', $data);
                //return $pdf->stream($id.'-'.date('d-m-Y').'-cargo.pdf');
                return  $pdf->stream($duplicado->Vehiculo->placa . '-' . $hoja->numSerie . '-duplicadoEx-inicial-glp.pdf');
            }
            return abort(404);
        } else {
            return abort(404);
        }
    }




}
