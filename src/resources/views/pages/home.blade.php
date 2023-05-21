@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('layouts.header')
    <main>
        <div class="home">
            <aside class="categories">
                <div class="categories__path">
                    @if ($category != null && $childCategoryName == '')
                        <a href="{{ route('pages.home') }}">Inicio</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $category]) }}">{{ $parentCategoryName }}</a>
                    @elseif ($childCategoryName != '')
                        <a href="{{ route('pages.home') }}">Inicio</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $parentCategory]) }}">{{ $parentCategoryName }}</a>
                        <span>/</span>
                        <a
                            href="{{ route('pages.home', ['query' => $query, 'category' => $category]) }}">{{ $childCategoryName }}</a>
                    @endif
                </div>
                <div class="categories__content">
                    <div class="categories__title">
                        @if ($childCategories != '')
                            <h2>Subcategorias</h2>
                        @else
                            <h2>Categorias</h2>
                        @endif
                    </div>
                    <div class="categories__list">
                        @if ($childCategories != '')
                            @foreach ($childCategories as $childCategory)
                                <div class="category">
                                    <a class="category__content category__text"
                                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $childCategory]) }}">{{ $childCategory->name }}</a>
                                    <img class="categories__icon category__content"
                                        src="{{ asset('images/right-arrow.png') }}">
                                </div>
                            @endforeach
                        @else
                            @foreach ($parentCategories as $parentCategory)
                                <div class="category">
                                    <a class="category__content category__text"
                                        href="{{ route('pages.home', ['query' => $query, 'sort' => 'recent', 'category' => $parentCategory]) }}">{{ $parentCategory->name }}</a>
                                    <img class="categories__icon category__content"
                                        src="{{ asset('images/right-arrow.png') }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </aside>
            <section class="products-parent">
                @if ($products->total() > 0)
                    <div class="products-title">
                        @if ($childCategoryName != null)
                            <h1>{{ $childCategoryName }}</h1>
                        @elseif ($parentCategoryName != null)
                            <h1>{{ $parentCategoryName }}</h1>
                        @else
                            <h1>Artículos</h1>
                        @endif
                    </div>
                @endif
                <div class="products-total">
                    <span class="products-total__number">{{ $products->total() }} artículos</span>
                </div>
                @if ($products->total() > 0)

                {{ $products->appends(['query' => $query, 'sort' => $sort])->links('vendor.pagination.default') }}
            </section>
        </div>
    </main>
    @include('layouts.footer')
    </div>
    <script src="{{ asset('js/storageListener.mjs') }}" type="module"></script>
    <script src="{{ asset('js/categoryLink.js') }}"></script>
@endsection
