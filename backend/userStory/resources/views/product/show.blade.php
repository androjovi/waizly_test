@extends('layouts.scaffold')

@section('main')
@include('partials.messages')
<div class="mt-3">
    <div class="row">
        @if(count($product) <= 0)
            No one product showing, ask administrator to adding some product
        @endif

        @foreach($product as $val)
        <div class="col-md-3 ml-3 mt-2">
            <div class="card" style="width: 18rem;">
                <img src="{{ ($val->image_product ?? 0) ? url('storage/images/'. $val->image_product) : url('storage/images/no_image_product.png') }}" class="card-img-top" alt="" width=50% height=150px>
                <div class="card-body">
                <h5 class="card-title">{{ $val->name_product }}</h5>
                <p class="text-muted">{{ Helper::formattedCurrency($val->price_product) }}</p>
                <p class="card-text">{{ strlen($val->description_product) > 85 ? substr($val->description_product,0, 85). ' ...' : $val->description_product }}</p>
                <a href="{{ route("order.buyProduct", [$val->id]) }}" class="btn btn-primary">Buy</a>
                <!-- <a href="{{ route("product.editProduct", [$val->id]) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route("product.deletePerformProduct", [$val->id]) }}" class="btn btn-danger">Delete</a> -->
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <hr>
    {{ $product->links('pagination::bootstrap-4') }}
</div>
@stop