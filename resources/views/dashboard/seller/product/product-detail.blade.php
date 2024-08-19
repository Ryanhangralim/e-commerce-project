<x-dashboard-layout title="Product Detail">

    @section('css')
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection

    <!-- Add reply modal -->
    <div class="modal fade" id="reply-modal" tabindex="-1" aria-labelledby="replyModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Review Reply</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="review-content" class="mb-3"></div>
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" id="replyForm" class="mx-auto">
                                @csrf
                                <label for="name">Reply Message</label>
                                <div class="form-group">
                                    <input id="seller_reply" type="text" name="seller_reply" class="form-control" required>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" id="modalButton">Reply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession
    <div class="mb-2">
        <a href="{{ route('view-product') }}" class="btn btn-primary "><i class="bi bi-arrow-return-left"></i> Back</a>
        <a href="{{ route('product.edit-product', ['product' => $product->slug]) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Product Detail</h6>
                </div>
                <div class="card-body">
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Name</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->name }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Description</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->description }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Brand</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->brand }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Category</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->category->name }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Price</label>
                            <p class="col-md-9 col-form-label text-md-end">: Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Discount</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->discount }}%</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Items sold</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->sold }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Stock</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ $product->stock }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Review</label>
                            <p class="col-md-9 col-form-label text-md-end">: {{ count($product->reviews) }}</p>
                        </div>
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label text-md-end">Image</label>
                            @if ( $product->image )
                                <img src="{{ asset($product_picture_path . $product->image) }}" alt="Product Picture" class="img-profile" width="100">
                            @else
                                <p class="col-md-9 col-form-label text-md-end">: No Image</p>
                            @endif                             
                        </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Add Stock</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.add-stock', ['product' => $product->slug]) }}" method="POST">
                        @csrf
                            <div class="form-group">
                                <label for="numberOfProducts" class="form-label text-right">Number of product:</label>
                                <input type="number" class="form-control @error('numberOfProducts') is-invalid @enderror" id="numberOfProducts"
                                    name="numberOfProducts" required value="{{ old('numberOfProducts', 1) }}">
                                @error('numberOfProducts')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary ml-auto">
                                    <i class="bi bi-plus"></i>
                                    Add Stock</button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Set discount</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.set-discount', ['product' => $product->slug]) }}" method="POST">
                        @csrf
                            <div class="form-group">
                                <label for="discount" class="form-label text-right">Total discount:</label>
                                <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                                    name="discount" required value="{{ old('discount', $product->discount) }}">
                                @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary ml-auto">
                                    <i class="bi bi-percent"></i>
                                    Set Discount</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Table Start -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Reviews ({{ count($product->reviews) }})</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="reviewtable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Reply</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Reply</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review->created_at }}</td>
                            <td>{{ $review->user->username }}</td>
                            <td>
                                <span class="text-warning">{{ printRating($review->rating) }}</span> ({{ $review->rating }})
                            </td>                                                        <td>{{ $review->content }}</td>
                            <td>{{ $review->seller_reply ? $review->seller_reply : 'No Reply Yet' }}</td>
                            @if( $review->seller_reply )
                                <td>Replied</td>
                            @else 
                                @if(isBusinessOwner($product->business->user_id) && !$review->seller_reply) 
                                    <td>
                                        <button type="button" class="btn btn-primary reply-review" 
                                            data-route="{{ route('review.add-reply', ['review' => $review]) }}" 
                                            data-review="{{ json_encode($review) }}">
                                            <i class="fas fa-reply"></i> Reply
                                        </button>
                                    </td>
                                @else
                                    <td>No Action</td>
                                @endif
                            @endif
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
            $('#reviewtable').DataTable();
        });
    </script>
    {{-- Reply modal --}}
    <script>
        $(document).ready(function(){
            @error("seller_reply")
                alert("{{ $message }}");
            @enderror

            $(document).on('click', '.reply-review', function(){
                var data = $(this).data('review');
                var route = $(this).data('route');

                $('#reply-modal').modal('show');
                $('#review-content').text("Review Message : " + data.content);
                $('#replyForm').attr('action', route);
            });
        });
    </script>
    @endsection

    
</x-dashboard-layout>