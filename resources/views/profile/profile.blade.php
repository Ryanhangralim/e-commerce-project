<x-user-layout title="Profile">
    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">User Profile</h6>
            </div>
            <div class="card-body">
                    <div class="row mb-3">
                        <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>
                        <div class="col-md-6">
                            <input type="text" id="username" class="form-control" name="username" value="{{ $user->username }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>
                        <div class="col-md-6">
                            <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $user->first_name }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>
                        <div class="col-md-6">
                            <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $user->last_name }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                        <div class="col-md-6">
                            <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
                            @if($user->email_verified_at)
                                <small class="text-primary">Verified</small>
                            @else
                                <small>Not verified! <a href="{{ route('verification.notice') }}">Verify Now</a></small>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                        <div class="col-md-6">
                            <input type="text" id="phone_number" class="form-control" name="phone_number" value="{{ $user->phone_number }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="role" class="col-md-4 col-form-label text-md-end">Role</label>
                        <div class="col-md-6">
                            <input type="text" id="role" class="form-control" name="role" value="{{ $user->role->title }}" disabled>
                        </div>
                    </div>
                    @role('seller')
                    <div class="row mb-3">
                        <label for="business_name" class="col-md-4 col-form-label text-md-end">Business Name</label>
                        <div class="col-md-6">
                            <input type="text" id="business_name" class="form-control" name="business_name" value="{{ $user->business->name }}" disabled>
                        </div>
                    </div>
                    @endrole
                <form action="{{ route('profile.update-profile-picture') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="profile_picture" class="col-md-4 col-form-label text-md-end">Profile Picture</label>
                        <div class="col-md-6">
                            <input type="file" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror " name="profile_picture">
                            @error('profile_picture')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="mt-3">
                                @if ( Auth()->user()->profile_picture )
                                    <img src="{{ asset($profile_picture_path . Auth()->user()->profile_picture) }}" alt="Profile Picture" class="img-profile rounded-circle" width="100">
                                @else
                                    <img src="{{ asset($profile_picture_path . 'default.jpg') }}" alt="Profile Picture" class="img-profile rounded-circle" width="100">
                                @endif 
                            </div>
                            <small class="form-text text-muted">File size: max. 1 MB, Image format: .JPEG, .PNG</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Save Profile Picture</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-user-layout>