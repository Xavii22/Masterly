@extends('layouts.app')

@section('title', 'Chat')

@section('content')
    @include('layouts.header')
    <main class="chat-parent">
        <aside class="chat-info">

        </aside>
        <section class="chat">
            @foreach ($chatMessages as $chat)
                @if (($chat->type == 'B' && $userType == 'B') || ($chat->type == 'S' && $userType == 'S'))
                    <div class="chat__message chat__message--user">
                        {{ $chat->message }}
                    </div>
                @else
                    <div class="chat__message chat__message--other">
                        {{ $chat->message }}
                    </div>
                @endif
            @endforeach
        </section>
        <aside class="chat-info">
            <form method="POST" action="{{ route('pages.chat') }}" class="chat-info__input">
                @csrf
                <input type="hidden" name="type" value="{{ $userType }}">
                <input type="hidden" name="orderId" value="{{ $orderId }}">
                <input class="chat-info__text" type="text" placeholder="Escribe un mensaje" name="message" autofocus>
                <div>
                    <input type="submit" value="" class="chat-button">
                    <img src="{{ asset('images/send.png') }}" class="chat-button__image">
                </div>
            </form>
        </aside>
    </main>
    @include('layouts.footer')
@endsection
