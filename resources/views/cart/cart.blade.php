<x-user-layout title="Cart">
    <style>
        /* Your existing CSS here */
        .quantity-input {
            width: 35px !important;
            height: 30px !important;
            text-align: center !important;
            padding: 0 !important;
            font-size: 14px;
            border-radius: 0;
            border: 1px solid #ced4da;
        }

        .input-group .btn {
            height: 30px;
            width: 30px;
            padding: 0;
            font-size: 14px;
        }
        
        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group input[type="number"] {
            display: inline-block;
            flex: 0 0 auto;
            width: 30px;
        }

        .checkout {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            border-top: 1px solid #e9ecef;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 15px;
        }

        .checkout .card {
            margin-bottom: 0;
        }

        .checkout .btn-checkout {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout .btn-checkout:hover {
            background-color: #0056b3;
        }

        .content-padding {
            padding-bottom: 80px;
        }
    </style>

    <form id="cart-form" action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <div class="container-lg content-padding">
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
                        <a href="{{ route('business', ['business' => $cart[0]->product->business->slug ]) }}" class="text-secondary"><h6 class="card-title my-0">{{ $cart[0]->product->business->name }}</h6></a>
                        <input type="hidden" id="business_id">
                    </div>
                    @foreach($cart as $cart_product)
                        {{-- Product content --}}
                        <hr class="mb-0 mt-0 cart-product-{{ $cart_product->id }}">
                        <div class="row px-3 py-2 align-items-center cart-product-{{ $cart_product->id }}">
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <div class="form-check mr-2 d-flex align-items-center">
                                        <input class="form-check-input product-checkbox" type="checkbox" id="checkbox-{{ $cart_product->id }}" data-price="{{ calculateDiscount($cart_product->product) }}" data-id="{{ $cart_product->id }}" data-business-id="{{ $cart_product->product->business_id }}">
                                    </div>
                                    <div class="icon-circle bg-primary">
                                        @if($cart_product->product->image)
                                            <img class="img-profile" src="{{ asset($product_picture_path . $cart_product->product->image) }}" alt="{{ $cart_product->product->name }} image" width="50">
                                        @else
                                            <img class="img-profile" src="{{ asset($product_picture_path . 'default.jpg') }}" alt="{{ $cart_product->product->name }} image" width="50">
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('product.customer-product-detail', ['product' => $cart_product->product->slug]) }}" class="text-secondary">{{ $cart_product->product->name }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 mb-2 mb-md-0">Rp. {{ formatNumber(calculateDiscount($cart_product->product)) }}</div>
                            <div class="col-6 col-md-2 mb-2 mb-md-0">
                                <div class="input-group">
                                    <button class="btn bg-primary btn-sm text-white" type="button" onclick="updateQuantity('{{ $cart_product->id }}', -1, '{{ $cart_product->product->stock }}')">-</button>
                                    <input type="number" class="form-control quantity-input" id="quantity-{{ $cart_product->id }}" value="{{ $cart_product->quantity }}" readonly>
                                    <button class="btn bg-primary btn-sm text-white" type="button" onclick="updateQuantity('{{ $cart_product->id }}', 1, '{{ $cart_product->product->stock }}')">+</button>
                                </div>
                                <small>Stock: {{ $cart_product->product->stock }}</small>
                            </div>                        
                            <div class="col-6 col-md-2 mb-2 mb-md-0" id="total-{{ $cart_product->id }}">Rp. {{ formatNumber(calculateDiscount($cart_product->product) * $cart_product->quantity, 0, ',', '.') }}</div>                        
                            <button class="btn btn-danger" type="button" onclick="deleteProduct('{{ $cart_product->id }}')"><i class="bi bi-trash"></i> Delete</button>
                        </div>
                        {{-- <input type="hidden" name="cart_products[{{ $cart_product->id }}]" value="{{ $cart_product->product->id }}"> --}}
                    @endforeach
                </div>
                @endforeach
            @else
                <div class="text-center">
                    <h3>No Items In Cart</h3>
                </div>
            @endif
        </div>

        <!-- Sticky footer -->
        <div class="checkout card">
            <div class="container">
                <div class="row d-flix align-items-center">
                    <div class="col text-left">
                        <h4>Total: <span id="total-amount">Rp. 0</span></h4>
                    </div>
                    <div class="col text-right">
                        <button type="submit" class="btn-checkout bg-primary">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        let selectedBusinessId = null; // Track the business ID of selected products
        const cartForm = document.getElementById('cart-form');
        const checkboxes = document.querySelectorAll('.product-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const businessId = this.getAttribute('data-business-id');

                if (this.checked) {
                    if (!selectedBusinessId) {
                        selectedBusinessId = businessId; // Set the business ID for the first selected product
                        
                        // Add hidden input for the business ID
                        const businessInput = document.createElement('input');
                        businessInput.type = 'hidden';
                        businessInput.name = 'business_id';
                        businessInput.value = businessId;
                        businessInput.id = 'business-id-input';
                        cartForm.appendChild(businessInput);

                    } else if (selectedBusinessId !== businessId) {
                        alert('You can only select products from one business at a time.');
                        this.checked = false;
                        return;
                    }
                } else {
                    // If no products are selected, reset the selectedBusinessId
                    const checkedProducts = document.querySelectorAll('.product-checkbox:checked');
                    if (checkedProducts.length === 0) {
                        selectedBusinessId = null;
                        
                        // Remove the hidden input if all checkboxes are deselected
                        const businessInput = document.getElementById('business-id-input');
                        if (businessInput) {
                            businessInput.remove();
                        }
                    }
                }

                updateTotal();
            });
        });

    cartForm.addEventListener('submit', function (e) {
        const selectedProducts = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedProducts.push(checkbox.getAttribute('data-id'));
            }
        });

        if (selectedProducts.length === 0) {
            e.preventDefault();
            alert('Please select at least one product to checkout.');
            return;
        }

        selectedProducts.forEach(productId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_products[]';
            input.value = productId;
            cartForm.appendChild(input);
        });
    });

    updateTotal(); // Initial total update
});



        function updateTotal() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            let total = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const cartProductId = checkbox.getAttribute('data-id');
                    const quantityElement = document.getElementById(`quantity-${cartProductId}`);
                    const quantity = quantityElement ? parseFloat(quantityElement.value) : 0;
                    const price = parseFloat(checkbox.getAttribute('data-price'));
                    total += (price * quantity);
                }
            });

            document.getElementById('total-amount').textContent = formatNumber(total);
        }

        function formatNumber(number) {
            return number.toLocaleString('id-ID', { 
                style: 'currency', 
                currency: 'IDR', 
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Define the initializeCart function
        function initializeCart() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotal);
            });

            // Initial total update
            updateTotal();
        }

        // Define the updateQuantity function globally
        function updateQuantity(cartProductId, change, stock) {
            const quantityInput = document.getElementById(`quantity-${cartProductId}`);
            let newQuantity = parseInt(quantityInput.value) + change;

            if (newQuantity < 1) {
                newQuantity = 1;
            } else if (newQuantity > stock) {
                newQuantity = stock;
            }

            quantityInput.value = newQuantity;

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
                    document.getElementById(`total-${cartProductId}`).innerHTML = `Rp. ${data.newTotalFormatted}`;
                    updateTotal(); // Call updateTotal after successful quantity update
                } else {
                    alert('Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        // Define the deleteProduct function globally
        function deleteProduct(cartProductId) {
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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const productElements = document.querySelectorAll(`.cart-product-${cartProductId}`);
                    productElements.forEach(element => {
                        element.remove();
                    });

                    document.getElementById(`cart-badge`).innerHTML = data.count;
                    updateTotal(); // Call updateTotal after successful product deletion
                } else {
                    alert('Failed to delete product');
                }
            })
            .catch(error => {
                console.log('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        // Initialize cart on page load
        document.addEventListener('DOMContentLoaded', initializeCart);
    </script>
</x-user-layout>
