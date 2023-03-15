<?php

namespace App\Http\Controllers;

use Exception;
use App\Articulo;
use App\Sucursal;

use App\Sessioncaja;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class PrinterController extends Controller
{

    public $print_error = 0;
    public $print_name;
    protected $machine_user;
    protected $machine_pass;
    protected $machine_name;
    protected $network;
    protected $print_route;

    public function ticketConsumo($tipoOperasion, $articulo_id, $serie_comprobante, $precio_venta_unidad, $cantidad, $modo_pago, $tipo_pago, $total_venta, $operador){

        // return $requestPrint;
        // $print_name = "EPSON TM-T88V Receipt";
        // $this->print_name = "EPSONTMT88VReceipt";
        $this->print_name = "AnyDesk-Printer4";
        // $this->print_name = "BIXOLON-SRP-350plus";
        $this->machine_user = "Administrador";
        $this->machine_pass = "pass";
        $this->machine_name = "INTEL";
        $this->network = true;

        try {
        //impresoras en red
        //ejemplo base
        // $connector = new WindowsPrintConnector("smb://maquina/print_name");
        // cuando tiene pass
        //$connector = new WindowsPrintConnector("smb://user:pass@nombre_pc/print_name");
        // $connector = new WindowsPrintConnector( "smb://jhosagid:1avacamar1posa@DESKTOP-MI1CBPC/" . $this->print_name );
        if($this->network){
            $this->print_route = "smb://$this->machine_user:$this->machine_pass@$this->machine_name/$this->print_name";
        }else{
            $this->print_route = $this->print_name;
        }

        $connector = new WindowsPrintConnector( $this->print_route );


        // $connector = new WindowsPrintConnector($print_name);
        $printer = new Printer($connector);

        echo 1;

        $printer->setJustification(Printer::JUSTIFY_CENTER);


        try{
            $logo = EscposImage::load("geek.png", false);
            $printer->bitImage($logo);
        }catch(\Exception $e){/*No hacemos nada si hay error*/}

        $datos = Sucursal::query()
        ->with('Empresa')->where('id', 1)->first();
        $fonts = array(Printer::FONT_A, Printer::FONT_B, Printer::FONT_C);
        $printer -> setLineSpacing(50);
        $printer->setFont(1);
        $printer->setEmphasis(true);
        $printer->text("RIF: " . $datos->rif . "\n");
        $printer->setEmphasis(false);
        $printer->text($datos->nombre . "\n");
        $printer->text($datos->direccion . "\n");
        // $printer->feed();


        $printer->setJustification(Printer::JUSTIFY_LEFT);

        $printer->feed();
        $printer->text($operador . "\n");
        $printer->text("Modo: ".$modo_pago ." Tipo: ".$tipo_pago. "\n");
        $printer->text("CodVend: ".$datos->cod_venta ."\n");
        $printer->text("Referencia: ".$datos->referencia ."\n");


        date_default_timezone_set("America/Caracas");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("NOTA DE ENTREGA \n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Nº     :                                      ".$serie_comprobante."\n");
        $printer->text("FECHA: ".date("Y-m-d") . "                      HORA: ".date("h:i:s A")."\n");
        $printer->text("--------------------------------------------------------" . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text("UD      DESCRIPCION                            Precio   " . "\n");
        $printer->setEmphasis(false);
        $printer->text("--------------------------------------------------------" . "\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        //creamos un contador
            $cont = 0;
            $nombre = '';

        //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
        while ($cont < count($articulo_id)) {

            $articulo = Articulo::findOrFail($articulo_id[$cont]);
            $nombre = $cantidad[$cont]." ".$articulo->nombre;
            // dd($articulo->nombre);
            $data = $this->numCodigo($nombre ," $.".number_format($cantidad[$cont] * $precio_venta_unidad[$cont],2));
            // $printer->text(" $.".number_format($cantidad[$cont] * $precio_venta_unidad[$cont],2)." \n");
            $printer->text($data." \n");
            // $this->numCodigo();
            $cont = $cont+1;
        }

        $printer->text("--------------------------------------------------------"."\n");
        $printer->setJustification();

        $printer->setEmphasis(true);
        $printer->setPrintLeftMargin(0);

        $h = $printer->setPrintLeftMargin(350);
        $printer->text("SUBTOTAL: $.".number_format($total_venta,2)."\n");

        $printer->text("TOTAL:    $.".number_format($total_venta,2)."\n");
        $printer->setEmphasis(true);

        $printer->setJustification();
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Gracias por su compra \n");



        $printer->feed(3);


        $printer->cut();


        $printer->pulse();






        $printer->close();

        $this->print_error = 1;
    } catch (\Exception $e) {
        $this->print_error = 0;
    }

}


//este metodo nos permite dar formato al numero de la factura
public function numCodigo($nombre, $id_cod) {
    if (empty($id_cod)) {
        throw new Exception('!La funcion numCodigo esperaba 3 parametros y uno no fue dado...');
        exit;
    } else {
        $longitud       = strlen($id_cod);
        $resta          = '-' . $longitud;
        $resul_num      = substr_replace('.......................................................', $id_cod, $resta);
        $num_Codigo     = strtoupper($resul_num);
        $nombre =  substr($nombre, 0, 42);
        $num_Codigo     = $this->numCodigoLeft($num_Codigo, $nombre);

        // $num_Codigo     = strtoupper($sucursal . '-' . $op . $resul_num);
        return $num_Codigo;
    }
}

public function numCodigoLeft($string, $nombre) {
    if (empty($string) || empty($nombre)) {
        throw new Exception('!La funcion numCodigo esperaba 3 parametros y uno no fue dado...');
        exit;
    } else {
        $longitud       = strlen($nombre);
        $resta          = '-' . $longitud;
        $resul_num      = substr_replace($string, $nombre, 0,$longitud);
        $num_Codigo     = strtoupper($resul_num);
        // $num_Codigo     = strtoupper($sucursal . '-' . $op . $resul_num);
        return $num_Codigo;
    }
}

}
