@extends('layouts.scaffold')

@section('main')

    @include('partials.messages')
    <h2 class="mt-2">{{ $title }}</h2>
    <div class="row mt-3">
        
        <div class="col-md-12">
            <form class="" action=" {{ route($action) }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>ID Product</label>
                    <input type="text" class="form-control" name="id" placeholder="Your ID" value="{{ $product->id ?? '[AUTO]' }}" readonly>
                  </div>
                <div class="form-group">
                  <label>Code Product</label>
                  <input type="text" class="form-control" name="code_product" placeholder="Your Code" value="{{ $product->code_product ?? '[AUTO]' }}" readonly>
                </div>
                <div class="form-group">
                    <label>Name Product</label>
                    <input type="text" class="form-control" name="name_product" value="{{ $product->name_product ?? '' }}" placeholder="Place your name product here" value="">
                </div>
                <div class="form-group">
                    <label>Description Product</label>
                    <textarea class="form-control" name="description_product" placeholder="Place your description here" rows=8>{{ $product->description_product ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Price Product (Rp)</label>
                    <input type="text" class="form-control" name="price_product" value="{{ $product->price_product ?? '' }}" placeholder="Price" value="">
                </div>
                <div class="form-group">
                    <label>Photo Product</label> <br>
                    <img src="{{ ($product->image_product ?? 0) ? url('storage/images/'. $product->image_product) : url('storage/images/no_image_product.png') }}" class="rounded" width=30% hieght=30%>
                    <input type="file" class="form-control mt-3" name="image_product" value="{{ $product->image_product ?? '' }}" accept="image/jpeg, image/png, image/jpg">
                </div>
                <button class="btn btn-primary mx-auto d-block mt-1">Submit</button>
              </form>
        </div>
    <div>

@stop