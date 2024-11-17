@extends('layouts.app')

@section('title', 'Data Criteria')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Criteria</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Criteria List</h2>
            <p class="section-lead">
                You can manage all criteria, such as editing, deleting and more.
            </p>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <a href="{{ route('criteria.create') }}" class="btn btn-primary">Add Criteria</a>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="alert alert-warning">
                                        <div class="alert-title">Total Weight</div>
                                        {{ $sumWeights }}
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Weight</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    @forelse ($criterion as $cr)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $cr->code }}</td>
                                            <td>{{ $cr->type }}</td>
                                            <td>{{ $cr->weight }}</td>
                                            <td>{{ $cr->description }}</td>
                                            <td>
                                                <a href="{{ route('criteria.edit', $cr->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <form action="{{ route('criteria.destroy', $cr->id) }}" method="POST">
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
