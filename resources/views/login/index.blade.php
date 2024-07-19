<x-layout>
    @section('title')
    <title>Login Page</title>
    @endsection

    
    <div class="container">
      <!-- Outer Row -->
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <div class="col">
                  @session('success')
                  <div class="alert alert-success col-lg-12" role="alert">
                      {{ $value }}
                  </div>
                  @endsession
                  @session('failed')
                  <div class="alert alert-danger col-lg-12" role="alert">
                      {{ $value }}
                  </div>
                  @endsession
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    </div>
                    <form class="user" action="{{ route('authenticate') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <input
                          type="email"
                          class="form-control form-control-user"
                          id="InputEmail"
                          aria-describedby="emailHelp"
                          placeholder="Enter Email Address..."
                          name="email"
                          required
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="password"
                          class="form-control form-control-user"
                          id="InputPassword"
                          placeholder="Password"
                          name="password"
                          required
                        />
                      </div>
                      <button
                        class="btn btn-primary btn-user btn-block"
                      >
                        Login
                      </button>
                    </form>
                    <hr />
                    <div class="text-center">
                      <a class="small" href="#"
                        >Forgot Password?</a
                      >
                    </div>
                    <div class="text-center">
                      <a class="small" href="{{ route('register') }}"
                        >Create an Account!</a
                      >
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

    @section('script')
    @endsection
</x-layout>