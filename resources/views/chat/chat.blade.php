<x-user-layout title="Chat">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6" style="max-width: 500px;">
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

                <div class="card" style="width: 100%;">
                    <div class="card-header">
                        <h5 class="mb-0">Chat List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($chats as $chatItem)
                                <a href="{{ route('chat', $chatItem->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $chatItem->business->name }}</strong>
                                            <p class="text-muted small mb-0 text-truncate">{{ $chatItem->latest_conversation }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="list-group-item text-center text-muted">
                                    No chat found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
