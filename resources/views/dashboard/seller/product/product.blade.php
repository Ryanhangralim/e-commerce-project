<x-dashboard-layout title="Product Table">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection

    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession

    @session('error')
    <div class="alert alert-danger col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession

    <div class="row justify-content-end mb-3">
        <div class="col-auto">
            <a id="generateReportButton" href="{{ route('product.generate-product-report') }}" class="btn btn-primary mb-1">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Product Table</h6>
            <a href="{{ route('product.new-product') }}" class="btn btn-info"><i class="bi bi-plus"></i> New Product</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Items Sold</th>
                            <th>Review</th>
                            <th>Price</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Items Sold</th>
                            <th>Review</th>
                            <th>Price</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('product.customer-product-detail', ['product' => $product->slug]) }}">{{ $product->name }}</a></td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->sold }}</td>
                                <td>{{ count($product->reviews) }}</td>
                                <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <div class="d-inline-flex flex-wrap" style="gap: 0.25rem">
                                        <div class="flex-grow-1">
                                            <a href="{{ route('product.detail', ['product' => $product->slug]) }}"
                                                class="btn btn-primary"><i class="bi bi-info-circle"></i>
                                                Detail</a>
                                        </div>
                                    </div>
                                </td>
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