@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Vikor Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="section-body">
                <h2 class="section-title">Content</h2>
                <p class="section-lead">pages that exist on this website.</p>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article">
                            <div class="article-details">
                                <h5>Criteria Management</h5>
                                <hr>
                                <p>The Criteria Management page is dedicated to handling crucial decision-making
                                    criteria. Specify the weight and importance
                                    of each criterion to provide a structured approach in evaluating alternatives. </p>
                                <div class="article-cta">
                                    <a href="{{ route('criteria.index') }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article">
                            <div class="article-details">
                                <h5>Alternative Management</h5>
                                <hr>
                                <p>Focus on the management and assessment of various alternatives or options for a decision.
                                    Add, edit, and prioritize alternatives based on specific criteria to facilitate
                                    comparison before decision-making. </p>
                                <div class="article-cta">
                                    <a href="{{ route('alternatif.index') }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article">
                            <div class="article-details">
                                <h5>Decision Matrix</h5>
                                <hr>
                                <p>Display weighted scores for each alternative based on established criteria. Allows
                                    visualization and analysis of the decision matrix to gain insights into the quantitative
                                    performance of alternatives. </p>
                                <div class="article-cta">
                                    <a href="{{ route('decisionmatrix.index') }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article">
                            <div class="article-details">
                                <h5>Vikor Processing</h5>
                                <hr>
                                <p>Apply the VIKOR method, a multi-criteria decision-making technique. Input decision matrix
                                    data for VIKOR analysis, enabling ranking and selection of the best alternatives based
                                    on predefined criteria. </p>
                                <div class="article-cta">
                                    <a href="{{ route('calculate.index') }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>What is Vikor!!!</h4>
                    </div>
                    <div class="card-body">
                        <p>Metode VIKOR fokus pada perankingan dan memilih dari satu set sampel dengan kriteria yang saling
                            bertentangan, yang dapat membantu para pengambil keputusan untuk mendapatkan keputusan akhir
                            (Opricovic and Tzeng 2007). Metode ini sangat berguna pada situasi dimana pengambil keputusan
                            tidak memiliki kemampuan untuk menentukan pilihan pada saat desain sebuah sistem dimulai (Sayadi
                            and Heydari 2009).
                            <br><br>
                            Metode VIKOR adalah sebuah metode untuk optimisasi/optimalisasi kriteria majemuk dalam suatu
                            sistem yang kompleks (Khezrian and Kadir, et al. 2011). Konsep dasar VIKOR adalah menentukan
                            ranking dari sampel-sampel yang ada dengan melihat hasil dari nilai-nilai sesalan atau regrets
                            (R) dari setiap sampel. Metode VIKOR telah digunakan oleh beberapa peneliti dalam MCDM, seperti
                            dalam pemilihan vendor (Datta and Mahapatra, et al. 2010), perbandingan metode-metode outranking
                            (Opricovic and Tzeng 2007), pemilihan bahan dalam industri (Cristobal and Biezma, et al. 2009).
                            Dan masih banyak lagi penelitian-penelitian yang menggunakan metode VIKOR ini.
                        </p>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <p>Source: <a href="https://extra.cahyadsn.com/vikor#p1" target="_blank">VIKOR Method: A Systematic
                                Review of the State of the Art Literature on
                                Methodologies and Applications</a></p>
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('sidebar')
