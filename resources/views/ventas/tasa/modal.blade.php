<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$tasa->id}}">
    {{-- {{ Form::open(array('action'=>array('VentaController@destroy',$venta->idventa),'method'=>'delete'))}} --}}

    <form action="{{route('venta.destroy', $tasa->id)}}" method="POST">
        @csrf
        @method('DELETE')<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidder="true">X</span>
                    </button>
                    <h4 class="modal-title">Cancelar Venta.</h4>
                </div>
                <div class="modal-body">
                    <p>Confirme si decea cancelar la venta.</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
    {{-- {{ Form::Close()}} --}}
</div>

