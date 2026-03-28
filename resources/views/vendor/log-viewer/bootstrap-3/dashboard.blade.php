{{-- @extends('log-viewer::bootstrap-3._master') --}}
@extends('log-viewer::bootstrap-3.logstemplate')
@section('content')
<div class="box">
    <nav class="navbar navbar-primary">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">@lang('Toggle navigation')</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{ route('log-viewer::dashboard') }}" class="navbar-brand">
                    <i class="fa fa-fw fa-book"></i> LogViewer
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="{{ Route::is('log-viewer::dashboard') ? 'active' : '' }}">
                        <a href="{{ route('log-viewer::dashboard') }}">
                            <i class="fa fa-dashboard"></i> @lang('Dashboard')
                        </a>
                    </li>
                    <li class="{{ Route::is('log-viewer::logs.list') ? 'active' : '' }}">
                        <a href="{{ route('log-viewer::logs.list') }}">
                            <i class="fa fa-archive"></i> @lang('Logs')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h1 class="page-header">@lang('Dashboard')</h1>
  <div class="panel">
    <div class="row">
        <div class="col-md-3">
            <canvas id="stats-doughnut-chart" height="300"></canvas>
        </div>
        <div class="col-md-9">
                <div class="row">
                    @foreach($percents as $level => $item)
                        <div class="col-md-4">
                            <div class="info-box bg-red level level-{{ $level }} {{ $item['count'] === 0 ? 'level-empty' : '' }}">
                                <span class="info-box-icon">
                                    {{ log_styler()->icon($level) }}
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ $item['name'] }}</span>
                                    <span class="info-box-number">
                                        {{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

        </div>
    </div>
</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
<script>
    Chart.defaults.global.responsive      = true;
    Chart.defaults.global.scaleFontFamily = "'Source Sans Pro'";
    Chart.defaults.global.animationEasing = "easeOutQuart";
</script>
@yield('modals')
    <script>
        $(function() {
            new Chart($('canvas#stats-doughnut-chart'), {
                type: 'doughnut',
                data: {!! $chartData !!},
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            });
        });
    </script>

