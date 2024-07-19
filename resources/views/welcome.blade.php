<title>Welcome</title>
<p>Welcome to project, {{ Auth()->user()->first_name }} !</p>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>