

<x-layout>
    <x-slot name="title">
        Login
    </x-slot>

    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember Me</label>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</x-layout>
