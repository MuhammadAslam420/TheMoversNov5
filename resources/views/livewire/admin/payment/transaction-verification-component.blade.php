<div>
    <div class="box-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Action</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody>
              @forelse ($transactions as $item)
              <tr>
                <td>{{ $item->transaction_id }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMM Do YY') }}</td>
                <td>{{ $item->amount }}</td>
                <td>
                    <a href="#" class="btn bg-success" data-toggle="modal" data-target="#myModal">Verified Transaction</a>
                </td>
            </tr>
              @empty
              <tr>Ops No Record \Found</tr>
                  
              @endforelse
                <!-- Add more table rows as needed -->
            </tbody>
        </table>
        {{ $transactions->links() }}
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Verify Transaction</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('carmake/verification') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="transaction_id">Transaction Id</label>
                                <input type="text" class="form-control" id="transaction_Id" name="transaction_id">
                            </div>
                       
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End -->

    </div>
</div>
