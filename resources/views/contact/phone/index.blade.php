@extends('layouts.app')

@section('content')
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
          <div class="card">
            {!! Form::open(['method' => 'GET']) !!}
            <div class="card-header">
              <h3 class="card-title">Lista de Telefone/Celulares do contato <a href="{{ route('contact.index') }}"><strong>{{ $contact->name }}</strong></a></h3>

                <a style="margin-left: 20px; heigth: 10px;" class="btn btn-success btn-sm col-2" href="{{ route('phone.register', $contact->id) }}">
                    <i class="fas fa-plus-square">
                    </i>
                    Adicionar
                </a>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">

                  <input type="text" name="search" value="{{ request()->search ? request()->search : '' }}" class="form-control float-right" placeholder="Pesquisar">

                  <div class="input-group-append">
                    <button type="submit" id="search" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            {!! Form::close() !!}

            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Contato</th>
                    <th>Tipo</th>
                    <th>Numero</th>
                  </tr>
                </thead>
                @foreach ($phones_list ?? [] as $phone)
                    <tbody>
                        <tr>
                            <td>{{ $phone->contact->name ?? '' }}</td>
                            <td>{{ $phone->type == 1 ? 'Telefone' : 'Celular' }}</td>
                            <td>{{ $phone->phone }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('phone.edit', [$contact->id, $phone->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Editar
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ route('phone.destroy', [$contact->id, $phone->id]) }}">
                                    <i class="fas fa-trash">
                                    </i>
                                    Excluir
                                </a>
                                <a class="btn btn-success btn-sm col-2" target="_blank" href="https://api.whatsapp.com/send?phone={{ $phone->phone }}&text=Ol%C3%A1%2C%20tudo%20bem%3F">
                                    <i class="fab fa-whatsapp">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->


@endsection
