<x-user-layout title="Chat">
    <style>
        .chat-list-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .chat-list-item:hover {
            background-color: #f1f1f1;
        }
        .chat-list-item.active {
            background-color: rgb(236, 236, 236);
        }
        .chat-box {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
            background-color: #f1f1f1;
        }
        .chat-message {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        .chat-message.sent {
            align-items: flex-end;
        }
        .chat-message .message {
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            position: relative;
            max-width: 70%;
        }
        .chat-message.sent .message {
            background-color: #d4edda;
        }
        .chat-message.received .message::before {
            content: '';
            position: absolute;
            top: 10px;
            left: -10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent #fff transparent transparent;
        }
        .chat-message.sent .message::before {
            content: '';
            position: absolute;
            top: 10px;
            right: -10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent transparent #d4edda;
        }
        .chat-message .message small {
            display: block;
            margin-top: 5px;
            font-size: 0.8em;
            color: #888;
            text-align: right;
        }
        .chat-input {
            border-top: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
        }
        .chat-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
    </style>

    <div class="container">

        
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
            <!-- Sidebar -->
            <div class="col-md-3 border-end">
                <div class="p-3">
                    <div class="chat-list">
                        @forelse($chats as $chatItem)
                            <a href="{{ route('chat', ['chat' => $chatItem->id]) }}" class="text-decoration-none">
                                <div class="chat-list-item {{ $currentChat == $chatItem->id ? 'active' : '' }}">
                                    <strong>{{ $chatItem->business->name }}</strong>
                                    <p class="text-muted small mb-0">{{ $chatItem->latest_conversation }}</p>
                                    <small>{{ $chatItem->updated_at }}</small>
                                </div>
                            </a>
                        @empty
                            <div class="chat-list-item">No chat found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Chat Content -->
            <div class="col-md-9">
                <div class="card">
                    <!-- Conversation Header -->
                    <div class="chat-header mt-2 d-flex justify-content-between align-items-center">
                        <a href="{{ route('business', ['business' => $chat->business->slug]) }}"><h6>{{ $chat->business->name }}</h6></a>
                        <form action="{{ route('chat.delete', ['chat' => $chat->id]) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Do you want to delete the chat?')" class="btn">
                                <i class="bi bi-trash-fill text-danger"></i>
                            </button>
                        </form>
                    </div>

                    <div class="chat-box">
                        <!-- Display conversation messages -->
                        @forelse($chat->conversations as $conversation)
                            <div class="chat-message {{ $conversation->sender == Auth::user()->role->title ? 'sent' : 'received' }}">
                                <div class="message">
                                    <p class="mb-1">{{ $conversation->message }}</p>
                                    <small>{{ $conversation->created_at }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="message">No conversations found.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Input -->
                <form action="{{ route('conversation.new', ['chat' => $chat->id]) }}" method="POST">
                    @csrf
                    <div class="chat-input">
                        <div class="input-group">
                                <input type="text" class="form-control" placeholder="Write a message" name="message" autocomplete="off">
                                <button class="btn btn-primary ml-2" type="submit">Send</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-user-layout>
