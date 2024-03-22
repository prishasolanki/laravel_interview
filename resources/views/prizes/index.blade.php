@extends('default')

@section('content')


    @include('prob-notice')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('prizes.create') }}" class="btn btn-info">Create</a>
                </div>
                <h1>Prizes</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Probability</th>
                            <th>Awarded</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prizes as $prize)
                            <tr>
                                <td>{{ $prize->id }}</td>
                                <td>{{ $prize->title }}</td>
                                <td>{{ $prize->probability }}</td>
                                <td>0</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('prizes.edit', [$prize->id]) }}" class="btn btn-primary">Edit</a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['prizes.destroy', $prize->id]]) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Simulate</h3>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['method' => 'POST', 'route' => ['simulate']]) !!}
                        <div class="form-group">
                            {!! Form::label('number_of_prizes', 'Number of Prizes') !!}
                            {!! Form::number('number_of_prizes', 10, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('Simulate', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                    <br>
                    <div class="card-body">
                        {!! Form::open(['method' => 'POST', 'route' => ['reset']]) !!}
                        {!! Form::submit('Reset', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(remainPrice() == 0)
    <div class="container  mb-4">
        <div class="row">
            <div class="col-md-6" style="height: 600px;width:600px">
                <h2>Probability Settings</h2>
                <canvas id="probabilityChart"></canvas>
            </div>
            <div class="col-md-6" style="height: 600px;width:600px">
                <h2>Actual Rewards</h2>
                <canvas id="awardedChart"></canvas>
            </div>
        </div>
    </div>
    @endif
@stop

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const probChart = document.getElementById('probabilityChart');

        new Chart(probChart, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($proLabelsDatas); ?>,
                datasets: [{
                    data: <?php echo json_encode($proData); ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(0, 255, 0)',
                        'rgb(0, 128, 128)'
                    ],
                    hoverOffset: 4
                }],
            }
        });

        const actualChart = document.getElementById('awardedChart');

        new Chart(actualChart, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($actualDatas); ?>,
                datasets: [{
                    data: <?php echo json_encode($actualLabels); ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(0, 255, 0)',
                        'rgb(0, 128, 128)'
                    ],
                    hoverOffset: 4
                }],
            }
        });
    </script>
@endpush
