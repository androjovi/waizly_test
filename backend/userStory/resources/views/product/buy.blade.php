@extends('layouts.scaffold')

@section('main')
@include('partials.messages')
<h2 class="mt-2">Buy product</h2>
    <div class="row mt-3">
        
        <div class="col-md-3" style="border-color:red;">
                <img src="{{ url('storage/images/'. $product->image_product) }}" class="rounded" width=90% hieght=100%>
                <h5 class="mt-2">{{ $product->name_product }}</h5>
                <p>{{ $product->description_product }}</p>
        </div>
        <div class="col-md-9">
            <form action="{{ route('order.buyPerformProduct') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <div class="form-group">
                  <label>Price</label>
                  <p>{{ Helper::formattedCurrency($product->price_product) }}</p>
                </div>
                <div class="form-group">
                    <label>Quantity</label> <br>
                    <input type="number" id="qty" class="form-control" name="qty" placeholder="Quantity" value="1" min=1 max=99>
                </div>
                <div class="form-group">
                    <label>Total Price</label>
                    <p id="total_price">{{ Helper::formattedCurrency($product->price_product) }}</p>
                  </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure to buy product?')">Submit</button>
              </form>
        </div>
    <div>
@stop

@section('otherjs')
<script>
    $("#qty").change(function(){
        price = {{$product->price_product}}
        totaled = price * $(this).val()

        $("#total_price").html( "Rp "+totaled.toLocaleString('id-ID') )
    })
</script>
@stop