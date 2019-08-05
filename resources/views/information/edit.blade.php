@extends('shared.layout')
@section('title', "Sunting Informasi {$information->name}")
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Informasi {{ $information->name }}
    </h1>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Informasi {{ $information->name }}
        </div>
        <div class="card-body">
            <form method='POST' action='{{ route('information.update', $information) }}'>
                @csrf

                <div class='form-group'>
                    <label for='description'>
                        Deskripsi:
                    </label>

                    <textarea
                        id='description'
                        placeholder='Deskripsi'
                        name='description'
                        class='form-control {{ $errors->has('description') ? 'is-invalid' : '' }}'
                        cols='30'
                        rows='15'
                        >{{ old('description', $information->description) }}</textarea>

                    <div class='invalid-feedback'>
                        {{ $errors->first('description') }}
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-primary">
                        Perbarui Data
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
