<x-user-layout title="{{ $business->name }}">
    <style>
        .container-fluid {
            padding: 0;
        }
        .store-info-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px; /* Adjust the gap to control the spacing between the elements */
        }
        .store-logo {
            width: 100px;
            height: 100px;
            background-color: #ddd; /* Placeholder color */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            border-radius: 50%;
            overflow: hidden;
        }
        .store-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .store-details {
            text-align: left;
        }
        .store-name {
            font-size: 2rem;
            font-weight: bold;
        }
        .store-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .store-stats {
            text-align: left;
        }
        .store-stats .stat {
            margin-bottom: 10px;
            font-size: 1rem;
        }
        .store-stats .stat-value {
            font-weight: bold;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .product-card {
            width: 12rem;
        }
        .search-bar {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .search-bar input {
            width: 50%;
            max-width: 500px;
        }
        .search-bar button {
            margin-left: 10px;
        }
        a:hover {
            text-decoration: none; /* Ensures the underline is not shown on hover */
        }
    </style>

    <div class="container">
        <!-- Store Info -->
        <div class="store-info-container">
            <div class="store-logo">
                @if($business->image)
                    <img src="{{ asset($business_profile_path . $business->image) }}" alt="Store Image">
                @else
                    <img src="{{ asset($business_profile_path . 'default.jpg') }}" alt="Store Image">
                @endif
            </div>
            <div class="store-details">
                <div class="store-name text-primary">{{ $business->name }}</div>
                <form action="{{ route('chat.new') }}" method="POST">
                    @csrf
                    <input type="hidden" name="business_id" value="{{ $business->id }}">
                    <button type="submit" class="btn btn-primary">Chat</button>
                </form>
            </div>
            <div class="store-stats">
                <div class="stat">Products: <span class="stat-value text-primary">{{ count($business->products) }}</span></div>
                <div class="stat">Rating: <span class="stat-value text-primary">{{ number_format($business->reviews()->avg('rating'), 2, '.', '.') }} ({{ count($business->reviews) }} Reviews)</span></div>
            </div>
        </div>
        
        <!-- Search Bar -->
        <form action="{{ route('business', ['business' => $business->slug]) }}" method="GET">
            <div class="row search-bar">
                <input type="text" class="form-control col-md" placeholder="Search in this store" name="business-search" autocomplete="off" value="{{ request('business-search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        

        <!-- Products Grid -->
        <div class="row product-grid p-0 px-lg-5">
            @if($products->count())
                @foreach($products as $product)
                <a href="{{ route('product.customer-product-detail', ['product' => $product->slug]) }}">
                    <div class="card product-card">
                        @if($product->image)
                            <img src="{{ asset($product_picture_path . $product->image) }}" class="card-img-top" alt="{{ $product->name }} Image">
                        @else
                            <img src="{{ asset($product_picture_path . 'default.jpg') }}" class="card-img-top" alt="No Image Available">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $product->brand }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">Rp. {{ formatNumber(calculateDiscount($product)) }}</h6>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <p class="text-center fs-4">No product found</p>         
            @endif
        </div>
        <!-- Add Pagination Links -->
        <div class="mt-3">
            {{ $products->links() }}
        </div>    
    </div>
</x-user-layout>
