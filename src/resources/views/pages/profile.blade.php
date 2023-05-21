@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    @include('layouts.header')
    @if (count($pendingOrders) >= 0 && $pendingOrders != null)
        <dialog class="confirm" open>
            <div class="confirm__background">
                <p>Tienes un pedido con id {{ $pendingOrders[0][1][0][2] }} pendiente de confirmar el cual contiene los
                    siguientes productos.</p>
                <form method="GET" action="{{ route('pages.profile') }}">
                    @csrf
                    <input type="hidden" name="pendingOrder" value="{{ $pendingOrders[0][1][0][2] }}">
                    <input type="submit" name="accept" value="Aceptar"
                        class="editor__save editor__save--accept editor__data-save">
                    <input type="submit" name="deny" value="Denegar"
                        class="editor__save editor__save--deny editor__data-save">
                </form>
            </div>
        </dialog>
    @endif
    <main class="editor">
        <form action="{{ route('pages.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="editor__data">
                <h2 class="editor__data-title">Perfil</h2>
                <a class="editor__data-logout" href="{{ route('pages.logout') }}">Logout</a>
                <div class="editor__data__name">
                    <label class="data__logo-name">Nombre</label>
                    <input type="text" class="editor__input editor__data__name-input"
                        placeholder={{ Auth::user()->name }} value="{{ Auth::user()->name }}" name="name">
                </div>
                <div class="editor__data__logo">
                    <label class="editor__data__logo-label">Logo</label>
                    <input type="file" class="editor__input" name="image">
                </div>
                <button type="submit" class="editor__save editor__data-save">Guardar</button>

            </section>
        </form>
        <form action="{{ route('pages.changePassword') }}" method="POST">
            @csrf
            <section class="editor__password">
                <h2 class="editor__password-title">Contraseña</h2>
                <div class="editor__password-content">
                    <label class="password-content__label">Antigua contraseña</label>
                    <label class="password-content__label">Nueva contraseña</label>
                    <label class="password-content__label">Repetir contraseña</label>
                    <input class="editor__input" type="password" name="old_password" id="old_password">
                    <input class="editor__input" type="password" name="new_password" id="new_password">
                    <input class="editor__input" type="password" name="confirm_password" id="confirm_password">
                    <button type="submit" class="editor__save editor__password-save">Guardar</button>
                </div>
            </section>
        </form>
        <section class="editor__historical">
            <h2 class="editor__historical-title">Histórico de pedidos</h2>
            @foreach ($orders as $key => $order)
                <article class="order">
                    <b>Fecha:</b>
                    <span>{{ $order[0] }}</span>

                    <form method="GET" action="{{ route('pages.pdf') }}">
                        @csrf
                        <input type="hidden" name="pdfId" value="{{ $key }}">
                        <input class="editor__save editor__password-save" type="submit"   value="Descargar PDF">
                    </form>

                    @foreach ($order[1] as $orderProducts)
                        <div class="order__vendor">
                            <div>
                                <b>Vendido por:</b>
                                <span>{{ $orderProducts[3] }}</span>
                                <br>
                                @if ($orderProducts[1] == 0)
                                    <i>Pedido pendiente de confirmación por parte del vendedor</i>
                                    <br>
                                @endif
                                @foreach ($orderProducts[0] as $orderProduct)
                                    <div class="order__vendor__product">
                                        <div>
                                            <img src="{{ $orderProduct['image'] }}" class="order__vendor__product-image">
                                        </div>
                                        <div>
                                            <span>{{ $orderProduct['name'] }}</span>
                                            <br>
                                            <span>{{ $orderProduct['price'] }} €</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <form method="GET" action="{{ route('pages.chat') }}">
                                @csrf
                                <input type="hidden" name="userType" value="B">
                                <input type="hidden" name="orderId" value="{{ $orderProducts[2] }}">
                                <input class="editor__save editor__password-save" type="submit" value="Chat">
                                @if ($orderProducts[4] > 0)
                                    <div class="item-link__notification  item-link__notification--profile">
                                        {{ $orderProducts[4] }}</div>
                                @endif
                            </form>
                        </div>
                        @if (!$loop->last)
                            <hr class="order__vendor__separator">
                        @endif
                    @endforeach
                </article>
            @endforeach
            <hr>
            <h3>Pedidos como vendedor</h3>
            @foreach ($sellerOrders as $sellerOrder)
                <article class="order">
                    <b>Fecha:</b>
                    <span>{{ $sellerOrder[0] }}</span>
                    @foreach ($sellerOrder[1] as $sellerOrderProducts)
                        <div class="order__vendor">
                            <div>
                                @foreach ($sellerOrderProducts[0] as $sellerOrderProduct)
                                    <div class="order__vendor__product">
                                        <div>
                                            <img src="{{ $sellerOrderProduct['image'] }}"
                                                class="order__vendor__product-image">
                                        </div>
                                        <div>
                                            <span>{{ $sellerOrderProduct['name'] }}</span>
                                            <br>
                                            <span>{{ $sellerOrderProduct['price'] }} €</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <form method="GET" action="{{ route('pages.chat') }}">
                                @csrf
                                <input type="hidden" name="userType" value="S">
                                <input type="hidden" name="orderId" value="{{ $sellerOrderProducts[2] }}">
                                <input class="editor__save editor__password-save" type="submit" value="Chat">
                                @if ($sellerOrderProducts[4] > 0)
                                    <div class="item-link__notification  item-link__notification--profile">
                                        {{ $sellerOrderProducts[4] }}</div>
                                @endif
                            </form>
                        </div>
                        @if (!$loop->last)
                            <hr class="order__vendor__separator">
                        @endif
                    @endforeach
                </article>
            @endforeach
        </section>

        @if ($storeExists)
            <section class="editor__shop">
                <h2 class="editor__shop-title">Tienda</h2>
                <a type="submit" class="editor__save editor__shop-save">Administrar tienda</a>
            @else
                <form action="{{ route('pages.createStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section class="editor__shop">
                        <h2 class="editor__shop-title">Tienda</h2>

                        <div class="editor__shop-content">
                            <label class="shop-content__label">Nombre tienda</label>
                            <label class="shop-content__label">Logo tienda</label>
                            <input class="editor__input" type="text" name="name">
                            <input type="file" class="editor__input" name="image" id="file-logoShop">
                            <button class="editor__save editor__shop-save">Crear</button>
                        </div>
                </form>
        @endif
        </section>
    </main>
    @include('layouts.footer')

    <script src="{{ asset('js/storageListener.mjs') }}" type="module"></script>
    <script src="{{ asset('js/profileManager.js') }}"></script>
@endsection
