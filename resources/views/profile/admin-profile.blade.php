<x-admin-dashboard-layout>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">User Profile</h6>
        </div>
        <div class="card-body">
            {{-- <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"> --}}
                @csrf
                <div class="row mb-3">
                    <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>
                    <div class="col-md-6">
                        <input type="text" id="username" class="form-control" name="username" value="{{ $user->username }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>
                    <div class="col-md-6">
                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $user->first_name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>
                    <div class="col-md-6">
                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $user->last_name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                    <p class="col-md-4 col-form-label text-md-end">{{ $user->email }}</p>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                    <p class="col-md-4 col-form-label text-md-end">{{ $user->phone_number }}</p>
                </div>
                {{-- <div class="row mb-3">
                    <label for="shop_name" class="col-md-4 col-form-label text-md-end">Business Name</label>
                    <div class="col-md-6">
                        <input type="text" id="shop_name" class="form-control" name="shop_name" value="{{ $user->business->name }}">
                    </div>
                </div> --}}
                {{-- <div class="row mb-3">
                    <label for="profile_picture" class="col-md-4 col-form-label text-md-end">Profil Gambar</label>
                    <div class="col-md-6">
                        <input type="file" id="profile_picture" class="form-control" name="profile_picture">
                        <div class="mt-3"> --}}
                            {{-- @if ($user->profile_picture)
                                <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="Profile Picture" class="img-thumbnail" width="100">
                            @else
                                <img src="{{ asset('images/profile/default.png') }}" alt="Profile Picture" class="img-thumbnail" width="100">
                            @endif --}}
                        {{-- </div>
                        <small class="form-text text-muted">Ukuran gambar: maks. 1 MB, Format gambar: .JPEG, .PNG</small>
                    </div>
                </div> --}}
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout>