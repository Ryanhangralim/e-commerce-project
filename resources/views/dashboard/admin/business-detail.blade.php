<x-dashboard-layout title="Business Detail">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection


    <div class="row justify-content-between align-items-center  mb-3">
        <div class="col-auto">
            <a href="{{ route('dashboard.business') }}" class="btn btn-primary "><i class="bi bi-arrow-return-left"></i> Back</a>
        </div>
        <div class="col-auto">
            <a id="generateReportButton" href="{{ route('dashboard.generate-business-detail-report', ['business' => $business->slug ]) }}" class="btn btn-primary">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Business data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="businessTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Owner</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $business->user->username }}</td>
                            <td>{{ $business->name }}</td>
                            <td>{{ $business->description }}</td>
                            <td>{{ $business->created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Product Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Created At</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($business->products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->brand }}</td>
                            <td>{{ $product->category->name }}</td>
                            @if ( $product->image )
                                <td><img src="{{ asset($product_picture_path . $product->image) }}" alt="Product Picture" class="img-profile" width="50"></td>
                            @else
                                <td>No Image</td>
                            @endif 
                            <td>{{ $product->created_at }}</td>
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
            $('#productTable').DataTable();
        });
    </script>
    
    @endsection
</x-dashboard-layout>