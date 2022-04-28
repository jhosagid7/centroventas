

    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="page-header">
                <form action="{{ route('servicios.index')}}" method="GET" autocomplete="off" class="form-inline pull-right" role="buscar">
                    @csrf


                    <div class="input-group">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        <input name="fecha" type="text" class="form-control pull-right" id="daterange-btn">
                        <input name="fecha2" type="text" class="form-control pull-right hidden" id="fecha2" placeholder="fecha2">
                        <input name="fechaInicio" type="text" class="form-control pull-right hidden" id="fechaInicio" value="{{ $fechaInicio }}" placeholder="fechaInicio">
                        <input name="fechaFin" type="text" class="form-control pull-right hidden" id="fechaFin" value="{{ $fechaFin }}" placeholder="fechaFin">
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="categoria" id="categoria">
                                <option value="0">Seleccione categoria</option>
                                @foreach ($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="tipo" id="tipo">
                                <option value="0">Seleccione servicio a pagar</option>
                                @foreach ($tipos as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <input type="text" class='form-control' id="nombre" name="nombre" placeholder="Nombre..." value="{{ old('Razon social') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <input type="text" class='form-control' id="num_documento" name="num_documento" placeholder="Rif/CI..." value="{{ old('num_documento') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class='glyphicon glyphicon-search'></i> Buscar</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



