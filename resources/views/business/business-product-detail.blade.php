<x-user-layout title="{{ $product->name }} - {{ $product->business->name }}">
    <style>
        /* Custom CSS for the page */
        .product-image {
            width: 100%;
            height: auto;
        }

        .badge-custom {
            background-color: #ff6f61;
            color: white;
            font-weight: bold;
        }

        .quantity-input {
            width: 35px !important; /* Ensure width is small */
            height: 30px !important; /* Ensure height matches width */
            text-align: center !important; /* Center text horizontally */
            padding: 0 !important; /* Remove default padding */
            font-size: 14px; /* Adjust font size to fit */
            border-radius: 0; /* Remove border radius to avoid stretching */
            border: 1px solid #ced4da; /* Optional: Define border for better visibility */
        }

        .input-group .btn {
            height: 30px; /* Match the height of the input */
            width: 30px;  /* Make buttons square */
            padding: 0;
            font-size: 14px; /* Ensure font size matches input */
        }
        
        .input-group {
            display: flex; /* Ensure flex display */
            align-items: center; /* Align items vertically */
        }

        .input-group input[type="number"] {
            display: inline-block; /* Prevent stretching */
            flex: 0 0 auto; /* Prevent growing */
            width: 30px; /* Match input width */
        }

        .quantity-input-group .btn {
            padding: 0.375rem 0.75rem;
        }

        .product-details {
            font-size: 14px;
        }

        .price-discount {
            text-decoration: line-through;
            color: #888;
        }

        .price-current {
            font-size: 24px;
        }

        .seller-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .seller-info {
            font-size: 14px;
        }

        .seller-info h5 {
            font-size: 16px;
            margin-bottom: 0.5rem;
        }

        .seller-image {
            width: 70px;
            height: 70px;
        }

        .seller-info-container {
            display: flex;
            align-items: center;
        }

        .seller-info-text {
            margin-left: 15px;
        }
        .spec-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        }

        .spec-item strong {
            min-width: 100px;
            margin-right: 20px;
        }
    </style>

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

<div class="container mt-2">
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
    {{-- Product main --}}
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="row mt-2">
                    <!-- Product Image -->
                    <div class="col-md-5">
                        @if($product->image)
                            <img src="{{ asset($product_picture_path . $product->image) }}" alt="{{ $product->name }} Image" class="product-image img-fluid">
                        @else 
                            <img src="{{ asset($product_picture_path . 'default.jpg') }}" alt="No Image Available" class="product-image img-fluid">
                        @endif

                    </div>
        
                    <!-- Product Details -->
                    <div class="col-md-7">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        <div class="product-rating mb-3">
                            <span class="badge bg-warning text-dark">5.0</span>
                            <span class="text-muted">0 Reviews | {{ $product->sold }} Sold</span>
                        </div>
                        @if($product->discount > 0)
                            <p>
                                <span class="price-discount">Rp. {{ formatNumber($product->price) }}</span>
                                <span class="price-current text-primary">Rp. {{ formatNumber(calculateDiscount($product)) }}</span>
                                <span class="badge bg-primary text-white">{{ $product->discount }}% OFF</span>
                            </p>
                        @else
                            <p>
                                <span class="price-current text-primary">Rp. {{ formatNumber($product->price) }}</span>
                            </p>
                        @endif
        
                        <form action="{{ route('cart.add-product', ['product' => $product]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <div class="input-group quantity-input-group">
                                    <button class="btn bg-primary btn-sm text-white" type="button" onclick="updateQuantity(-1)">-</button>
                                    <input type="number" name="quantity" id="quantity" class="form-control quantity-input" value="1" min="1" readonly>
                                    <button class="btn bg-primary btn-sm text-white" type="button" onclick="updateQuantity(1)">+</button>
                                </div>
                                <small class="text-muted">{{ $product->stock }} left</small>
                            </div>
                            <div class="d-grid gap-2 d-md-block {{ $product->stock == 0 ? 'disabled' : '' }}">
                                @if( $product->stock == 0 )
                                    <h5 class="text-danger">Out of Stock!</h5>
                                @endif
                                <button class="btn btn-primary"  {{ $product->stock == 0 ? 'disabled' : '' }}>Add To Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller Details -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="seller-details mt-4">
                    <div class="row">
                        <!-- Column 1: Seller Image and Info -->
                        <div class="col-md-4">
                            <div class="seller-info-container">
                                @if( $business->image)
                                    <img src="{{ asset($business_profile_path . $business->image) }}" alt="Seller Image" class="rounded-circle seller-image">
                                @else
                                    <img src="{{ asset($business_profile_path . 'default.jpg') }}" alt="Seller Image" class="rounded-circle seller-image">
                                @endif
                                <div class="seller-info-text">
                                    <h5>{{ $business->name }}</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Column 2: Seller Information -->
                        <div class="col-md-4">
                            <div class="seller-info">
                                <p>Rating: 875</p>
                                <p>Products: {{ count($business->products) }}</p>
                            </div>
                        </div>
                        <!-- Column 3: Action Buttons -->
                        <div class="col-md-4 text-center">
                            <button class="btn btn-outline-primary btn-sm w-100 mb-2">Chat</button>
                            <a href="{{ route('business', ['business' => $business->slug ]) }}" class="btn btn-outline-secondary btn-sm w-100">Visit Store</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Specifications -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="product-specifications mt-4">
                    <h4><strong>Product Specification</strong></h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex">
                            <strong class="col-md-3">Category:</strong> 
                            <span class="col-md-9">{{ $product->category->name }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <strong class="col-md-3">Stock:</strong> 
                            <span class="col-md-9">{{ $product->stock }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <strong class="col-md-3">Brand:</strong> 
                            <span class="col-md-9">{{ $product->brand }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product Reviews -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="product-specifications mt-4">
                    <h4 class="mb-3"><strong>Reviews ({{ count($product->reviews) }}) </strong></h4>
                     
                    {{-- Review card --}}
                        @foreach($reviews as $review)
                        <div class="card mb-2 position-relative">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if ($review->user->profile_picture)
                                            <img src="{{ asset($profile_picture_path . $review->user->profile_picture) }}" alt="Profile Picture" class="rounded-circle mr-3" width="50">
                                        @else
                                            <img src="{{ asset($profile_picture_path . 'default.jpg') }}" alt="Profile Picture" class="rounded-circle mr-3" width="50">
                                        @endif 
                                        <div>
                                            <h6 class="mb-0">{{ $review->user->username }}</h6>
                                            <h6 class="text-warning mb-0">{{ printRating($review->rating) }}</h6>
                                            <small class="text-muted">{{ $review->created_at }}</small>
                                        </div>
                                    </div>
                                    {{-- Check if business owner and no reply yet --}}
                                    @if(isBusinessOwner($product->business->user_id) && !$review->seller_reply) 
                                        <div>   
                                            <button type="button" class="btn btn-link text-muted text-gray-500 reply-review p-0" 
                                                data-route="{{ route('review.add-reply', ['review' => $review]) }}" 
                                                data-review="{{ json_encode($review) }}">
                                                <i class="fas fa-reply text-gray-500"></i> Reply
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @if ($review->content)
                                    <p class="mt-3">{{ $review->content }}</p>
                                @endif
                                @if ($review->seller_reply)
                                    <div class="bg-gray-200 p-3 mt-3"> {{-- Add padding here --}}
                                        <strong class="text-gray-800">Seller Reply:</strong>
                                        <p class="text-gray-800 mb-0">{{ $review->seller_reply }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach

                </div>
                <!-- Add Pagination Links -->
                <div>
                    {{ ($reviews->links()) }}
                </div> 
            </div>
        </div>

    <script>
        // Update quantity function
        function updateQuantity(amount) {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var newQuantity = currentQuantity + amount;

            if (newQuantity >= 1 && newQuantity <= {{ $product->stock }}) {
                quantityInput.value = newQuantity;
            }
        }
    </script>
    {{-- Script for modal --}}
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
</x-user-layout>
