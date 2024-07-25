<x-dashboard-layout title="Seller Application Table">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
                    <div class="d-flex justify-content-end">
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

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <!-- DataTales Example -->
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
                            <th>Application ID</th>
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
                            <th>Application ID</th>
                            <th>User Name</th>
                            <th>Business Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $application->id }}</td>
                            <td>{{ $application->user->first_name }} {{ $application->user->last_name }}</td>
                            <td>{{ $application->business_name }}</td>
                            <td>{{ $application->created_at }}</td>
                            <td>{{ $application->application_status }}</td>
                            <td>                                
                                <button type="button" id="viewDetailsBtn" class="btn btn-primary view-details" data-detail="{{ $application }}" data-verify-route={{ route('dashboard.verify-seller') }} data-reject-route={{ route('dashboard.reject-seller') }}>
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> Details
                                </button>
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

    {{-- Script for detail modal --}}
    <script>
        $(document).ready(function() {
            $('.view-details').on('click', function(){
                var data = $(this).data('detail');
                var verifyRoute = $(this).data('verify-route');
                var rejectRoute = $(this).data('reject-route');

                var date = new Date(data.created_at);
                var formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                $('#userName').text('User Name: ' + data.user.first_name + ' ' + data.user.last_name);
                $('#userEmail').text('Email: ' + data.user.email);
                $('#phoneNumber').text('Phone Number: ' + data.user.phone_number);
                $('#businessName').text('Business Name: ' + data.business_name);
                $('#businessDescription').text('Business Description: ' + data.business_description);
                $('#applicationDate').text('Date: ' + formattedDate);
                $('#applicationStatus').text('Status: ' + data.application_status);
                
                $('#viewDetailsModal').modal('show');
                $('#verifyApplicationID').val(data.id);
                $('#rejectApplicationID').val(data.id);
                $('#verifyForm').attr('action', verifyRoute);
                $('#rejectForm').attr('action', rejectRoute);
            });
        });
    </script>

    {{-- Table for script --}}
    <script type="text/javascript">
        $('document').ready(function(){
            $('#sellerApplicationTable').DataTable();
        });
    </script>
    @endsection
</x-dashboard-layout>