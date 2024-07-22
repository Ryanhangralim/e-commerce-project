<x-auth-layout title="Forgot password">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col">
                        @session('status')
                            <div class="alert alert-success col-lg-12" role="alert">
                                {{ $value }}
                            </div>
                        @endsession
                        <div class="p-5">
                            <!-- Forgot Password Form -->
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Forgot Your Password?</h1>
                            </div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="ForgotPasswordEmail"
                                        placeholder="Enter Email Address" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button class="btn btn-warning btn-user btn-block" type="submit">
                                    Send Password Reset Link
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
