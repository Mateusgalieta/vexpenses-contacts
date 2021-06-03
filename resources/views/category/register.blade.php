@extends('layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Adicionar Categoria</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Adicionar Categoria</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Informações Gerais</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                {!!  Form::open(['route' => 'category.create', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'registerForm', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        <label for="inputName">Nome da Categoria</label>
                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nome', 'required' => true]); !!}
                    </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <input type="button" id="saveBtn" value="Adicionar" class="btn btn-success float-right">
      {!! Form::close() !!}

      <div id="resultRequest"></div>

    </section>
    <!-- /.content -->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript">

        $(document).ready(function (){
            $("#saveBtn").click(function(){
                var form = $("registerForm").value();

                alert(form);

                $.ajax({
                    url: "{{ route('category.create') }}",
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: form,
                    timeout: 8000,
                    success: function(result){
                        $("#resultRequest").html(result);
                    }

                });
            });
        });




    </script>


@endsection
