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
<table class="table mt-3 table-responsive">
    <thead>
        <tr>
            <th>{{ __('Week') }}</th>
            @foreach ($days as $day)
                <th>{{ __($day->format('l')) }} <br> {{ $day->format('Y-m-d') }}</th>
            @endforeach

            <th>{{ __('Total') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ __('Week ' . $weekStart->weekOfYear) }}</td>
            @foreach ($days as $day)
                <td>
                    @php
                        $value = 0;
                        if (isset($work_hours) && in_array($day->toDateString(), array_keys($work_hours))) {
                            $value = $work_hours[$day->toDateString()];
                        }
                    @endphp
                    <input type="number" name="hours[{{ $day->format('l') }}]" class="form-control"
                        value="{{ $value }}" step="0.01" oninput="calculateTotal()" required>
                    <input type="hidden" name="dates[{{ $day->format('l') }}]" value="{{ $day->toDateString() }}">
                </td>
            @endforeach

            <td id="total-hours">0</td>
        </tr>
    </tbody>
</table>
