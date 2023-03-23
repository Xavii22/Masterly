@extends('layouts.app')

@section('title', 'Mail page')

@section('content')     
    <form class="form">
        <h1>Hello!</h1>
        <p>Please click the button below to verify your email address</p>
        <p><input class="button button--blue" type="submit" value="verifyEmail"></p>
        <p>If you're already logged in, no actions are required</p>
    </form>
    
@endsection

