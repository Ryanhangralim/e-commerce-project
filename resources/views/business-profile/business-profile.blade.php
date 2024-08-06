<x-dashboard-layout title="Business Profile">
    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Business Profile</h6>
        </div>
        <div class="card-body">
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Business Name</label>
                    <div class="col-md-6">
                        <input type="text" id="name" class="form-control" name="name" value="{{ $business->name }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" disabled>{{ $business->description }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="created_at" class="col-md-4 col-form-label text-md-end">Created At</label>
                    <div class="col-md-6">
                        <input type="text" id="created_at" class="form-control" name="created_at" value="{{ $business->created_at }}" disabled>
                    </div>
                </div>
            <form action="{{ route('business-profile.update-profile-picture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="business_profile_picture" class="col-md-4 col-form-label text-md-end">Business Profile Picture</label>
                    <div class="col-md-6">
                        <input type="file" id="business_profile_picture" class="form-control @error('business_profile_picture') is-invalid @enderror " name="business_profile_picture">
                        @error('business_profile_picture')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="mt-3">
                            @if ( $business->image )
                                <img src="{{ asset($directory_path . $business->image) }}" alt="Business Profile Picture" class="img-profile rounded-circle" width="100">
                            @else
                                <img src="{{ asset($directory_path . 'default.jpg') }}" alt="Business Profile Picture" class="img-profile rounded-circle" width="100">
                            @endif 
                        </div>
                        <small class="form-text text-muted">File size: max. 1 MB, Image format: .JPEG, .PNG</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save Business Profile Picture</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>