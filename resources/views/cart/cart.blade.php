<x-user-layout title="Cart">
    <div class="container-lg">
        
        @if(count($carts) > 0)
            <div class="card mb-2">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-6 col-md-4 font-weight-bold">Product</div>
                        <div class="col-6 col-md-2 font-weight-bold">Price</div>
                        <div class="col-6 col-md-2 font-weight-bold">Quantity</div>
                        <div class="col-6 col-md-2 font-weight-bold">Total</div>
                        <div class="col-6 col-md-2 font-weight-bold">Action</div>
                    </div>
                </div>
            </div>
            {{-- Product card --}}
            @foreach($carts as $cart)
            {{-- Product header --}}
            <div class="card mb-3">
                <div class="card-body py-2">
                    <h5 class="card-title">{{ $cart[0]->product->business->name }}</h5>
                </div>
                @foreach($cart as $cart_product)
                    {{-- Product content --}}
                    <hr class="mb-0 mt-0">
                    <div class="row px-3 py-2 align-items-center">
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary">
                                    @if($cart_product->product->image)
                                        <img class="img-profile" src="{{ asset($product_picture_path . $cart_product->product->image) }}" alt="{{ $cart_product->product->name }} image" width="50">
                                    @else
                                        <img class="img-profile" src="{{ asset($product_picture_path . 'default.jpg') }}" alt="{{ $cart_product->product->name }} image" width="50">
                                    @endif
                                </div>
                                <div class="ml-3">
                                    {{ $cart_product->product->name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-2 mb-2 mb-md-0">Rp. {{ number_format($cart_product->product->price, 0, ',', '.') }}</div>
                        <div class="col-6 col-md-2 mb-2 mb-md-0">{{ $cart_product->quantity }}</div>
                        <div class="col-6 col-md-2 mb-2 mb-md-0">Rp. {{ number_format($cart_product->product->price * $cart_product->quantity, 0, ',', '.') }}</div>
                        <div class="col-6 col-md-2">Action</div>
                    </div>
                @endforeach
            </div>
            @endforeach
        @else
            <div class="text-center">
                <h3>No Items In Cart</h3>
            </div>
        @endif
    </div>
</x-user-layout>
