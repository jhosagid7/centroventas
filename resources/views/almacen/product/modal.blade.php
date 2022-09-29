<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$art->id}}">

    <form action="{{ route('articulo.destroy', $art->id)}}" method="POST">
        @csrf
        @method('DELETE')


     <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidder="true">X</span>
                    </button>
                    <h4 class="modal-title">Eliminar Artículo <b>{{$art->nombre}}</b></h4>
                </div>
                <div class="modal-body">
                    <p>Confirme si decea Eliminar el artículo <b>{{$art->nombre}}</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
</div>
