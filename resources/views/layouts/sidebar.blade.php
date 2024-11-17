<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">Vikor</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">Vr</a>
    </div>
    <ul class="sidebar-menu">
        @section('sidebar')
            <li class="nav-link">
                <a href="{{ url('dashboard') }}"><i class="fas fa-home"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Data Processing</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('criteria.index') }}">Data Criteria</a></li>
                    <li><a class="nav-link" href="{{ route('alternatif.index') }}">Data Alternatif & Value</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Vikor Result</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('decisionmatrix.index') }}">Decision Matrix</a></li>
                    <li><a class="nav-link" href="{{ route('calculate.index') }}">Calculate Vikor</a></li>
                    {{-- <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li> --}}
                </ul>
            </li>
        @show
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="{{ url('calculate') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Ranking Result
        </a>
    </div>
</aside>
