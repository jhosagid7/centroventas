

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <label id="exampleModalLongTitle" class="modal-title text-primary" for="precio">Agregar Kilos</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="row">
                    {{-- <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form group">
                            <label for="stock">Precio</label>
                            <input type="text"  name="jstock" id="jstock"
                                class="form-control" placeholder="Precio...">
                        </div>
                    </div> --}}


                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="form group hidden">
                            <label class="text-primary" for="precio">Precio por Kilo: &nbsp;&nbsp;</label>
                            <span> <b>$.</b><b id="campoPrecio">0.00</b> </span><input type="hidden" id="precio">
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="form group">
                            <label class="text-primary" for="precio">Existencia: &nbsp;&nbsp;</label><input type="hidden" id="restaKilos">

                            <span><b id="exkilo">100</b><b>.k</b></span><input type="hidden" id="cantidadKilos">
                            <span><b id="exgramos">250</b><b>.g</b></span><input type="hidden" id="stockRealKilos">
                        </div>
                        <div class="form group">
                            <label class="text-primary" for="compra">Compra: &nbsp;&nbsp;</label>
                            <div id="kilosCompletos">
                            <span><b id="ckilo">0</b><b>.</b></span>
                            <span><b id="cgramos">0</b><b>.kg</b></span>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="form group">
                            <label class="text-primary" for="kilo">Kilos: &nbsp;&nbsp;</label>
                            <input type="text" minlength="1" maxlength="7" class="enteros" name="kilo" id="kilo"
                                class="form-control" placeholder="Kilos...">
                        </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="form group">
                            <label class="text-primary" for="gramos">Gramos: &nbsp;&nbsp;</label>
                            <input type="text" class="enteros" minlength="1" maxlength="3" name="gramos" id="gramos"
                                class="form-control" placeholder="Gramos...">
                        </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form group">
                            <label class="text-primary" for="precio">Precio Dolar: &nbsp;&nbsp;</label>
                            <span id="precio"> $. 0.00</span>
                        </div>
                        <div class="form group">
                            <label class="text-primary" for="precio">Precio Peso: &nbsp;&nbsp;</label>
                            <span id="precio"> $. 0.00</span>
                        </div>
                        <div class="form group">
                            <label class="text-primary" for="precio">Precio Trans/Punto: &nbsp;&nbsp;</label>
                            <span id="precio"> $. 0.00</span>
                        </div>
                        <div class="form group">
                            <label class="text-primary" for="precio">Precio Mixto: &nbsp;&nbsp;</label>
                            <span id="precio"> $. 0.00</span>
                        </div>
                        <div class="form group">
                            <label class="text-primary" for="precio">Precio Efectivo: &nbsp;&nbsp;</label>
                            <span id="precio"> $. 0.00</span>
                        </div>


                    </div> --}}

                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="procesaKilo" type="button" class="btn btn-primary">Agregar Kilos</button>
        </div>
      </div>
    </div>
  </div>
