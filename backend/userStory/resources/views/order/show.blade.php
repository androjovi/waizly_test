@extends('layouts.scaffold')

@section('main')
@include('partials.messages')
<div class="mt-3">
    @if(count($order) <= 0)
            Nothing order, buy some product
    @else
    <a href="{{ route('order.exportOrder', ['csv']) }}" class="btn btn-primary btn-sm">Save to CSV</a>
    <a href="{{ route('order.exportOrder', ['xls']) }}" class="btn btn-primary btn-sm">Save to Excel</a>
    <hr>
    <div class="list-group">
        @foreach($order as $val)
        <div class="list-group-item list-group-item-action mb-3">
            <a class="text-decoration-none text-dark">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $val->product->name_product }}</h5>
                @if($val->paid == 1)
                    <small>Paid | Order Date: {{ $val->created_at }}</small>
                @else
                    @if($val->status == 1)
                        <small>Cancelled | Order Date: {{ $val->created_at }}</small>
                    @else
                        <small> Not Paid | Order Date: {{ $val->created_at }}</small>
                    @endif
                @endif
            </div>
            <p class="mb-1">{{ $val->product->description_product }}</p>
            <small>Quantity {{ $val->qty }}, Price {{  Helper::formattedCurrency($val->total_price) }}</small>
            <hr>
            @if($val->status == 0 && $val->paid == 0)
            
            <a class="btn btn-primary btn-sm" href="{{ route('order.payPerformProduct', [$val->id]) }}" onclick="return confirm('Are you sure to pay?')" href="">Pay</a>
            <a class="btn btn-danger btn-sm" href="{{ route('order.cancelPerformProduct', [$val->id]) }}" onclick="return confirm('Are you sure to cancel order?')" href="">Cancel</a>
            @else
                @if($val->paid == 1)
                <b>PAID</b>
                @else
                <b>CANCEL</b>
                @endif
            @endif
            </a>
        </div>
        @endforeach
      </div>
      <hr>
      {{ $order->links('pagination::bootstrap-4') }}
      @endif
</div>
@stop