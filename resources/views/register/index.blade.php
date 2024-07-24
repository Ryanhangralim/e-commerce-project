<x-auth-layout title="Register Page">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('add_new_user') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" id="FirstName"
                                            placeholder="First Name" name="first_name">
                                        @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" id="LastName"
                                            placeholder="Last Name" name="last_name">
                                        @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" value="{{ old('email') }}" id="InputEmail"
                                        placeholder="Email Address" name="email">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" id="InputPhone"
                                        placeholder="Phone Number" name="phone_number">
                                        @error('phone_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" value="{{ old('password') }}"
                                            id="InputPassword" placeholder="Password" name="password">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="RepeatPassword" placeholder="Repeat Password" name="password_confirmation">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-auth-layout>