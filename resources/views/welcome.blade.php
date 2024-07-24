<title>Welcome</title>
<p>Welcome to project, {{ Auth()->user()->first_name }} {{ Auth()->user()->last_name }} !</p>
@role('customer')
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <p>THIS IS ONLY VISIBLE FOR CUSTOMER</p>
    <a href="{{ route('apply-seller') }}"><button>Apply Seller</button></a>
    @endrole
    <p></p>
    @role('seller')
    <p>THIS IS ONLY VISIBLE FOR SELLER</p>
    @endrole
    @role('admin')
    <p>THIS IS ONLY VISIBLE FOR ADMIN</p>
    <a href="{{ route('dashboard') }}"><button>Dashboard</button></a>
    <p></p>
@endrole
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>