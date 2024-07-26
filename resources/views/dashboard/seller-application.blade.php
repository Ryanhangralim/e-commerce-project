<x-dashboard-layout title="Seller Application Table">
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


    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="userName">User Name: </p>
                    <p id="userEmail">Email: </p>
                    <p id="phoneNumber">Phone Number: </p>
                    <p id="businessName">Business Name: </p>
                    <p id="businessDescription">Business Description: </p>
                    <p id="applicationDate">Date: </p>
                    <p id="applicationStatus">Status: </p>
                    <div id="actionButtons" class="d-flex justify-content-end hidden">
                        <form method="POST" id="verifyForm">
                            @csrf
                            <input type="hidden" id="verifyApplicationID" name="applicationID">
                            <button type="submit" class="btn btn-primary">Verify</button>
                        </form>
                        <form method="POST" id="rejectForm">
                            @csrf
                            <input type="hidden" id="rejectApplicationID" name="applicationID">
                            <button type="submit" class="btn btn-danger ml-2">Reject</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- Alert/flash message --}}
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    {{-- Navigation buttons --}}
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active btn-table text-primary" id="showPending" data-status="pending" href="#">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showApproved" data-status="approved" href="#">Approved</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showRejected" data-status="rejected" href="#">Rejected</a>
        </li>
    </ul>

    <!-- Table start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Seller Application Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="sellerApplicationTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Business Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Business Name</th>
                            <th>Date</th>
                            <th>Status</th>
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

    {{-- Script for detail modal --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view-details', function(){
                var data = $(this).data('detail');
                var verifyRoute = $(this).data('verify-route');
                var rejectRoute = $(this).data('reject-route');

                var date = new Date(data.created_at);

                $('#userName').text('User Name: ' + data.user.first_name + ' ' + data.user.last_name);
                $('#userEmail').text('Email: ' + data.user.email);
                $('#phoneNumber').text('Phone Number: ' + data.user.phone_number);
                $('#businessName').text('Business Name: ' + data.business_name);
                $('#businessDescription').text('Business Description: ' + data.business_description);
                $('#applicationDate').text('Date: ' + date);
                $('#applicationStatus').text('Status: ' + data.application_status);
                
                // hide verify and reject button if status is not pending
                if (data.application_status === 'pending') {
                    $('#actionButtons').removeClass('hidden');
                    $('#verifyApplicationID').val(data.id);
                    $('#rejectApplicationID').val(data.id);
                    $('#verifyForm').attr('action', verifyRoute);
                    $('#rejectForm').attr('action', rejectRoute);
                } else {
                    $('#actionButtons').addClass('hidden');
                }

                $('#viewDetailsModal').modal('show');
            });
        });
    </script>

    {{-- Table for script --}}
    <script type="text/javascript">
        $('document').ready(function(){
            // $('#sellerApplicationTable').DataTable();
            var table = $('#sellerApplicationTable').DataTable();

            // script for populating data
            function loadTableData(status) {
                $.ajax({
                    url: '{{ route('dashboard.fetch-application') }}',
                    type: 'GET',
                    data: { status: status },
                    success: function(data) {
                        table.clear().draw();
                        if(data.applications && data.applications.length > 0){
                            $.each(data.applications, function(index, application) {
                                var date = new Date(application.created_at);
                                var formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
                                var actions = '<button type="button" class="btn btn-primary view-details" data-detail=\'' + JSON.stringify(application) + '\' data-verify-route="' + '{{ route("dashboard.verify-seller") }}' + '" data-reject-route="' + '{{ route("dashboard.reject-seller") }}' + '"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</button>';

                                table.row.add([
                                    index + 1,
                                    application.id,
                                    application.user.first_name + ' ' + application.user.last_name,
                                    application.business_name,
                                    formattedDate,
                                    application.application_status,
                                    actions
                                ]).draw(false);
                            });
                        }},
                    error: function(xhr, status, error) {
                        if (xhr.status === 200 && (!data || !data.applications || data.applications.length === 0)) {
                        // Do nothing, it's just empty data
                        } else {
                            alert('Failed to fetch data');
                        }
                    }
                });
            }

            loadTableData('pending');

            $('.btn-table').click(function() {
                $('.btn-table').removeClass('active');
                $(this).addClass('active');
                var status = $(this).data('status');
                loadTableData(status);
            });
        });
    </script>
    @endsection
</x-dashboard-layout>