<div class="row mb-3 align-items-center">
    <div class="col-6"></div>
    <div class="col-12 mb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <form method="GET" class="search-bar">
                <input type="hidden" name="tab" value="{{ $tab }}">

                <input type="text"
                    name="{{ $name }}"
                    placeholder="Search by Publisher / Book Name"
                    value="{{ $searchUnshipped }}">

                <button type="submit">
                    Search
                </button>
            </form>

            <form  method="GET" action="" class="export-bar exportForm">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="hidden" name="{{ $name }}" value="{{ $searchUnshipped }}">
                <input type="hidden" name="{{ $page }}" value="{{ request($page, 1) }}">

                <select class="exportType" name="export_type">
                    <option value="with_image">With Images</option>
                    <option value="without_image">Without Images (PDF)</option>
                    <option value="without_image_xls">Without Images (XLS)</option>
                </select>

                <div  class="exportButtons  d-flex">
                    <button type="submit" formaction="{{ route('dashboard.exportPdf') }}" class="btn btn-primary">
                        ðŸ“„ Export
                        </button>
                </div>
            </form>

            <form method="GET" class="export-bar">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="hidden" name="{{ $name }}" value="{{ $searchUnshipped }}">
                <input type="hidden" name="{{ $page }}" value="{{ request($page, 1) }}">

                <select name="sort" onchange="this.form.submit()">
                    <option value="asc" {{ request()->sort == 'asc' ? 'selected' : '' }}>ASC</option>
                    <option value="desc" {{ request()->sort == 'desc' ? 'selected' : '' }}>DESC</option>
                </select>
            </form>

            <form method="GET" class="mt-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="hidden" name="{{ $name }}" value="{{ $searchUnshipped }}">
                <input type="hidden" name="{{ $page }}" value="{{ request($page, 1) }}">
                <input type="hidden" name="sort" value="{{ request()->sort }}">

                <label class='fw-bold'> From
                    <input type='date' name='from_date' class='form-control' value="{{ request('from_date') }}" />
                </label>
                <label class='fw-bold'> To
                    <input type='date' name='to_date' class='form-control' value="{{ request('to_date') }}" />
                </label>

                <button type="submit" class='btn btn-primary'>Search</button>
            </form>
        </div>
    </div>
</div>