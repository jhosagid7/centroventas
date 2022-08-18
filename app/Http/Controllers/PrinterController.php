<?php

namespace App\Http\Controllers;

use App\Articulo;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;

use Mike42\Escpos\EscposImage;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class PrinterController extends Controller
{
    public function ticketConsumo($tipoOperasion, $articulo_id, $serie_comprobante, $precio_venta_unidad, $cantidad, $modo_pago, $tipo_pago, $total_venta, $operador){

        // return $requestPrint;
        $nombre_impresora = "EPSON TM-T88V Receipt";


        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);

        echo 1;

        $printer->setJustification(Printer::JUSTIFY_CENTER);


        try{
            $logo = EscposImage::load("geek.png", false);
            $printer->bitImage($logo);
        }catch(\Exception $e){/*No hacemos nada si hay error*/}


        $printer->text("\n".$tipoOperasion . " N°: ".$serie_comprobante . "\n");
        $printer->text("Modo: ".$modo_pago ." Tipo: ".$tipo_pago. "\n");
        $printer->text($operador . "\n");

        date_default_timezone_set("America/Caracas");
        $printer->text(date("Y-m-d H:i:s") . "\n");
        $printer->text("-----------------------------" . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("CANT DESCRIPCION    P.U   .\n");
        $printer->text("-----------------------------"."\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        //creamos un contador
            $cont = 0;
            $nombre = '';

        //ahora creamos un bucle while para ir recorriendo los arrays que estamo enviando
        while ($cont < count($articulo_id)) {

            $articulo = Articulo::findOrFail($articulo_id[$cont]);
            $nombre = $articulo->nombre;
            // dd($articulo->nombre);
            $printer->text("".$cantidad[$cont]." ".$articulo->descripcion." $.".number_format($cantidad[$cont] * $precio_venta_unidad[$cont],2)." \n");

            $cont = $cont+1;
        }

        $printer->text("-----------------------------"."\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("SUBTOTAL: $.".number_format($total_venta,2)."\n");

        $printer->text("TOTAL: $.".number_format($total_venta,2)."\n");



        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Gracias por su compra \n");




        $printer->feed(3);


        $printer->cut();


        $printer->pulse();


        $printer->close();

    }
}
