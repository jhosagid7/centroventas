<a href="{{ route('articulo.edit', $id) }}"><button class='btn btn-info btn-sm'><span class='glyphicon glyphicon-edit'></span></button></a>

<a href="" id="delete-articulo" data-id='{{$id}}' data-target="#modal-articulo-{{$id}}" data-toggle="modal"><button class='btn btn-danger btn-sm delete-articulo'><span class='glyphicon glyphicon-trash'></span></button></a>