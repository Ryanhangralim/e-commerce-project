<x-dashboard-layout title="Transaction Detail">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection


    <div class="row justify-content-between align-items-center  mb-3">
        <div class="col-auto">
            <a href="{{ route('transaction-dashboard.view') }}" class="btn btn-primary "><i class="bi bi-arrow-return-left"></i> Back</a>
        </div>
        <div class="col-auto">
            <a id="generateReportButton" href="#" class="btn btn-primary">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Transaction data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="businessTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->created_at }}</td>
                            <td>{{ $transaction->user->username }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>Rp. {{ formatNumber($transaction->total_price) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Orders Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="orderTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($transaction->orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if ( $order->product->image )
                                <td><img src="{{ asset($product_picture_path . $order->product->image) }}" alt="Product Picture" class="img-profile" width="50"></td>
                            @else
                                <td>No Image</td>
                            @endif 
                            <td>{{ $order->product->name }}</td>
                            <td>Rp. {{ formatNumber($order->price) }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>Rp. {{ formatNumber($order->total_price) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#orderTable').DataTable();
        });
    </script>
    
    @endsection
</x-dashboard-layout>