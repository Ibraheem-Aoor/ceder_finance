@php
    $weekStart = \Carbon\Carbon::now()->startOfWeek();
    $weekEnd = \Carbon\Carbon::now()->endOfWeek();
    if (isset($week_start)) {
        $weekStart = \Carbon\Carbon::parse($week_start);
        $weekEnd = $weekStart->copy()->endOfWeek();
    }
    $days = \Carbon\CarbonPeriod::create($weekStart, $weekEnd);
@endphp
<input type="text" name="week_start" value="{{ $weekStart->toDateString() }}" hidden>

<div class="d-flex justify-content-between">
    <a class="btn btn-success week-navigate" data-week_start="{{ $weekStart->copy()->subWeek()->toDateString() }}">
        <i class="fas fa-arrow-left"></i> {{ __('Previous Week') }}
    </a>
    <a class="btn btn-success week-navigate" data-week_start="{{ $weekStart->copy()->addWeek()->toDateString() }}">
        {{ __('Next Week') }} <i class="fas fa-arrow-right"></i>
    </a>
</div>
<table class="table mt-3 table-responsive hoursTable">
    <thead>
        <tr>
            <th style="width:10% !important;">{{ __('Week') }}</th>
            <th style="width:15% !important;">{{ __('Location') }}</th>
            @foreach ($days as $day)
                <th style="width:10% !important;">{{ __($day->format('l')) }} <br> {{ $day->format('Y-m-d') }}</th>
            @endforeach
            <th style="width:10% !important;">{{ __('Total') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
       
        @endforeach

    </tbody>
</table>
<div class="mt-3">
    <button type="button" class="btn btn-primary" onclick="addNewWeekRow()">{{ __('Add New') }}</button>
</div>
