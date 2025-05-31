@props(['headers', 'items', 'fields'])

<div class="mb-3">
    <form method="GET" class="row g-2 align-items-end">

        {{-- Field selector --}}
        <div class="col-auto">
            <label for="field" class="form-label">Filter By</label>
            <select name="field" id="field" class="form-select" onchange="handleFieldChange(this)">
                @foreach ($fields as $field)
                    <option value="{{ $field }}" {{ request('field') === $field ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Input field (text or date range) --}}
        <div class="col-auto" id="text-filter">
            <label for="keyword" class="form-label">Keyword</label>
            <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" class="form-control">
        </div>

        <div class="col-auto d-none" id="date-filter">
            <label class="form-label">Date Range</label>
            <div class="d-flex gap-1">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
        </div>

        {{-- Per page --}}
        <div class="col-auto">
            <label for="per_page" class="form-label">Rows</label>
            <select name="per_page" class="form-select" onchange="this.form.submit()">
                @foreach ([10, 20, 50] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Apply</button>
        </div>
    </form>
</div>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>

{{ $items->links() }}

{{-- Script --}}
<script>
    function handleFieldChange(select) {
        const textFilter = document.getElementById('text-filter');
        const dateFilter = document.getElementById('date-filter');

        if (select.value === 'created_at') {
            textFilter.classList.add('d-none');
            dateFilter.classList.remove('d-none');
        } else {
            textFilter.classList.remove('d-none');
            dateFilter.classList.add('d-none');
        }
    }

    // Initial state on load
    document.addEventListener('DOMContentLoaded', function () {
        handleFieldChange(document.getElementById('field'));
    });
</script>
