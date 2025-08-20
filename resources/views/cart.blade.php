@extends("layouts.default")

@section("title", "Ecommerce Cart")

@section("content")

    <main class="container" style="max-width: 900px;">
        <h1>Your Cart</h1>
        <section>
            <div class="row">
                @if($cartItems->isEmpty())
                    <p>No products available.</p>
                    @else
                    @foreach($cartItems as $item)
                        <div class="col-12">

                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                    <img src="{{  $item->image}}" class="img-fluid rounded-start" alt="{{ $item->title }}">
                                    </div>
                                    <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="{{ route('product.details', ['slug' => $item->slug]) }}"><p>{{ $item->title }}</p></a></h5>
                                        <p class="card-text">Price: ${{ $item->price }}</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endif
            </div>
            <div>
                {{ $cartItems->links() }}
            </div>
        </section>
    </main>
@endsection