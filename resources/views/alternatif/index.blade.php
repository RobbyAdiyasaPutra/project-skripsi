@extends('layouts.app')

@section('title', 'Data Alternatif')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Alternatif</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Data Alternatif</h2>
            <p class="section-lead">
                You can manage all data alternatif, such as editing, deleting and more.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <a href="{{ route('alternatif.create') }}" class="btn btn-primary">Add Alternatif</a>
                            </div>
                            <div class="float-right">
                                <form method="GET">
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        @foreach ($criterion as $c)
                                            <th>{{ $c->description }}</th>
                                        @endforeach
                                        <th>Action</th>
                                    </tr>
                                    @forelse ($alternatif as $a)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $a->name }}</td>
                                            @foreach ($criterion as $cr)
                                                @php
                                                    // menggunakan methof first() untuk object pertama
                                                    $s = $scores
                                                        ->where('ida', $a->id)
                                                        ->where('idc', $cr->id)
                                                        ->first();
                                                @endphp
                                                <td>{{ $s ? $s->score : '' }}</td>
                                            @endforeach
                                            <td>
                                                <a href="{{ route('alternatif.edit', $a->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <form action="{{ route('alternatif.destroy', $a->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('confirmasi delete data?')"
                                                        class="btn btn-danger">Delete</button>
                                                </form>
                                            <td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('sidebar')
