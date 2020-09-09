@extends('layouts.app')

@section('content')
<div class="wrapper ">
    @include('layouts.partials.side-bar')
    <div class="main-panel">
        <!-- nav bar include -->
        @include('layouts.partials.nav')

         <div class="content">
                    <div class="row">
                        <div class="col-md-12 pr-1 pl-1">
                            <div class="bg-white card card-user">
                                <div class="card-header d-flex">
                                    <h5 class="card-title">FACTURA PROFORMA</h5>
                                    <a class="btn btn-warning ml-auto" onclick="descargarFactura();">Descargar factura</a>
                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>N° Factura Proforma</label>
                                                    <input type="text" class="form-control" disabled value={{$factura->id}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Fecha factura proforma</label>
                                                    <input type="text" class="form-control" disabled  value="{{$factura->fecha_reg->formatLocalized('%d/%m/%Y - %H:%M')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                        <h6>DATOS DEL Cliente</h6>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" disabled  value="{{$factura->cliente->nombre}} {{$factura->cliente->nombre}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cuit/Cuil</label>
                                                <input type="text" class="form-control" disabled  value="{{$factura->cliente->cuit}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <input type="text" class="form-control" disabled  value="{{$factura->cliente->direccion}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Localidad</label>
                                                <input type="text" class="form-control" disabled  value="{{$factura->cliente->ciudad}}, {{$factura->cliente->provincia}} - (C.P: {{$factura->cliente->codigo_postal}})">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Teléfono</label>
                                                <input type="text" class="form-control" disabled  value="{{$factura->cliente->telefono1}} / / {{$factura->cliente->telefono2}}">
                                            </div>
                                        </div>

                        <h6>DATOS DEL PEDIDO</h6>
                                        <br>
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Condición del pago</label>
                                                    <input type="text" class="form-control" disabled value="{{$factura->pedido->condicion_pago}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Forma de entrega</label>
                                                    <input type="text" class="form-control" disabled  value="{{$factura->pedido->forma_entrega}}">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Datos de transporte</label>
                                                    <input type="text" class="form-control" disabled  value="{{$factura->pedido->datos_flete}}">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pr-1 pl-1">
                            <div class="bg-white card card-user">
                                <div class="card-header">
                                    <h5 class="card-title">Productos pedidos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="tablaFactura">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Lote</th>
                                                    <th>Unidades</th>
                                                    <th>Kg</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Descuento</th>
                                                    <th>Unidad con descuento</th>
                                                    <th>Monto Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($factura->productos as $productoFactura)
                                                <tr>
                                                    <!--PRODUCTO-->
                                                    <td>
                                                        {{$productoFactura->producto->nombre_comercial}}
                                                    </td>
                                                    <!--LOTE-->
                                                    <td>
                                                        @if(isset($productoFactura->lote_produccion))
                                                            <b>P-</b>{{$productoFactura->lote_produccion}}
                                                        @elseif(isset($productoFactura->lote_compra))
                                                            <b>C-</b>{{$productoFactura->lote_compra}}
                                                        @endif
                                                    </td>
                                                    <!--UNIDADES-->
                                                    <td>
                                                        {{round($productoFactura->cantidad_unidades,0)}}
                                                    </td>
                                                    <!--KG-->
                                                    <td>
                                                        {{$productoFactura->cantidad_kg}}
                                                    </td>
                                                    <!--PRECIO UNITARIO-->
                                                    <td>
                                                        $ {{$productoFactura->precio_unitario}}
                                                    </td>
                                                    <!--DESCUENTO-->
                                                    <td>
                                                        {{$productoFactura->descuento *100}} % 
                                                    </td>
                                                    
                                                    <td>
                                                        ${{$productoFactura->precio_unitario*(1-$productoFactura->descuento)}}
                                                    </td>

                                                    <!--MONTO TOTAL-->
                                                    <td>
                                                        $ {{$productoFactura->precio_total}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
</div>


    <script src="{{asset('dashboard/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <script type="text/javascript" src="{{asset('dashboard/assets/js/plugins/jspdf.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('dashboard/assets/js/plugins/jspdf.plugin.autotable')}}"></script>

 <script>

     function descargarFactura(){

    var logo='data:image/jpeg;base64,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'

    var nrofactura={{$factura->id}};

    var factura= new jsPDF({orientation: 'p',
                                        unit: 'cm',
                                        format: 'a4'});

        factura.addImage(logo,'JPEG',0.9,1.5,4.4795,0.986);

        factura.setTextColor('#436784').setFont('Century Gothic').setFontStyle('bold').setFontSize(30).text(9.49,1.49,'Documento - REMITO');
        factura.setTextColor('#436784').setFont('Century Gothic').setFontStyle('bold').setFontSize(13).text(15.84,2.18,'Pro Forma - Factura');

        factura.setLineWidth(0.1);
        factura.setDrawColor(26,40,52);
    	factura.line(0.53, 2.9, 20.5, 2.9);

        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(12).text(0.53,3.55,'AMERICASTIME S.A.');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('normal').setFontSize(9).text(0.53,4.05,'CUIT : 30-71085781-0');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('normal').setFontSize(9).text(0.53,4.55,'Establecimiento El Ombu - Brasil S/N - 6555 Daireaux');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('normal').setFontSize(9).text(0.53,5.05,'Provincia de Buenos Aires - ARGENTINA');

        factura.setTextColor('#00000').setFont('Monserrat').setFontStyle('bold').setFontSize(12).text(8.85,3.85,'Plataforma de pedidos');
        factura.setTextColor('#00a3d6').setFont('Century Gothic').setFontStyle('normal').setFontSize(14).text(8.8,4.50,'pedidos.purares.com');

        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(15.5,3.80,'Fecha Pedido:');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(14.71,4.25,'N.º del Documento:');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(15.5,4.75,'Id. del cliente:');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(17.8,3.8,"{{$factura->fecha_reg->formatLocalized('%d/%m/%Y %H:%M')}}");
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(17.8,4.25,''+nrofactura);
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(17.8,4.75,"{{$factura->cliente->id}}");

        factura.setLineWidth(0.1);
        factura.setDrawColor(26,40,52);
    	factura.line(0.53, 5.4, 20.5, 5.4);

        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(1.5,6,'Para:');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(1.5,6.5,'CUIT/CUIL:');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(1.5,7,'Dirección:');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(1.5,7.5,'Localidad:');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(1.5,8,'Teléfono:');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(4,6,"{{$factura->cliente->nombre}} {{$factura->cliente->apellidos}}");
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(4,6.5,"{{$factura->cliente->cuit}}");
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(4,7,"{{$factura->cliente->direccion}}");
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(4,7.5,"{{$factura->cliente->ciudad}}, {{$factura->cliente->provincia}} - (C.P: {{$factura->cliente->codigo_postal}})");
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(4,8,"{{$factura->cliente->telefono1}} / / {{$factura->cliente->telefono2}}");

        var facturaParaImprimir=$("#tablaFactura").clone();

        var contadorproductos=facturaParaImprimir.find('tr');

        if(contadorproductos.length-1<20){

        for (var i = contadorproductos.length-1; i < 20; i++) {
               facturaParaImprimir.append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>')

           }
            facturaParaImprimir.append('<tr><td colspan=6>TOTAL IMPONIBLE</td><td></td></tr><tr><td colspan=6>TOTAL</td><td></td></tr>')
           }
           else{
            return alert('Hay demasiados productos para generar la factura')
           }

        var facturaJson=factura.autoTableHtmlToJson(facturaParaImprimir.get(0))

        factura.autoTable(facturaJson.columns, facturaJson.data,{startY:8.5, margin: {top: 1, right: 0.8, bottom: 6, left: 1},headStyles :{fontSize:10,cellPadding:0.1,halign:'center',valign:'middle',fillColor:[26,40,52]},bodyStyles:{fontSize:10,cellPadding:0.1,halign:'center',valign:'middle',lineWidth:0.01,lineColor:0}});

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(0.53,23.07,'Documento válido para el tránsito de la mercadería declarada en el documento.');
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(0.53,23.57,'Los pagos con cheques serán aceptados si los mismos están extendidos a la orden');
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(0.53,24.07,'de Americastime S.A. y/o si son endosados por el cliente.');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(12.53,23.07,'Los Precios son Imponibles, el IVA (21%) debe');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(12.53,23.57,'considerarse al momento de la Facturación del/los');
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('normal').setFontSize(10).text(12.53,24.07,'Producto/s  - Pedido/s');


        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('bold').setFontSize(16).text(0.53,25.00,'Plataforma de pedidos: pedidos.purares.com');

        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(12).text(2.53,26,'Fecha :   __________/__________/__________');
        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(12).text(12,26,'Aceptación :');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('bold').setFontSize(12).text(2.53,27.5,'Firma del Transporte: _________________');
        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('bold').setFontSize(12).text(12,27.5,'Firma del Cliente: _________________');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('bold').setFontSize(8).text(1,28.3,'La suscripción del presente o el transcurso de 24 horas de recibida la mercadería, el que resultare primero, se considerará para la aceptación de conformidad');

        factura.setTextColor('#000000').setFont('Monserrat').setFontStyle('bold').setFontSize(8).text(1,28.6,'de los productos recibidos.');

        factura.setTextColor('#436784').setFont('Monserrat').setFontStyle('bold').setFontSize(10).text(1.77,29.20,'Pagina Web : www.purares.com.ar - Facebook/purares  - Instagram/purares.natural - Mail: admin@purares.com.ar');

        var nombrefactura="Factura Proforma N° "+nrofactura+" PURARES Clientes";

         factura.setProperties({
            title: nombrefactura
        });
         factura.save(nombrefactura)

     }

 </script>

 <!-- include footer -->
        @include('layouts.partials.footer')
    </div>
</div>
@endsection




