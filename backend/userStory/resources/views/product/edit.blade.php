
@section('main')

    @include('partials.messages')
    <h2 class="mt-2">Adding product</h2>
    <div class="row mt-3">
        
        <div class="col-md-12">
            <form class="" action=" {{ route('product.makeProduct') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                  <label>Code Product</label>
                  <input type="text" class="form-control" name="code_product" placeholder="Your Code" value="[AUTO]" readonly>
                </div>
                <div class="form-group">
                    <label>Name Product</label>
                    <input type="text" class="form-control" name="name_product" placeholder="Place your name product here" value="">
                </div>
                <div class="form-group">
                    <label>Description Product</label>
                    <textarea class="form-control" name="description_product" placeholder="Place your description here" rows=8></textarea>
                </div>
                <div class="form-group">
                    <label>Price Product (Rp)</label>
                    <input type="text" class="form-control" name="price_product" placeholder="Price" value="">
                </div>
                <div class="form-group">
                    <label>Photo Product</label> <br>
                    <img src="" class="rounded" width=30% hieght=30%>
                    <input type="file" class="form-control mt-3" name="image_product" accept="image/jpeg, image/png, image/jpg">>
                </div>
                <button class="btn btn-primary mx-auto d-block mt-1">Submit</button>
              </form>
        </div>
    <div>

@stop