<h3>Registration</h3>

<form action="{{ route('register.custom') }}" method="POST">
    @csrf
    
    <br/><input type="text" name="name">

    @if ($errors->has('name'))
    <b>{{ $errors->first('name') }}<b>
    @endif

    <br/><input type="text" placeholder="Email" id="email_address" name="email">
    @if ($errors->has('email'))
    <b>{{ $errors->first('email') }}</b>
    @endif

    <br/><input type="password" placeholder="Password" id="password" name="password" required>
    @if ($errors->has('password'))
        <b>{{ $errors->first('password') }}</b>
    @endif
    
    <br/><button type="submit">Sign up</button>

</form>