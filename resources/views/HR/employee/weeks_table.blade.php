@php
    $weekStart = \Carbon\Carbon::now()->startOfWeek();
    $weekEnd = \Carbon\Carbon::now()->endOfWeek();
    if (isset($week_start)) {
        $weekStart = \Carbon\Carbon::parse($week_start);
        $weekEnd = $weekStart->copy()->endOfWeek();
    }
    $days = \Carbon\CarbonPeriod::create($weekStart, $weekEnd);
@endphp

<div class="d-flex justify-content-between">
    <a data-href="{{ route('hr.employee.update_schedule', ['employee' => $employee->id, 'week_start' => $weekStart->copy()->subWeek()->toDateString()]) }}"
        class="btn btn-primary week-navigate">
        <i class="fas fa-arrow-left"></i> {{ __('Previous Week') }}
    </a>
    <a data-href="{{ route('hr.employee.update_schedule', ['employee' => $employee->id, 'week_start' => $weekStart->copy()->addWeek()->toDateString()]) }}"
        class="btn btn-primary week-navigate">
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
            <th>{{ __('weekend') }}</th>

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
                    <input type="number" name="hours[{{ $day->format('l') }}]" class="form-control" value="{{ $value }}"
                        step="0.01" oninput="calculateTotal()" required>
                    <input type="hidden" name="dates[{{ $day->format('l') }}]" value="{{ $day->toDateString() }}">
                </td>
            @endforeach
            <td>{{ __('Weekend') }}</td>

            <td id="total-hours">0</td>
        </tr>
    </tbody>
</table>
