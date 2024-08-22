<x-dashboard-layout title="Transactions">
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

    {{-- Alert/flash message --}}
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    {{-- Navigation buttons --}}
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active btn-table text-primary" id="showAll" data-status="all" href="#">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showPending" data-status="pending" href="#">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showProcessing" data-status="processing" href="#">Processing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showDelivered" data-status="delivered" href="#">Delivered</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showReceived" data-status="received" href="#">Received</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showCompleted" data-status="completed" href="#">Completed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-table text-primary" id="showCanceled" data-status="canceled" href="#">Canceled</a>
        </li>
    </ul>

    <!-- Table start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaction Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="transactionTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>ID</th>
                            <th>User Name</th>
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

    {{-- Table for script --}}
    <script type="text/javascript">
        $('document').ready(function(){
            // $('#transactionTable').DataTable();
            var table = $('#transactionTable').DataTable();

            // script for populating data
            function loadTableData(status) {
                $.ajax({
                    url: '{{ route('transaction-dashboard.fetch-transactions') }}',
                    type: 'GET',
                    data: { status: status },
                    timeout: 5000,
                    success: function(data) {
                        table.clear().draw();
                        if(data.transactions && data.transactions.length > 0){
                            $.each(data.transactions, function(index, transaction) {
                                var date = new Date(transaction.created_at);
                                var formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
                                var actions = '<a class="btn btn-primary" href="' + '{{ route('transaction-dashboard.view-detail', ['transaction' => ':id']) }}'.replace(':id', transaction.id) + '"><i class="bi bi-eye"></i> Details</a>';

                                table.row.add([
                                    index + 1,
                                    formattedDate,
                                    transaction.id,
                                    transaction.user.username,
                                    transaction.status,
                                    actions
                                ]).draw(false);
                            });
                        }},
                    error: function(xhr, status, error) {
                        if (xhr.status === 200 && (!data || !data.transactions || data.transactions.length === 0)) {
                        // Do nothing, it's just empty data
                        } else {
                            alert('Failed to fetch data');
                        }
                    }
                });
            }

            loadTableData('all');

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