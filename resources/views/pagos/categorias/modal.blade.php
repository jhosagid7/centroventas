<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$cat->id}}">
    {{-- {{ Form::open(array('action'=>array('CategoriaController@destroy',$cat->idcategoria),'method'=>'delete'))}} --}}
    <form action="{{ route('categorias.destroy', $cat->id)}}" method="POST">
    @csrf
    @method('DELETE')
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidder="true">X</span>
                    </button>
                    <h4 class="modal-title">Eliminar Categoría</h4>
                </div>
                <div class="modal-body">
                    <p>Confirme si decea eliminar la categoría <b>{{$cat->nombre}}</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn default btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
    {{-- {{ Form::Close()}} --}}
</div>
