<x-user-layout title="Cart">
    <style>
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

    </style>

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
                    <h6 class="card-title my-0">{{ $cart[0]->product->business->name }}</h6>
                </div>
                @foreach($cart as $cart_product)
                    {{-- Product content --}}
                    <hr class="mb-0 mt-0 cart-product-{{ $cart_product->id }}">
                    <div class="row px-3 py-2 align-items-center cart-product-{{ $cart_product->id }}">
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
                        <div class="col-6 col-md-2 mb-2 mb-md-0">
                            <div class="input-group">
                                <button class="btn bg-primary btn-sm text-white" type="button" onclick="updateQuantity('{{ $cart_product->id }}', -1)">-</button>
                                <input type="number" class="form-control quantity-input" id="quantity-{{ $cart_product->id }}" value="{{ $cart_product->quantity }}" readonly>
                                <button class="btn bg-primary btn-sm text-white" type="button" onclick="updateQuantity('{{ $cart_product->id }}', 1)">+</button>
                            </div>
                        </div>                        
                        <div class="col-6 col-md-2 mb-2 mb-md-0" id="total-{{ $cart_product->id }}">Rp. {{ number_format($cart_product->product->price * $cart_product->quantity, 0, ',', '.') }}</div>                        
                        <button class="btn btn-danger" type="button" onclick="deleteProduct('{{ $cart_product->id }}')"><i class="bi bi-trash"></i> Delete</button>
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

    <script>
        // Update quantity function
        function updateQuantity(cartProductId, change) {
            const quantityInput = document.getElementById(`quantity-${cartProductId}`);
            let newQuantity = parseInt(quantityInput.value) + change;

            if (newQuantity < 1) {
                newQuantity = 1;
            }

            // Update quantity input field
            quantityInput.value = newQuantity;

            // Make an AJAX request to update the quantity in the backend
            fetch(`{{ route('cart.update-quantity') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_product_id: cartProductId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the total price in the UI & Alert
                    document.getElementById(`total-${cartProductId}`).innerHTML = `Rp. ${data.newTotalFormatted}`;
                    document.getElementById(`alert-quantity-${cartProductId}`).innerHTML = `Quantity: ${newQuantity}`;
                } else {
                    alert('Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        // Delete product
        function deleteProduct(cartProductId) {
            // Make an AJAX request to delete the product
            fetch(`{{ route('cart.delete-product') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_product_id: cartProductId
                })
            })
            .then(response=> response.json())
            .then(data => {
                if (data.success) {
                    // Remove the element from the DOM
                    const productElement = document.querySelectorAll(`cart-product-${cartProductId}`);
                    if (productElement) {
                        // Remove the elements with the specific class
                        const productElements = document.querySelectorAll(`.cart-product-${cartProductId}`);
                        productElements.forEach(element => {
                            element.remove();
                        });
                    }
                    } else {
                        alert('Failed to delete product');
                    }
                })
            .catch(error => {
                console.log('Error:', error);
                alert('An error occurred. Please try again.');
            })
        }
    </script>
</x-user-layout>
