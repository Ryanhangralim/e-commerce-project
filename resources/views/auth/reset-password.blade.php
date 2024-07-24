<x-form-layout title="Reset Password">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col">
                        <div class="p-5">
                            <!-- Forgot Password Form -->
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                            </div>
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                {{-- Hidden input --}}
                                <input type="hidden" name="token" value="{{ request('token') }}">
                                <input type="hidden" name="email" value="{{ request('email') }}">
                                
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" value="{{ old('password') }}"
                                        id="InputPassword" placeholder="Password" name="password">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        id="RepeatPassword" placeholder="Repeat Password" name="password_confirmation">
                                </div>
                                <button class="btn btn-warning btn-user btn-block" type="submit">
                                    Reset Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-form-layout>
