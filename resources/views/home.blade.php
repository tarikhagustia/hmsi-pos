@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                @livewire('branch-overview')
            </div>
{{--            <div class="col-lg-4 col-md-4 col-sm-12">--}}
{{--                @livewire('pos-overview')--}}
{{--            </div>--}}
        </div>
    </section>
@endsection

@push('stylesheet')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
@endpush
@push('javascript')
    <script type="text/javascript">

        window.livewire.on('labelsUpdated', data => {
            Chart.helpers.each(Chart.instances, function (instance) {
                instance.chart.data.labels = JSON.parse(data);
                instance.chart.update();
            })
        })

        window.livewire.on('datasetsUpdated', data => {
            console.log(data)
            var data = JSON.parse(data);
            Chart.helpers.each(Chart.instances, function (instance) {
                instance.chart.data.datasets.forEach((dataset, key) => {
                    dataset.data = data[key];
                });
                instance.chart.update();
            })
        })

        window.livewire.on('optionsUpdated', data => {
            var data = JSON.parse(data);
            Chart.helpers.each(Chart.instances, function (instance) {
                instance.chart.options = data;
                instance.chart.update();
            })
        })

    </script>
@endpush
