<x-user-layout title="Chat">
    <style>
        .chat-list-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .chat-list-item:hover {
            background-color: #f8f9fa;
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
        }
        .chat-message.sent {
            justify-content: flex-end;
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
        .chat-input {
            border-top: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
        }
        .chat-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
    </style>
    

    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 border-end">
                <div class="p-3">
                    <div class="chat-list">
                        <!-- Chat List Item -->
                        <div class="chat-list-item">
                            <strong>san...uemnn...</strong>
                            <p class="text-muted small">Barang masih dalam...</p>
                        </div>
                        <div class="chat-list-item">
                            <strong>everpure</strong>
                            <p class="text-muted small">Super Beauty Day...</p>
                        </div>
                        <!-- Add more chat items as needed -->
                    </div>
                </div>
            </div>

            <!-- Chat Content -->
            <div class="col-md-9">
                <div class="card">
                    <!-- Conversation Header -->
                    <div class="chat-header mt-2">
                        <h6>robotofficialshop.id</h6>
                    </div>

                    <div class="chat-box">

                        <!-- Received Message -->
                        <div class="chat-message received">
                            <div class="message">
                                <p>Kami akan segera mengirimkan paket...</p>
                            </div>
                        </div>
                        <div class="chat-message received">
                            <div class="message">
                                <p>Kami akan segera mengirimkan paket...</p>
                            </div>
                        </div>
                        <div class="chat-message received">
                            <div class="message">
                                <p>Kami akan segera mengirimkan paket...</p>
                            </div>
                        </div>
                        <div class="chat-message received">
                            <div class="message">
                                <p>Kami akan segera mengirimkan paket...</p>
                            </div>
                        </div>
                        <div class="chat-message received">
                            <div class="message">
                                <p>Kami akan segera mengirimkan paket...</p>
                            </div>
                        </div>
                        <div class="chat-message received">
                            <div class="message">
                                <p>Kami akan segera mengirimkan paket...</p>
                            </div>
                        </div>

                        <!-- Sent Message -->
                        <div class="chat-message sent">
                            <div class="message">
                                <p>Thank you! I'm looking forward to it.</p>
                            </div>
                        </div>
                        <div class="chat-message sent">
                            <div class="message">
                                <p>Thank you! I'm looking forward to it.</p>
                            </div>
                        </div>
                        <div class="chat-message sent">
                            <div class="message">
                                <p>Thank you! I'm looking forward to it.</p>
                            </div>
                        </div>
                        <div class="chat-message sent">
                            <div class="message">
                                <p>Thank you! I'm looking forward to it.</p>
                            </div>
                        </div>
                        <div class="chat-message sent">
                            <div class="message">
                                <p>Thank you! I'm looking forward to it.</p>
                            </div>
                        </div>

                        <!-- Add more messages as needed -->
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="chat-input">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Write a message">
                        <button class="btn btn-primary ml-2" type="button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
