<x-layout>
    @section('title')
        <title>Email Verification</title>
    @endsection

<body>
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success col-lg-12" role="alert">
                        A new verification link has been sent to your email address.
                    </div>
                @endif
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Email Verification Required</h1>
                            </div>
                            <hr>
                            <div class="text-center">
                                Before proceeding, please check your email for a verification link.
                                If you did not receive the email, 
                                <form id="resend-verification-form" action="{{ route('verification.send') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: #007bff; text-decoration: underline; cursor: pointer; padding: 0;">
                                        click here to request another
                                    </button>
                                </form>.
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</x-layout>
