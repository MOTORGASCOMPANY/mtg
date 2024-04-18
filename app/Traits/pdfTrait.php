<?php

namespace App\Traits;

use App\Models\Archivo;
use App\Models\Certificacion;
use App\Models\ContratoTrabajo;
use App\Models\DocumentoMemorando;
use App\Models\Duplicado;
use App\Models\Expediente;
use App\Models\Imagen;
use App\Models\Memorando;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode; //te falto esto

trait pdfTrait
{

    public function guardarFichaTecnica(Certificacion $certi, Expediente $expe)
    {
        $data = $this->datosParaFichaTecnica($certi);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fichaTecnicaGnv', $data);
        $archivo = $pdf->download('FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '.pdf')->getOriginalContent();
        //$nombre = $expe->placa . '-doc' . (rand()) . '-' . $expe->certificado;
        Storage::put('public/expedientes/' . 'FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '.pdf', $archivo);
        Imagen::create([
            'nombre' => 'FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie,
            'ruta' => 'public/expedientes/' . 'FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function guardarFichaTecnicaGlp(Certificacion $certi, Expediente $expe)
    {
        $certificacion = $certi;
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
            "tallerauto" => $certificacion->TallerAuto, //Para taller autorizado
            "servicio" => $certificacion->Servicio,
            "cargaUtil" => $cargaUtil,
            "hoja" => $hoja,
            "numHoja" => $this->completarConCeros($hoja->numSerie),
            "equipos" => $equipos,
        ];
        //$data = $this->datosParaFichaTecnica($certi);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fichaTecnicaGlp', $data);
        $archivo = $pdf->download('FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '-glp.pdf')->getOriginalContent();
        //$nombre = $expe->placa . '-doc' . (rand()) . '-' . $expe->certificado;
        Storage::put('public/expedientes/' . 'FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '-glp.pdf', $archivo);
        Imagen::create([
            'nombre' => 'FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie,
            'ruta' => 'public/expedientes/' . 'FT-' . $data['carro']->placa . '-' . $data['hoja']->numSerie . '-glp.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function datosParaFichaTecnica(Certificacion $certificacion)
    {
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
            "tallerauto" => $certificacion->TallerAuto, //Para taller autorizado
            "servicio" => $certificacion->Servicio,
            "hoja" => $hoja,
            "equipos" => $equipos,
            "chip" => $chip,
        ];

        return $data;
    }

    public function guardaCertificado(Certificacion $certi, Expediente $expe)
    {
        switch ($certi->Servicio->tipoServicio->id) {
            case 1: //tipo servicio = inicial gnv
                $this->guardarPdfInicialGnv($certi, $expe);
                break;
            case 2: //tipo servicio = anual gnv
                $this->guardarPdfAnualGnv($certi, $expe);
                break;
            case 3: //tipo servicio = inicial glp
                $this->guardarPdfInicialGlp($certi, $expe);
                break;
            case 4: //tipo servicio = anual glp
                $this->guardarPdfAnualGlp($certi, $expe);
                break;
            case 5: //tipo servicio = modificacion
                $this->guardarPdfModificacion($certi, $expe);
                break;

            case 8: //tipo servicio = duplicado gnv

                break;

            default:

                break;
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

    public function guardarPdfAnualGnv(Certificacion $certificacion, Expediente $expe)
    {

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = $certificacion->created_at;
        $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
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
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('anualGnv', $data);
        $archivo =  $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual.pdf')->getOriginalContent();
        Storage::put('public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual.pdf', $archivo);
        Imagen::create([
            'nombre' => $certificacion->Vehiculo->placa . '-' . $hoja->numSerie,
            'ruta' => 'public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function guardaMemorando(Memorando $memorando)
    {
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
        //$archivo =  $pdf->output();
        $archivo =  $pdf->download($memorando->id . '-memorando.pdf')->getOriginalContent();
        // Guarda el archivo en la tabla DocumentoMemorando
        /*DocumentoMemorando::create([
            'nombre' => $memorando->id . '-memorando.pdf',
            'ruta' => 'public/memorandos/' . $memorando->id . '-memorando.pdf',
            'extension' => 'pdf',
            'estado' => 1,
            'idDocReferenciado' => $memorando->id,
        ]);*/
        Storage::put('public/memorandos/' . $memorando->id . '-memorando.pdf', $archivo);
    }

    public function guardaContrato(ContratoTrabajo $contrato)
    {
        $usuario = User::findOrFail($contrato->idUser);
        $nombreUsuario = $usuario->name;

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = is_string($contrato->fechaInicio) ? new DateTime($contrato->fechaInicio) : $contrato->fechaInicio;
        $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');
        $fechaCert2 = is_string($contrato->fechaExpiracion) ? new DateTime($contrato->fechaExpiracion) : $contrato->fechaExpiracion;
        $fechaForma2 = $fechaCert2->format('d') . ' de ' . $meses[$fechaCert2->format('m') - 1] . ' del ' . $fechaCert2->format('Y');
        $pagoForma2 = $this->convertirMontoAPalabras($contrato->pago);
        $valorSoles = $contrato->pago % 1000;
        $pagoForma = $contrato->pago . ' - ' . $pagoForma2 . ' con 00/' . $valorSoles . ' soles';

        $data = [
            'nombreEmpleado' => $nombreUsuario,
            'dniEmpleado' => $contrato->dniEmpleado,
            'domicilioEmpleado' => $contrato->domicilioEmpleado,
            'fechaInicio' => $fechaForma,
            'fechaExpiracion' => $fechaForma2,
            'cargo' => $contrato->cargo,
            'pago' => $pagoForma,
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('contrato', $data);
        $archivo =  $pdf->download($contrato->id . '-contrato.pdf')->getOriginalContent();
        Storage::put('public/contratos/' . $contrato->id . '-contrato.pdf', $archivo);
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

    public function guardarPdfModificacion(Certificacion $certificacion, Expediente $expe)
    {

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = $certificacion->created_at;
        $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 4)->first();
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
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('modificacion', $data);
        $archivo =  $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-modificacion.pdf')->getOriginalContent();
        Storage::put('public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-modificacion.pdf', $archivo);
        Imagen::create([
            'nombre' => $certificacion->Vehiculo->placa . '-' . $hoja->numSerie,
            'ruta' => 'public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-modificacion.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function guardarPdfInicialGnv(Certificacion $certificacion, Expediente $expe)
    {
        //para que no te hagas tanto problema para pruebas ponte con tu vista comenta es otro mano y ya
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = $certificacion->created_at;
        $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
        $chip = $certificacion->vehiculo->Equipos->where("idTipoEquipo", 1)->first();
        $equipos = $certificacion->vehiculo->Equipos->where("idTipoEquipo", "!=", 1)->sortBy("idTipoEquipo");
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 1)->first();
        $urlDelDocumento = 'www.motorgasperu.com' . route('verPdfAnual', $certificacion->id, false);
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
        $archivo = $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial.pdf')->getOriginalContent();
        Storage::put('public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial.pdf', $archivo);
        Imagen::create([
            'nombre' => $certificacion->Vehiculo->placa . '-' . $hoja->numSerie,
            'ruta' => 'public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function guardarPdfAnualGlp(Certificacion $certificacion, Expediente $expe)
    {
        $meses = array(
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        $fechaCert = $certificacion->created_at;
        $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
        $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
        $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
        $data = [
            "fecha" => $fecha,
            "cargaUtil" => $cargaUtil,
            "empresa" => "MOTORGAS COMPANY S.A.",
            "carro" => $certificacion->Vehiculo,
            "taller" => $certificacion->Taller,
            "tallerauto" => $certificacion->TallerAuto, //Para taller autorizado
            "hoja" => $hoja,
            "numHoja" => $this->completarConCeros($hoja->numSerie),
            "fechaCert" => $fechaCert,
            "equipos" => $equipos,
            "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
            "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
            "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('anualGlp', $data);
        $archivo =  $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual-glp.pdf')->getOriginalContent();
        Storage::put('public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual-glp.pdf', $archivo);
        Imagen::create([
            'nombre' => $certificacion->Vehiculo->placa . '-' . $hoja->numSerie,
            'ruta' => 'public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-anual-glp.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function guardarPdfInicialGlp(Certificacion $certificacion, Expediente $expe)
    {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = $certificacion->created_at;
        $fecha = $fechaCert->format('d') . ' días del mes de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y') . '.';
        $hoja = $certificacion->Materiales->where('idTipoMaterial', 3)->first();
        $equipos = $certificacion->Vehiculo->Equipos->where("idTipoEquipo", ">", 3)->sortBy("idTipoEquipo");
        $cargaUtil = $this->calculaCargaUtil($certificacion->Vehiculo->pesoBruto, $certificacion->Vehiculo->pesoNeto);
        $data = [
            "fecha" => $fecha,
            "cargaUtil" => $cargaUtil,
            "empresa" => "MOTORGAS COMPANY S.A.",
            "carro" => $certificacion->Vehiculo,
            "taller" => $certificacion->Taller,
            "tallerauto" => $certificacion->TallerAuto, //Para taller autorizado
            "hoja" => $hoja,
            "numHoja" => $this->completarConCeros($hoja->numSerie),
            "fechaCert" => $fechaCert,
            "equipos" => $equipos,
            "largo" => $this->devuelveDatoParseado($certificacion->Vehiculo->largo),
            "ancho" => $this->devuelveDatoParseado($certificacion->Vehiculo->ancho),
            "altura" => $this->devuelveDatoParseado($certificacion->Vehiculo->altura),
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('conversionGlp', $data);
        $archivo = $pdf->download($certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial-glp.pdf')->getOriginalContent();
        Storage::put('public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial-glp.pdf', $archivo);
        Imagen::create([
            'nombre' => $certificacion->Vehiculo->placa . '-' . $hoja->numSerie,
            'ruta' => 'public/expedientes/' . $certificacion->Vehiculo->placa . '-' . $hoja->numSerie . '-inicial-glp.pdf',
            'extension' => 'pdf',
            'Expediente_idExpediente' => $expe->id,
        ]);
    }

    public function calculaCargaUtil($pesoBruto, $pesoNeto)
    {
        if ($pesoBruto && $pesoNeto) {
            $cu = $pesoBruto - $pesoNeto;
            return ($pesoBruto - $pesoNeto);
        }
    }

    function completarConCeros($numero, $longitudDeseada = 7)
    {
        // Convierte el número a una cadena y completa con ceros a la izquierda
        return str_pad((string)$numero, $longitudDeseada, '0', STR_PAD_LEFT);
    }
}
