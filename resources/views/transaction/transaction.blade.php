<x-user-layout title="Transaction List">
    <style>
        .badge-status {
            padding: 0.5em 1em;
            border-radius: 0.5em;
            color: #fff;
            font-size: 0.9em;
        }

        .badge-status.pending {
            background-color: #ffc107;
        }

        .badge-status.processing {
            background-color: #17a2b8;
        }

        .badge-status.delivered {
            background-color: #28a745;
        }

        .badge-status.received {
            background-color: #6f42c1;
        }

        .badge-status.completed {
            background-color: #007bff;
        }

        .badge-status.canceled {
            background-color: #dc3545;
        }

    </style>

    <!-- Add reply modal -->
    <div class="modal fade" id="reply-modal" tabindex="-1" aria-labelledby="replyModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="review-content" class="mb-3"></div>
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('transaction.add-review') }}" id="replyForm" class="mx-auto">
                                @csrf
                                <input type="hidden" name="product_id" id="product-id">
                                <input type="hidden" name="order_id" id="order-id">
                                <label for="rating">Rating ★</label>
                                <div class="form-group">
                                    <input id="rating" type="number" name="rating" class="form-control" required min="1" max="5" value="5">
                                </div>
                                <label for="content">Review Message</label>
                                <div class="form-group">
                                    <input id="content" type="text" name="content" class="form-control">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" id="modalButton">Add Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        {{-- Add alerts --}}
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

        <div class="row">
            <!-- Sidebar for Transaction Statuses -->
            <div class="col-sm-3">
                <div class="list-group">
                    <a href="{{ route('transaction.view', ['type' => 'all']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'all' ? 'active' : '' }}">
                        All Transactions ({{ $transaction_count['all'] }})
                    </a>
                    <a href="{{ route('transaction.view', ['type' => 'pending']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'pending' ? 'active' : '' }}">
                        Pending ({{ $transaction_count['pending'] }})
                    </a>
                    <a href="{{ route('transaction.view', ['type' => 'processing']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'processing' ? 'active' : '' }}">
                        Processing ({{ $transaction_count['processing'] }})
                    </a>
                    <a href="{{ route('transaction.view', ['type' => 'delivered']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'delivered' ? 'active' : '' }}">
                        Delivered ({{ $transaction_count['delivered'] }})
                    </a>
                    <a href="{{ route('transaction.view', ['type' => 'received']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'received' ? 'active' : '' }}">
                        Received ({{ $transaction_count['received'] }})
                    </a>
                    <a href="{{ route('transaction.view', ['type' => 'completed']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'completed' ? 'active' : '' }}">
                        Completed ({{ $transaction_count['completed'] }})
                    </a>
                    <a href="{{ route('transaction.view', ['type' => 'canceled']) }}" 
                       class="list-group-item list-group-item-action {{ $currentType == 'canceled' ? 'active' : '' }}">
                        Canceled ({{ $transaction_count['canceled'] }})
                    </a>
                </div>
            </div>

            <!-- Main Content for Transactions -->
            <div class="col-sm-9">
                    <div class="card-header">
                        {{ ucfirst($currentType) }} Transactions ({{ $transaction_count[$currentType] }})
                    </div>
                        @forelse($transactions as $transaction)
                        <div class="card my-2 mb-3">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <div>{{ $transaction->business->name }}</div>
                                <div>
                                    <span class="badge badge-status {{ strtolower($transaction->status) }}">
                                        {{ $transaction->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-2">
                                @foreach($transaction->orders as $order)
                                    {{-- Check if transaction is completed --}}
                                    @if( $transaction->status === "completed" )
                                        <div class="row px-3 py-2 align-items-center">
                                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-primary">
                                                        @if($order->product->image)
                                                            <img class="img-profile" src="{{ asset($product_picture_path . $order->product->image) }}" alt="{{ $order->product->name }} image" width="50">
                                                        @else
                                                            <img class="img-profile" src="{{ asset($product_picture_path . 'default.jpg') }}" alt="{{ $order->product->name }} image" width="50">
                                                        @endif
                                                    </div>
                                                    <div class="ml-3">
                                                        <a href="{{ route('product.customer-product-detail', ['product' => $order->product->slug]) }}" class="text-secondary">
                                                            {{ $order->product->name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 mb-2 mb-md-0">Quantity: {{ $order->quantity }}</div>
                                            <div class="col-6 col-md-3 mb-2 mb-md-0">Rp. {{ formatNumber($order->total_price) }}</div>
                                            @if( !$order->isReviewed() )
                                            <div class="col-6 col-md-2 mb-2 mb-md-9">
                                                    <button class="btn btn-primary add-review" data-product="{{ $order->product->name }}" data-order-id="{{ $order->id }}" data-product-id="{{ $order->product->id }}">Review</button>
                                            </div>
                                            @else
                                                <div class="col-6 col-md-2 mb-2 mb-md-9">Product Reviewed</div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="row px-3 py-2 align-items-center">
                                            <div class="col-12 col-md-5 mb-2 mb-md-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-primary">
                                                        @if($order->product->image)
                                                            <img class="img-profile" src="{{ asset($product_picture_path . $order->product->image) }}" alt="{{ $order->product->name }} image" width="50">
                                                        @else
                                                            <img class="img-profile" src="{{ asset($product_picture_path . 'default.jpg') }}" alt="{{ $order->product->name }} image" width="50">
                                                        @endif
                                                    </div>
                                                    <div class="ml-3">
                                                        <a href="{{ route('product.customer-product-detail', ['product' => $order->product->slug]) }}" class="text-secondary">
                                                            {{ $order->product->name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 mb-2 mb-md-0">Quantity: {{ $order->quantity }}</div>
                                            <div class="col-6 col-md-3 mb-2 mb-md-0">Rp. {{ formatNumber($order->total_price) }}</div>
                                        </div>
                                    @endif
                                    <hr class="mb-0 mt-0">
                                    @endforeach
                                    <div class="row px-3 py-2 align-items-center">
                                        <div class="col text-left">
                                            <strong>Last Updated: </strong> {{ $transaction->updated_at }}
                                        </div>
                                        <div class="col text-right">
                                            <strong>Total price:</strong> Rp. {{ formatNumber($transaction->total_price) }}
                                        </div>
                                    </div>
                                    @if( $transaction->status === "received")
                                        <hr class="mb-0 mt-0">
                                        <form action="{{ route('transaction.complete-transaction') }}" method="POST">
                                            @csrf
                                            <div class="row px-3 pt-2 align-items-center">
                                                <div class="col text-right">
                                                    <input type="hidden" value="{{ $transaction->id }}" name="transaction_id">
                                                    <input type="hidden" value="completed" name="action">
                                                    <button class="btn btn-primary" type="submit" onclick="return confirm('Do you want to complete the transaction?');"><i class="bi bi-check-lg"></i> Transaction Done</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                            </div>
                        </div>                        
                        @empty
                            <div class="card-header">No transactions found.</div>
                        @endforelse
                    </div>
            </div>
        </div>
    </div>

    {{-- Script for modal --}}
    <script>
        $(document).ready(function(){
            @error("content")
                alert("{{ $message }}");
            @enderror

            $(document).on('click', '.add-review', function(){
                var data = $(this).data('product');
                var orderId = $(this).data('order-id');
                var productId = $(this).data('product-id');

                $('#reply-modal').modal('show');
                $('#review-content').text("Product : " + data);
                $('#order-id').val(orderId);
                $('#product-id').val(productId);
            });
        });
    </script>
</x-user-layout>
