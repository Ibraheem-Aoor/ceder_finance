@extends('layouts.admin')
@section('page-title')
    {{ __('Tax Summary') }}
@endsection
@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var year = '{{ $currentYear }}';

        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A2'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endpush

@section('action-button')
    <div class="row d-flex justify-content-end">
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
            {{ Form::open(['route' => ['report.tax.summary'], 'method' => 'GET', 'id' => 'report_tax_summary']) }}
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('year', __('Year'), ['class' => 'text-type']) }}
                    {{ Form::select('year', $yearList, isset($_GET['year']) ? $_GET['year'] : '', ['class' => 'form-control select2']) }}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('quarter', __('Quarter'), ['class' => 'text-type']) }}
                    {{ Form::select(
                        'quarter',
                        [
                            1 => __('1st Quarter'),
                            2 => __('2nd Quarter'),
                            3 => __('3rd Quarter'),
                            4 => __('4th Quarter'),
                        ],
                        isset($_GET['quarter']) ? $_GET['quarter'] : '',
                        ['class' => 'form-control select2'],
                    ) }}
                </div>
            </div>
        </div>
        <div class="col-auto my-auto">
            <a href="#" class="apply-btn"
                onclick="document.getElementById('report_tax_summary').submit(); return false;" data-toggle="tooltip"
                data-original-title="{{ __('apply') }}">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="{{ route('report.tax.summary') }}" class="reset-btn" data-toggle="tooltip"
                data-original-title="{{ __('Reset') }}">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
            {{-- <a href="#" class="action-btn" onclick="saveAsPDF()" data-toggle="tooltip" data-original-title="{{__('Download')}}">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a> --}}
            <a href="{{ route('report.download_full_tax_report' , ['year' => @$_GET['year'] ?? date('Y') , 'quarter' => @$_GET['quarter'] ?? 1]) }}" target="_blank" class="action-btn"
                data-original-title="{{ __('Download For TAX') }}">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('content')
    <div id="printableArea">
        <div class="row mt-3">
            <div class="col">
                <input type="hidden"
                    value="{{ __('Tax Summary') . ' ' . 'Report of' . ' ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}"
                    id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{ __('Report') }} :</h5>
                    <h5 class="report-text mb-0">{{ __('Tax Summary') }}</h5>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{ __('Duration') }} :</h5>
                    <h5 class="report-text mb-0">{{ $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}</h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <h5>{{ __('Income') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Tax') }}</th>
                                            @foreach ($monthList as $month)
                                                <th>{{ $month }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(array_keys($incomes) as $k=> $taxName)
                                            <tr>
                                                <td>{{ $taxName }}</td>
                                                @foreach (array_values($incomes)[$k] as $price)
                                                    <td>{{ \Auth::user()->priceFormat($price) }}</td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13" class="text-center">{{ __('Income tax not found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h5>{{ __('Expense') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Tax') }}</th>
                                            @foreach ($monthList as $month)
                                                <th>{{ $month }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(array_keys($expenses) as $k=> $taxName)
                                            <tr>
                                                <td>{{ $taxName }}</td>
                                                @foreach (array_values($expenses)[$k] as $price)
                                                    <td>{{ \Auth::user()->priceFormat($price) }}</td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13" class="text-center">{{ __('Expense tax not found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
