<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$ing->id}}">


    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidder="true">X</span>
                    </button>
                    <h4 class="modal-title">Historial de pagos del ingreso núnero {{$ing->id}}.</h4>
                </div>
                <div class="modal-body">
                    <?php $historial_credito = "App\DetalleCreditoIngreso"::where('ingreso_id',$ing->id)->orderBy('created_at', 'desc')->first();
                                // echo $historial_credito;
                                ?>
                    <p>Confirme si decea cancelar el ingreso.</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>

</div>
