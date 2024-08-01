<x-form-layout title="Seller Application Form">
    <style>
        .no-border-radius {
            border-radius: 0!important;
        }
    </style>
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Enter Business Details!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('application-form') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user @error('business_name') is-invalid @enderror" value="{{ old('business_name') }}" id="businessName"
                                        placeholder="Business Name" name="business_name">
                                    @error('business_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control form-control-user @error('business_description') is-invalid @enderror no-border-radius" id="businessDescription"
                                        placeholder="Business Description" name="business_description" rows="5">{{ old('business_description') }}</textarea>
                                    @error('business_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-user btn-block">
                                    Apply
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-form-layout>
