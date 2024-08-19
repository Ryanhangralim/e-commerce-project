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
    <div class="container mt-4">
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
                            <div class="card-body pt-0">
                                @foreach($transaction->orders as $order)
                                    <div class="row px-3 py-2 align-items-center">
                                        <div class="col-12 col-md-6 mb-2 mb-md-0">
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
                                        <div class="col-6 col-md-3 mb-2 mb-md-0">x{{ $order->quantity }}</div>
                                        <div class="col-6 col-md-3 mb-2 mb-md-0">Rp. {{ formatNumber($order->total_price) }}</div>
                                    </div>
                                    <hr class="mb-0 mt-0">
                                    {{-- @if(!$loop->last)
                                    @endif --}}
                                @endforeach
                                <div class="row px-3 py-2 align-items-center">
                                    <div class="col text-left">
                                        <strong>Last Updated: </strong> {{ $transaction->updated_at }}
                                    </div>
                                    <div class="col text-right">
                                        <strong>Total price:</strong> Rp. {{ formatNumber($transaction->total_price) }}
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        @empty
                            <div class="card-header">No transactions found.</div>
                        @endforelse
                    </div>
            </div>
        </div>
    </div>
</x-user-layout>
