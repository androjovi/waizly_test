@extends('layouts.scaffold')

@section('main')
@include('partials.messages')
<div class="mt-3">
    <h3>List Product</h3>
    @if(count($product) <= 0)
            Nothing product, make some product
    @else
    <hr>
    <div class="list-group">
        @foreach($product as $val)
        <div class="list-group-item list-group-item-action mb-3">
            <a class="text-decoration-none text-dark">
            <div class="d-flex w-100 justify-content-between">
                <span>
                    <img src="{{ ($val->image_product ?? 0) ? url('storage/images/'. $val->image_product) : url('storage/images/no_image_product.png') }}" class="card-img-top" alt="" width=50px height=100px>
                    <h5 class="mb-1">{{ $val->name_product }}</h5>
                </span>
                <small>Created: {{ $val->created_at }}</small>
            </div>
            <p class="mb-1">{{ $val->description_product }}</p>
            <small>{{ Helper::formattedCurrency($val->price_product) }}</small>
            <hr>
            <a href="{{ route("product.editProduct", [$val->id]) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route("product.deletePerformProduct", [$val->id]) }}" class="btn btn-danger">Delete</a>
        </div>
        @endforeach
      </div>
      <hr>
      {{ $product->links('pagination::bootstrap-4') }}
      @endif
</div>
@stop