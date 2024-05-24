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
            <th>{{ __('Week') }}</th>
            <th colspan="2">{{ __('Location') }}</th>
            @foreach ($days as $day)
                <th>{{ __($day->format('l')) }} <br> {{ $day->format('Y-m-d') }}</th>
            @endforeach
            <th>{{ __('Total') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($work_locations) && !$work_locations->isEmpty())
            @foreach ($work_locations as $location)
                @php
                    $index = $loop->index;
                @endphp
                <tr>
                    <td>{{ __('Week ' . $weekStart->weekOfYear) }}</td>
                    <td colspan="2" style="width:15% !important;">
                        <input class="form-control w-200" name="locations[{{ $index }}][name]"
                            value="{{ $location->first()->location }}" required>
                    </td>

                    @foreach ($days as $day)
                        @php
                            $work_hours = $location->pluck('hours', 'date')->toArray();
                            $value = 0;
                            if (isset($work_hours) && in_array($day->toDateString(), array_keys($work_hours))) {
                                $value = $work_hours[$day->toDateString()];
                            }
                        @endphp
                        <td>
                            <input type="number"
                                name="locations[{{ $index }}][hours][{{ $day->format('l') }}]"
                                class="form-control" value="{{ $value }}" step="0.01" required>
                            <input type="hidden"
                                name="locations[{{ $index }}][dates][{{ $day->format('l') }}]"
                                value="{{ $day->toDateString() }}">
                        </td>
                    @endforeach
                    <td id="total-hours">0</td>

                    <td>
                        @if (!$loop->first)
                            <button class="btn btn-sm btn-soft-danger" type="button" onclick="removeRow(this);"><i
                                    class="fa fa-trash"></i></button>
                        @else
                            &nbsp;
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>{{ __('Week ' . $weekStart->weekOfYear) }}</td>
                <td colspan="2" style="width:15% !important;">
                    <input class="form-control" name="locations[1][name]" required>
                </td>
                @foreach ($days as $day)
                    <td>
                        @php
                            $value = 0;
                            if (isset($work_hours) && in_array($day->toDateString(), array_keys($work_hours))) {
                                $value = $work_hours[$day->toDateString()];
                            }
                        @endphp
                        <input type="number" name="locations[1][hours][{{ $day->format('l') }}]" class="form-control"
                            value="{{ $value }}" step="0.01" required>
                        <input type="hidden" name="locations[1][dates][{{ $day->format('l') }}]"
                            value="{{ $day->toDateString() }}">
                    </td>
                @endforeach
                <td id="total-hours">0</td>
            </tr>
        @endif
    </tbody>
</table>
<div class="mt-3 text-center">
    <button type="button" class="btn btn-soft-success" onclick="addNewWeekRow()"><i class="fa fa-plus"></i> {{ __('Add New') }}</button>
</div>
