@extends("layouts.default")

@section("title", "Product List")

@section("content")

    <main class="container" style="max-width: 900px;">
        <section>
               <img src="{{  $product->image}}" 
                            class="card-img-top" alt="{{ $product->title }}" width="100%">
            <h1>{{ $product->title }}</h1>
            <p>${{ $product->price }}</p>
            <p>{{ $product->description }}</p>
            <a href="#" class="btn btn-success">Add to Cart</a>
        </section>
    </main>
@endsection