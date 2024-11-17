@extends('layouts.app')

@section('title', 'Decision Matrix')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Decision Matrix</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Decision Matrix</h2>
            <p class="section-lead">
                decision matrix table for each alternative and criterion
            </p>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Decision Matrik Table</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        @foreach ($criterion as $c)
                                            <th>{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                    @forelse ($alternatif as $a)
                                        <tr>
                                            <td>{{ $a->name }}</td>
                                            @foreach ($criterion as $cr)
                                                <td>
                                                    @php
                                                        $s = $scores
                                                            ->where('alternatif_id', $a->id)
                                                            ->where('criteria_id', $cr->id)
                                                            ->first();
                                                    @endphp
                                                    {{ $s ? $s->score : '' }}
                                                </td>
                                            @endforeach
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
