<x-dashboard-layout title="Category Table">
    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection

    <!-- Add/Edit category modal -->
    <div class="modal fade" id="category-modal" tabindex="-1" aria-labelledby="categoryModal" aria-hidden="true" @if ($errors->any()) style="display: block;" @endif>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" id="categoryForm" class="mx-auto">
                                @csrf
                                <input type="hidden" id="categoryId" name="categoryId" value="{{ old('categoryId') }}">
                                <input type="hidden" id="actionType" name="actionType" value="{{ old('actionType') }}">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" id="modalButton"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success col-lg-12" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Category Table</h6>
            <button class="btn btn-info" id="newCategoryButton" type="button" data-route="{{ route('dashboard.new-category') }}"><i class="bi bi-plus"></i> New Category</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="categoryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button type="button" id="editCategoryBtn" class="btn btn-warning edit-category" data-category="{{ json_encode($category) }}" data-route="{{ route('dashboard.update-category') }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </td>
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

    {{-- Script for modal --}}
    <script>
        function addCategory() {
            var route = $(this).data('route');

            $('#modalLabel').text('Add Category');
            $('#modalButton').text('Add');
            $('#actionType').val('add');
            $('#categoryId').val('');
            $('#name').val('');
            $('#categoryForm').attr('action', route);
            clearValidationErrors();
            $('#category-modal').modal('show');
        }

        function editCategory() {
            var route = $(this).data('route');
            var category = $(this).data('category');

            $('#modalLabel').text('Edit Category');
            $('#modalButton').text('Edit');
            $('#actionType').val('edit');
            $('#categoryId').val(category.id);
            $('#name').val(category.name);
            $('#categoryForm').attr('action', route);
            clearValidationErrors();
            $('#category-modal').modal('show');
        }

        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        $(document).ready(function() {
            $(document).on('click', '#newCategoryButton', addCategory);
            $(document).on('click', '.edit-category', editCategory);

            @if ($errors->any())
                var actionType = '{{ old('actionType') }}';
                if (actionType === 'edit') {
                    var categoryId = '{{ old('categoryId') }}';
                    var categoryName = '{{ old('name') }}';
                    var route = '{{ route('dashboard.update-category') }}';
                    $('#modalLabel').text('Edit Category');
                    $('#modalButton').text('Edit');
                    $('#categoryId').val(categoryId);
                    $('#name').val(categoryName);
                    $('#categoryForm').attr('action', route);
                } else {
                    $('#modalLabel').text('Add Category');
                    $('#modalButton').text('Add');
                    $('#categoryForm').attr('action', '{{ route('dashboard.new-category') }}');
                }
                $('#category-modal').modal('show');
            @endif
        });
    </script>

    {{-- Script for table --}}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#categoryTable').DataTable();
        });
    </script>
    
    @endsection
</x-dashboard-layout>
