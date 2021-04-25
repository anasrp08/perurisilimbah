@extends('layouts.app')

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Ubah Password</title>
@section('dashboard')
    Password
    <small>Ubah Password</small>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Ubah Password</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Password</h3>
                </div>
                <!-- /.box-header -->
                {!! Form::open(['url' => url('/settings/password'), 'method' => 'post']) !!}
                    <div class="box-body">

                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Password Lama') !!}

                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password lama']) !!}
                            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            {!! Form::label('new_password', 'Password Baru') !!}

                            {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'Password baru']) !!}
                            {!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                            {!! Form::label('new_password_confirmation', 'Konfirmasi Password Baru') !!}

                            {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => 'Konfirmasi password baru']) !!}
                            {!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
