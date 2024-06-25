@extends('layouts')

@section('content')
<h1>Dashboard</h1>

<ul>
  <li><a href="{{ route('signout') }}">Sign Out</a></li>
</ul>  

<h3>Rooms</h3>
<ul>
@foreach ($rooms as $room)
    <a href="{{ route('room', ['roomId' => $room->id ]) }}">{{$room->name}}</a>
@endforeach
</ul>  