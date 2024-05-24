<div class="card bg-none card-box" style="width: 120%;">
    {{ Form::model($employee, ['route' => ['hr.employee.update_schedule', $employee->id], 'method' => 'PUT', 'id' => 'schedule-form']) }}
    <h5 class="sub-title">{{ __('Basic Info') }}</h5>
    <a class="btn btn-sm btn-soft-success t mt-2" href="{{ route('hr.employee.download_schedule', $employee->id) }}">
        <i class="fa fa-download"></i> &nbsp;{{ __('Download Working Report') }}
    </a>
    <div class="row">
        {{-- Customer Select --}}
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('customer', __('Customer'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span style="height:50px;"><i class="fas fa-user"></i></span>
                    <select name="customer" id="customer" class="form-control text-center" required>
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @if (isset($customer_id) && $customer->id == @$customer_id) selected @endif>
                                {{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- Location --}}
        {{-- <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('location', __('Location'), ['class' => 'form-control-label']) }}
                <div class="form-icon-user">
                    <span><i class="fas fa-map"></i></span>
                    {{ Form::text('location', $location, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div> --}}
        {{-- Weeks TABLE --}}
        <div class="col-md-12 px-0" id="table-content">
            @include('HR.employee.weeks_table', ['employee' => $employee , 'work_locations' => $work_locations])
        </div>
        <div class="col-md-12 px-0">
            <input type="submit" value="{{ __('Update') }}" class="btn-create badge-blue">
            <input type="button" value="{{ __('Cancel') }}" class="btn-create bg-gray" data-dismiss="modal">
        </div>

        {{ Form::close() }}
    </div>
</div>


{{-- Add this script at the end of your file --}}
<script>
    function addNewWeekRow() {
        console.log('Adding new week row');
        // Get the week table and clone the last row
        let table = document.querySelector('.hoursTable tbody');
        console.log(table);
        let lastRow = table.querySelector('tr:last-child');
        let newRow = lastRow.cloneNode(true); // Clone the row structure with children

        // Increment the location index
        let locationIndex = table.querySelectorAll('tr').length + 1;

        // Update the name attributes in the new row
        newRow.querySelectorAll('input').forEach(input => {
            let name = input.getAttribute('name');
            if (name) {
                name = name.replace(/\d+/, locationIndex);
                input.setAttribute('name', name);
                if (input.type !== 'hidden') {
                    input.value = 0; // Clear the value
                }
            }
        });

        // Remove any existing delete button in the cloned row
        let existingDeleteCell = newRow.querySelector('td:last-child');
        if (existingDeleteCell && existingDeleteCell.innerHTML.includes('fa-trash')) {
            existingDeleteCell.remove();
        }

        // Add the delete button to the new row
        let deleteCell = document.createElement('td');
        deleteCell.innerHTML =
            '<button class="btn btn-sm btn-soft-danger" type="button" onclick="removeRow(this);"><i class="fa fa-trash"></i></button>';
        newRow.appendChild(deleteCell);

        // Append the new row to the table
        table.appendChild(newRow);

        // Recalculate totals
        calculateTotal();
    }

    function removeRow(button) {
        // Find the row to remove
        let row = button.closest('tr');
        if (row) {
            row.remove();
            // Recalculate totals after removing the row
            calculateTotal();
        }
    }

    // Example function for calculating total, adjust as needed
    function calculateTotal() {
        let totalHours = 0;
        document.querySelectorAll('input[name^="location"]').forEach(input => {
            if (input.name.includes('hours')) {
                totalHours += parseFloat(input.value) || 0;
            }
        });
        let totalElement = document.getElementById('total-hours');
        if (totalElement) {
            totalElement.innerText = totalHours.toFixed(2);
        }
    }

    document.addEventListener('input', (event) => {
        if (event.target.matches('input[name^="location"]')) {
            calculateTotal();
        }
    });

    // Initial calculation on page load
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
