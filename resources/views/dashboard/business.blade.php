<x-dashboard-layout title="Business Table">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection


    <div class="row justify-content-end">
        <a id="generateReportButton" href="#" class="btn btn-primary mb-1">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Business Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="businessTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($businesses as $business)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $business->user->id }}</td>
                                <td>{{ $business->user->username }}</td>
                                <td>{{ $business->name }}</td>
                                <td>{{ $business->description }}</td>
                                <td>{{ $business->created_at }}</td>
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
            $('#businessTable').DataTable();
        });
    </script>
    
    @endsection
</x-dashboard-layout>