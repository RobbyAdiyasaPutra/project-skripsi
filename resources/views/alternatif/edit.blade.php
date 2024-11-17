@extends('layouts.app')

@section('title', 'Criteria Add Data')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Data Alternatif</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Form Validation</h2>
            <p class="section-lead">Form validation using default from Bootstrap 4</p>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Default Validation</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" placeholder="example: AI"
                                        name="name" value="{{ $alternatif->name }}" required>
                                </div>
                                @foreach ($criterion as $key => $c)
                                    <div class="form-group">
                                        <label for="score[{{ $c->id }}]">{{ $c->code }} -
                                            {{ $c->description }}</label>
                                        <input type="number" class="form-control" step="any"
                                            placeholder="example: 0.15" id="score[{{ $c->id }}]"
                                            name="score[{{ $c->id }}]"
                                            value="{{ isset($alternatifskor[$key]) ? $alternatifskor[$key]->score : '' }}">
                                    </div>
                                @endforeach
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('sidebar')
