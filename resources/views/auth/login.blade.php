<h3>Login</h3>
<form method="POST" action="{{ route('login.custom') }}">
    @csrf
    <br/><input type="text" placeholder="Email" id="email" name="email" required autofocus>
    <br/><input type="password" placeholder="Password" id="password" name="password" required>

    @if ($errors->has('emailPassword'))
            {{ $errors->first('emailPassword') }}
    @endif
    
    <br/><input type="checkbox" name="remember"> Remember Me
    <br/><button type="submit" >Signin</button>
</form>