@extends('layouts.app')

@section('title', 'Criteria Edit Data')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Data Criteria</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Form Edit Data</h2>
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

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="alert alert-warning">
                                        <div class="alert-title">Total Weight</div>
                                        {{ $sumWeights }}
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('criteria.update', [$criterion->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="code">Kode Name</label>
                                    <input id="code" type="text" class="form-control" placeholder="example: CI"
                                        name="code" value="{{ $criterion->code }}" required />
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" id="type" name="type">
                                        @if ($criterion->type == 'benefit')
                                            <option value="benefit" selected>Benefit</option>
                                            <option value="cost">Cost</option>
                                        @else
                                            <option value="benefit">Benefit</option>
                                            <option value="cost" selected>Cost</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Weight</label>
                                    <input id="weight" type="number" class="form-control" step="any"
                                        placeholder="example: 0.15" name="weight" value="{{ $criterion->weight }}"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input id="description" type="text" class="form-control"
                                        placeholder="example: Absensi" name="description"
                                        value="{{ $criterion->description }}" required>
                                </div>
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
