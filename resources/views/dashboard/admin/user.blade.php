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
                background-color: #fff;
                border-color: #dee2e6 #dee2e6 #fff;
                border-bottom-color: transparent;
            }

            .hidden {
                display: none !important;
            }
        </style>
    @endsection

    <!-- Edit role modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRoleForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <h6 id="username"></h6>
                            <input type="hidden" name="user_id" id="user_id">
                            <label for="role_id">Role</label>
                            <select class="form-control col-lg mb-3" name="role_id" id="role_id">
                                <option value="1">Customer</option>
                                <option value="2">Seller</option>
                                <option value="3">Admin</option>
                        </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mb-4">Edit Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession

    <div class="row justify-content-end">
        <div class="col-auto">
            <a id="generateReportButton" href="{{ route('dashboard.generate-user-report', ['role' => 'all']) }}" class="btn btn-primary mb-1">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
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
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Action</th>
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

    <script>
        $(document).ready(function(){
            $(document).on('click', '.update-role', function(){
                var data = $(this).data('user');
                var route = $(this).data('route');

                $('#editRoleModal').modal('show');
                $('#username').text("User Name: " + data.first_name + ' ' + data.last_name);
                $('#user_id').val(data.id);
                $('#role_id').val(data.role_id);
                $('#editRoleForm').attr('action', route);
            });
        });
    </script>

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
                                var actions = '<button type="button" class="btn btn-primary update-role" data-route="' + '{{ route("dashboard.update-role") }}' + '" data-user=\'' + JSON.stringify(user) + '\' ><i class="bi bi-person-fill" aria-hidden="true"></i> Update Role</button>';

                                table.row.add([
                                    index + 1,
                                    user.id,
                                    user.username,
                                    user.email,
                                    user.phone_number,
                                    user.role.title,
                                    actions
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