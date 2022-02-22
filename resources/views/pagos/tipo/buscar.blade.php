

    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="page-header">
                <form action="{{ route('articulo.index')}}" method="GET" autocomplete="off" class="form-inline pull-right" role="buscar">
                    {{-- @csrf --}}


                    <div class="input-group">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        <input name="fecha" type="text" class="form-control pull-right" id="daterange-btn">
                        <input name="fecha2" type="text" class="form-control pull-right hidden" id="fecha2" placeholder="fecha2">
                        <input name="fechaInicio" type="text" class="form-control pull-right hidden" id="fechaInicio" value="{{ $fechaInicio }}" placeholder="fechaInicio">
                        <input name="fechaFin" type="text" class="form-control pull-right hidden" id="fechaFin" value="{{ $fechaFin }}" placeholder="fechaFin">
                        {{-- <input name="fecha" type="text" class="form-control pull-right" id="fecha3"> --}}
                        {{-- <input name="fecha2" type="text" class="form-control pull-right" id="reportrange"> --}}
                        {{-- <button type="button" id="saveBtn" class="btn btn-primary" data-dismiss="modal">Save changes</button> --}}
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="venderal" id="venderal">
                                <option value="0" {{ $venderal == "0" ? 'selected' : '' }}>Seleccione</option>
                                <option value="Mayor" {{ $venderal == "Mayor" ? 'selected' : '' }}>Al Mayor</option>
                                <option value="Detal" {{ $venderal == "Detal" ? 'selected' : '' }}>Al Detal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="categorias_id" id="categorias_id">
                                <option value="0" {{ $oldCat == "0" ? 'selected' : '' }}>Seleccione</option>
                                @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ $oldCat == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-barcode"></i>
                            </div>
                            <input type="text" class='form-control' id="codigo" name="codigo" placeholder="codigo..." value="{{ $codigo ?? '' }}">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <input type="text" class='form-control' id="name" name="name" placeholder="Nombre..." value="{{ $name ?? '' }}">
                            <span class="input-group-btn">
                                <button id="saveBtn" class="btn btn-primary" type="submit"><i class='glyphicon glyphicon-search'></i> Buscar</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



