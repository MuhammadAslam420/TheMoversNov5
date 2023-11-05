<div class="main">
    <div class="box-header with-border">
        <h1 class="title">All Drivers Online Duration</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="controls">
                        <label for="per_page" class="label-control">Search By Driver Name & Date</label>
                        <input type="search" name="search" class="form-control" wire:model="search" placeholder="search by driver & date......">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="per_page" class="label-control">Items per page</label>
                    <select id="per_page" class="form-control" wire:model="perPage">
                        <option value="6">6</option>
                        <option value="8">8</option>
                        <option value="12">12</option>
                        <option value="16">16</option>
                        <option value="24">24</option>
                        <option value="32">32</option>
                        <option value="50">50</option>

                        <!-- Add more options if needed -->
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sorting" class="label-control">Sorting:</label>
                    <select id="sorting" class="form-control" wire:model="sorting">
                        <option value="desc">New</option>
                        <option value="asc">Old</option>
                    </select>
                </div>
            </div>


        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th> @lang('view_pages.s_no')</th>
                <th>ID</th>
                <th> @lang('view_pages.driver_name')</th>
                <th> Online Duration</th>
                <th> @lang('view_pages.date')</th>
            </tr>
        </thead>
        <tbody>



            @php
                $i = 1;
            @endphp
            @forelse($results as $key => $result)
                <tr>
                    <td>{{ $i++ }} </td>
                    <td>{{ $result->id }}</td>
                    <td>{{ $result->driver ? $result->driver->name : '-' }}</td>
                    <td>
                        @if($result->duration != 0)
                        {{(number_format(($result->duration)/60,  2))}} : hrs
                        @elseif($result->duration == 0)
                        0 : hrs
                        @endif
                    </td>
                    <td>{{\Carbon\Carbon::parse($result->created_at)->isoFormat('MMM Do YYYY')}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">
                        <p id="no_data" class="lead no-data text-center">
                            <img src="{{ asset('assets/img/dark-data.svg') }}"
                                style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                        <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                        </p>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div class="pagination">
        <span style="float:right">
            {{ $results->links() }}
        </span>
    </div>
</div>
