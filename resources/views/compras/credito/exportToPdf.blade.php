
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> --}}
<link rel="stylesheet" href="{{asset('dist/css/style.css')}}">

  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Example 1</title>
      <link rel="stylesheet" href="style.css" media="all" />
    </head>
    <body>
      <header class="clearfix">
        <div id="logo">
            <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <h1>INVOICE 3-2-1</h1>
        <div id="company" class="clearfix">
          <div>Company Name</div>
          <div>455 Foggy Heights,<br /> AZ 85004, US</div>
          <div>(602) 519-0450</div>
          <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>
        <div id="project">
          <div><span>PROJECT</span> Website development</div>
          <div><span>CLIENT</span> John Doe</div>
          <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
          <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
          <div><span>DATE</span> August 17, 2015</div>
          <div><span>DUE DATE</span> September 17, 2015</div>
        </div>
      </header>
      <main>

            <table id="ingre" class="table table-striped table-bordered table-condensed table-hover">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Total</th>
                    <th>Estado</th>

                </tr>
                <tbody>
                    @foreach ($ingresos as $ing)
                    <tr>
                        <td>{{ $ing->id }}</td>
                        <td>{{ $ing->fecha_hora }}</td>
                        <td>{{ $ing->nombre }}</td>
                        <td>{{ $ing->tipo_comprobante . ': ' . $ing->serie_comprobante . '-' . $ing->num_comprobante }}</td>
                        <td>{{ $ing->total }}</td>
                        <td>{{ $ing->estado }}</td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
        </main>
        <footer>
          Invoice was created on a computer and is valid without the signature and seal.
        </footer>
      </body>
    </html>

