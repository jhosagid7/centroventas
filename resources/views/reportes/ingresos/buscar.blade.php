

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <form action="{{ route('reporte-compras')}}" method="GET" autocomplete="off" class="form-inline pull-right" role="buscar">
                    @csrf
                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> --}}
                        <div class="checkbox">
                            <label>
                              <input checked name="detallado" type="checkbox">
                              Reporte Detallado&nbsp;&nbsp;&nbsp;
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="input-group">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                <input name="fecha" type="text" class="form-control pull-right" id="daterange-btn">
                                <input name="fecha2" type="text" class="form-control pull-right hidden" id="fecha2" placeholder="fecha2">
                                <input name="fechaInicio" type="text" class="form-control pull-right hidden" id="fechaInicio" value="{{ $fechaInicio ?? '' }}" placeholder="fechaInicio">
                        <input name="fechaFin" type="text" class="form-control pull-right hidden" id="fechaFin" value="{{ $fechaFin ?? ''}}" placeholder="fechaFin">
                            </div>
                        </div>
                    {{-- </div> --}}
                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> --}}
                        <div class="form-group">
                            <div class="input-group">
                                <select name="estado" id="estado" class="form-control selectpicker"  data-live-search="true">
                                    <option value="0">Operación</option>
                                    <option value="Aceptado">Compra</option>
                                    <option value="Cancelado">Devolución</option>
                                </select>
                            </div>
                        </div>
                    {{-- </div> --}}
                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> --}}
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="proveedor" id="proveedor" class="form-control selectpicker" data-live-search="true">
                                        <option value="0">Seleccione Proveedor</option>
                                        @foreach ($proveedors as $persona)
                                    <option value="{{$persona->id}}">{{$persona->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    {{-- </div> --}}
                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> --}}
                        <div class="form-group">
                            <div class="input-group">
                                <select name="operador" id="operador" class="form-control selectpicker" data-live-search="true">
                                    <option value="0">Seleccione Operador</option>
                                    @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit"><i class='glyphicon glyphicon-search'></i> Buscar</button>
                                </span>
                            </div>
                        </div>
                    {{-- </div> --}}
                </form>

        </div>
    </div>



