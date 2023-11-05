<div class="main">
    <div class="box-header with-border">
        <div class="row text-right">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="controls">
                        <label for="per_page">Search By Request Id:</label>
                        <input type="search" name="search" class="form-control" wire:model="search" placeholder="search by request id......">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="paymentFilter">Items per page:</label>
                    <select id="paymentFilter" class="form-control" wire:model="paymentFilter">
                        <option value="" disabled>Select Payament Status</option>
                        <option value="1" selected>Paid</option>
                        <option value="0">Unpaid</option>

                        <!-- Add more options if needed -->
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="per_page">Items per page:</label>
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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="sorting">Sorting:</label>
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
                <th> @lang('view_pages.request_id')</th>
                <th> @lang('view_pages.date')</th>
                <th> @lang('view_pages.user_name')</th>
                <th> @lang('view_pages.driver_name')</th>
                <th> @lang('view_pages.trip_status')</th>
                <th> @lang('view_pages.is_paid')</th>
                <th> @lang('view_pages.payment_option')</th>
                <th> @lang('view_pages.action')</th>
            </tr>
        </thead>
        <tbody>



            @php
                $i = 1;
            @endphp
            @forelse($results as $key => $result)
                <tr>
                    <td>{{ $i++ }} </td>
                    <td>{{ $result->request_number }}</td>
                    <td>{{ $result->getConvertedTripStartTimeAttribute() }}</td>
                    <td>{{ $result->userDetail ? $result->userDetail->name : '-' }}</td>
                    <td>{{ $result->driverDetail ? $result->driverDetail->name : '-' }}</td>

                    @if ($result->is_cancelled == 1)
                        <td><span class="label label-danger">@lang('view_pages.cancelled')</span></td>
                    @elseif($result->is_completed == 1)
                        <td><span class="label label-success">@lang('view_pages.completed')</span></td>
                    @elseif($result->is_trip_start == 0 && $result->is_cancelled == 0)
                        <td><span class="label label-warning">@lang('view_pages.not_started')</span></td>
                    @else
                        <td>-</td>
                    @endif

                    @if ($result->is_paid)
                        <td><span class="label label-success">@lang('view_pages.paid')</span></td>
                    @else
                        <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
                    @endif

                    @if ($result->payment_opt == 0)
                        <td><span class="label label-danger">@lang('view_pages.card')</span></td>
                    @elseif($result->payment_opt == 1)
                        <td><span class="label label-primary">@lang('view_pages.cash')</span></td>
                    @elseif($result->payment_opt == 2)
                        <td><span class="label label-warning">@lang('view_pages.wallet')</span></td>
                    @else
                        <td><span class="label label-info">@lang('view_pages.cash_wallet')</span></td>
                    @endif

                    @if ($result->is_completed)
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('requests', $result->id) }}">
                                        <i class="fa fa-eye"></i>@lang('view_pages.view')</a>
                                </div>
                            </div>
                        </td>
                    @else
                        <td>-</td>
                    @endif
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

