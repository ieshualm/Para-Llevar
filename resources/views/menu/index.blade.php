@extends('layouts.app')

@section('title','Menus')

@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

@include('layouts.partials.alert')

<div class="container-fluid px-4">
<h1 class="mt-1 text-center">Menú</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Menú</li>
    </ol>
</div>

<div class="container-fluid px-4">
    <div class="row gy-4">

        @foreach ($productos as $cosa)
        <div class="col-xl-7">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="row">
                            <!--PLATILLOS-->
                            <div class="col-12 col-sm-7">
                                <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" data-size="1" title="Busque un producto aquí">
                                    @foreach ($productos as $item)
                                    <option value="{{$item->id}}-{{$item->stock}}-{{$item->precio_venta}}">{{$item->codigo.' '.$item->nombre}}</option>
                                    @endforeach
                                </select>
                                <label for="stock" class="col-form-label col-4">{{$cosa->codigo.' '.$cosa->nombre}}</label>
                            </div>
                            <!-----Stock--->
                            <div class="col-12 col-sm-4 justify-content-end">
                                <div class="row">
                                    <label for="stock" class="col-form-label col-4">Stock:</label>
                                    <div class="col-8">
                                        <input disabled id="stock" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-----Precio de venta---->
                            <div class="col-sm-4">
                                <label for="precio_venta" class="form-label">Precio de venta:</label>
                                <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                            </div>

                            <!-----Cantidad---->
                            <div class="col-sm-4">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>

                            <!----Descuento---->
                            <div class="col-sm-4">
                                <label for="descuento" class="form-label">Descuento:</label>
                                <input type="number" name="descuento" id="descuento" class="form-control">
                            </div>
                            <!----Boton Agregar---->
                            <div class="col-12 text-end">
                                <button id="btn_agregar" class="btn btn-success" type="button">Agregar</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <!--DATOS VENTA-->
        <div class="col-xl-5">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row gy-4">
                        <!--Botones--->
                        <div class="table-responsive">
                            <table id="tabla_detalle" class="table table-hover">
                                <thead class="bg-success">
                                    <tr>                                        
                                        <th class="text-white">Platillo</th>
                                        <th class="text-white">Cantidad</th>
                                        <th class="text-white">Precio</th>
                                        <th class="text-white">Subtotal</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>                                                                                
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th colspan="4">Sumas</th>
                                        <th colspan="2"><span id="sumas">0</span></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th colspan="4">Total</th>
                                        <th colspan="2"> <input type="hidden" name="total" value="0" id="inputTotal"> <span id="total">0</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>                    
                        <!--Cliente-->
                        <div class="col-12">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona" data-size='2'>
                                @foreach ($clientes as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!--Tipo de comprobante-->
                        <div class="col-12">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker" title="Selecciona">
                                @foreach ($comprobantes as $item)
                                <option value="{{$item->id}}">{{$item->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!--Numero de comprobante-->
                        <div class="col-12">
                            <label for="numero_comprobante" class="form-label">Numero de comprobante:</label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                            @error('numero_comprobante')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!--Fecha--->
                        <div class="col-6 ">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
                            <?php

                            use Carbon\Carbon;

                            $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>

                        <!----User--->
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <!--Botones--->                        
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success" id="guardar">Realizar venta</button>
                            <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Cancelar venta
                            </button>                   
                        </div>

                    </div>
                </div>
            
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {

        $('#producto_id').change(mostrarValores);


        $('#btn_agregar').click(function() {
            agregarProducto();
        });

        $('#btnCancelarVenta').click(function() {
            cancelarVenta();
        });

        disableButtons();

        $('#impuesto').val(impuesto + '%');
    });

    //Variables
    let cont = 0;
    let subtotal = [];
    let sumas = 0;
    let igv = 0;
    let total = 0;

    //Constantes
    const impuesto = 16;

    function mostrarValores() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        $('#stock').val(dataProducto[1]);
        $('#precio_venta').val(dataProducto[2]);
    }

    function agregarProducto() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        //Obtener valores de los campos
        let idProducto = dataProducto[0];
        let nameProducto = $('#producto_id option:selected').text();
        let cantidad = $('#cantidad').val();
        let precioVenta = $('#precio_venta').val();
        let descuento = $('#descuento').val();
        let stock = $('#stock').val();

        if (descuento == '') {
            descuento = 0;
        }

        //Validaciones 
        //1.Para que los campos no esten vacíos
        if (idProducto != '' && cantidad != '') {

            //2. Para que los valores ingresados sean los correctos
            if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(descuento) >= 0) {

                //3. Para que la cantidad no supere el stock
                if (parseInt(cantidad) <= parseInt(stock)) {
                    //Calcular valores
                    subtotal[cont] = round(cantidad * precioVenta - descuento);
                    sumas += subtotal[cont];
                    igv = round(sumas / 100 * impuesto);
                    total = round(sumas + igv);

                    //Crear la fila
                    let fila = '<tr id="fila' + cont + '">' +
                        '<th>' + (cont + 1) + '</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + precioVenta + '</td>' +
                        '<td><input type="hidden" name="arraydescuento[]" value="' + descuento + '">' + descuento + '</td>' +
                        '<td>' + subtotal[cont] + '</td>' +
                        '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(' + cont + ')"><i class="fa-solid fa-trash"></i></button></td>' +
                        '</tr>';

                    //Acciones después de añadir la fila
                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont++;
                    disableButtons();

                    //Mostrar los campos calculados
                    $('#sumas').html(sumas);
                    $('#igv').html(igv);
                    $('#total').html(total);
                    $('#impuesto').val(igv);
                    $('#inputTotal').val(total);
                } else {
                    showModal('Cantidad incorrecta');
                }

            } else {
                showModal('Valores incorrectos');
            }

        } else {
            showModal('Le faltan campos por llenar');
        }

    }

    function eliminarProducto(indice) {
        //Calcular valores
        sumas -= round(subtotal[indice]);
        igv = round(sumas / 100 * impuesto);
        total = round(sumas + igv);

        //Mostrar los campos calculados
        $('#sumas').html(sumas);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#impuesto').val(igv);
        $('#InputTotal').val(total);

        //Eliminar el fila de la tabla
        $('#fila' + indice).remove();

        disableButtons();
    }

    function cancelarVenta() {
        //Elimar el tbody de la tabla
        $('#tabla_detalle tbody').empty();

        //Añadir una nueva fila a la tabla
        let fila = '<tr>' +
            '<th></th>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '</tr>';
        $('#tabla_detalle').append(fila);

        //Reiniciar valores de las variables
        cont = 0;
        subtotal = [];
        sumas = 0;
        igv = 0;
        total = 0;

        //Mostrar los campos calculados
        $('#sumas').html(sumas);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#impuesto').val(impuesto + '%');
        $('#inputTotal').val(total);

        limpiarCampos();
        disableButtons();
    }

    function disableButtons() {
        if (total == 0) {
            $('#guardar').hide();
            $('#cancelar').hide();
        } else {
            $('#guardar').show();
            $('#cancelar').show();
        }
    }

    function limpiarCampos() {
        let select = $('#producto_id');
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_venta').val('');
        $('#descuento').val('');
        $('#stock').val('');
    }

    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: icon,
            title: message
        })
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0) //con 0 decimales
            return signo * Math.round(num);
        // round(x * 10 ^ decimales)
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        // x * 10 ^ (-decimales)
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
    //Fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario
</script>
@endpush