<x-dashboard-layout title="User Table">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <style>
            .nav-tabs {
                border-bottom: 2px solid #dee2e6;
            }

            .nav-tabs .nav-item {
                margin-bottom: -1px;
            }

            .nav-tabs .nav-link {
                border: 1px solid transparent;
                border-top-left-radius: .25rem;
                border-top-right-radius: .25rem;
                color: #495057;
                background-color: #f8f9fa;
                font-weight: bold;
                padding: .5rem 1rem;
            }

            .nav-tabs .nav-link:hover {
                border-color: #e9ecef #e9ecef #dee2e6;
                background-color: #e9ecef;
            }

            .nav-tabs .nav-link.active {
                color: #495057;
                background-color: #fff;
                border-color: #dee2e6 #dee2e6 #fff;
                border-bottom-color: transparent;
            }

            .hidden {
                display: none !important;
            }
        </style>
    @endsection

    <div class="row justify-content-end">
        <a id="generateReportButton" href="{{ route('dashboard.generate-user-report', ['role' => 'all']) }}" class="btn btn-primary mb-1">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    {{-- Navigation Buttons --}}
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active btn-table text-primary" id="showAll" data-role="all" href="#">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showCustomer" data-role="customer" href="#">Customer</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showSeller" data-role="seller" href="#">Seller</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showAdmin" data-role="admin" href="#">Admin</a>
        </li>
    </ul>

    <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        {{-- Data will be populated by JavaScript --}}
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
            var table = $('#userTable').DataTable();
    
            // Function to update role sent to generate report controller
            function updateGenerateReportButton(role) {
                $('#generateReportButton').attr('href', '{{ route('dashboard.generate-user-report', ['role' => '']) }}' + role);
            }
    
            // Function to load table data
            function loadTableData(role) {
                $.ajax({
                    url: '{{ route('dashboard.fetch-users') }}',
                    type: 'GET',
                    data: { role: role },
                    timeout: 5000,
                    success: function(data) {
                        table.clear().draw();
                        if (data.users && data.users.length > 0) {
                            $.each(data.users, function(index, user) {
                                table.row.add([
                                    index + 1,
                                    user.id,
                                    user.first_name + ' ' + user.last_name,
                                    user.email,
                                    user.phone_number,
                                    user.role.title
                                ]).draw(false);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status !== 200) {
                            alert('Failed to fetch data');
                        }
                    }
                });
            }
    
            // Load at start
            loadTableData('all');
            updateGenerateReportButton('all');
    
            // Update when clicked
            $('.btn-table').click(function() {
                $('.btn-table').removeClass('active');
                $(this).addClass('active');
                var role = $(this).data('role');
                loadTableData(role);
                updateGenerateReportButton(role); 
            });
        });
    </script>
    
    @endsection
</x-dashboard-layout>