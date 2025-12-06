<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="/">Home</a>
            <a href="/">Groups & Brach</a>
            <a href="/">Item Type, Size, Category</a>
            <a href="/">Tax Setup</a>
            @if (Auth::check())
                <a href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
        </nav>
    </header>
    <main>

    </main>
</body>

</html>