<title>Welcome</title>
<p>Welcome to project, {{ Auth()->user()->first_name }} {{ Auth()->user()->last_name }} !</p>
@role('customer')
    <p>THIS IS ONLY VISIBLE FOR CUSTOMER</p>
    <a href="{{ route('apply-seller') }}"><button>Apply Seller</button></a>
@endrole
<p></p>
@role('seller')
    <p>THIS IS ONLY VISIBLE FOR SELLER</p>
@endrole
@role('admin')
    <p>THIS IS ONLY VISIBLE FOR ADMIN</p>
@endrole
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>