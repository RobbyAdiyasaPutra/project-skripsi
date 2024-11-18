@extends('layouts.app')

@section('title', 'Calculate Vikor')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Calculate Vikor</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Vikor</h2>
            <p class="section-lead">
                vikor is a method for multi-criteria decision making
            </p>
            {{-- matrik F --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Matrik Decision(F)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Criteria</th>
                                        @foreach ($criterion as $cr)
                                            <th>{{ $cr->code }}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        @foreach ($weights as $weight)
                                            <td>{{ $weight }}</td>
                                        @endforeach
                                    </tr>
                                </table>
                                <hr>
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
            {{--  --}}
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Matrik Normalisasi(N)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Alternative</th>
                                        @foreach ($criterion as $c)
                                            <th>{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                    @foreach ($alternatif as $altKey => $a)
                                        <tr>
                                            <td>{{ $a->name }}</td>
                                            @foreach ($criterion as $critKey => $c)
                                                <td>
                                                    {{ $normalizedMatrix[$a->id][$c->id] }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Normalisasi Weight(F*)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Criteria</th>
                                        @foreach ($criterion as $c)
                                            <th>{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        @foreach ($weights as $weight)
                                            <td>
                                                {{ $weight }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                                <hr>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Alternatif</th>
                                        @foreach ($criterion as $c)
                                            <th>{{ $c->code }}</th>
                                        @endforeach
                                    </tr>
                                    @foreach ($alternatif as $altKey => $a)
                                        <tr>
                                            <td>{{ $a->name }}</td>
                                            @foreach ($criterion as $critKey => $c)
                                                <td>
                                                    {{ $weightedMatrix[$a->id][$c->id] }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- S & R --}}
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Result Utility Measure (S) and Regret Measure (R)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>S_Min</th>
                                        <th>S_Max</th>
                                        <th>R_Min</th>
                                        <th>R_Max</th>
                                        <th>V</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $s_min }}</td>
                                        <td>{{ $s_max }}</td>
                                        <td>{{ $r_min }}</td>
                                        <td>{{ $r_max }}</td>
                                        <td>{{ $v }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Q & Rank --}}
            <h2 class="section-title">Vikor Final Result</h2>
            <p class="section-lead">
                Q is the final result of the vikor method and the ranking of the alternatives
            </p>
            <div class="row mt-2">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Index Vikor(Q)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Q</th>
                                        <th>Nilai</th>
                                    </tr>
                                    @foreach ($q as $key => $value)
                                        <tr>
                                            <td>Q{{ $loop->iteration }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Rankings</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Rankings</th>
                                        <th>Alternatif Code</th>
                                        <th>Nilai Q</th>
                                    </tr>
                                    @foreach ($result as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $key }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
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
