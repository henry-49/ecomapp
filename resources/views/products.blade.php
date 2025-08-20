@extends("layouts.default")

@section("title", "Product List")

@section("content")

    <main class="container" style="max-width: 900px;">
        <h1>Product List</h1>
        <section>
            <div class="row">
                @if($products->isEmpty())
                <p>No products available.</p>
            @else
                @foreach($products as $product)
                <div class="col-12 col-md-6 col-lg-3 m-1 p-2">
                    <div class="card p-2 shadow-sm">
                            <img src="{{  $product->image}}" 
                            class="card-img-top" alt="{{ $product->title }}" width="100%">
                        <a href="{{ route('product.details', ['slug' => $product->slug]) }}"><p>{{ $product->title }}</p></a>
                        <span>Price: ${{ $product->price }}</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div>
            {{ $products->links() }}
        </div>
        </section>
    </main>
@endsection