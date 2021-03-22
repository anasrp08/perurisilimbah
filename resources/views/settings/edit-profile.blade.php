@extends('layouts.app')

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Edit Profile</title>
@section('dashboard')
    Profile
    <small>Edit Profile</small>
@endsection

@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ url('/settings/profile/') }}">Profile</a></li>
    <li class="active">Edit Profile</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Profil</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model(auth()->user(), ['url' => url('/settings/profile'), 'method' => 'post', 'files' => 'true']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', 'Nama') !!}

                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama']) !!}
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', 'Email') !!}

                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('avatar') ? ' has-error' : '' }}">
                        {!! Form::label('avatar', 'Foto Profil') !!}

                        {!! Form::file('avatar', ['class' => 'form-control']) !!}
                        <p class="help-block">Pilih foto profil</p>
                        {!! $errors->first('avatar', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
