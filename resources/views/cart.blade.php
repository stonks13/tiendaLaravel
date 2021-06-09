@extends('layout')

@section('title', 'Cart')

@section('content')

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Producto</th>
            <th style="width:10%">Precio</th>
            <th style="width:8%">Cantidad</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>

        <?php $total = 0 ?>

        @if(session('cart'))

            @foreach(session('cart') as $id => $details)

                <?php $total += $details['precio'] * $details['cantidad'];
                $products = App\Models\Product::find($id);
                ?>

                <tr>
                    <td >
                        <div class="row">
                            <div class="col-sm-3">
                                {{--        <img src="data:image/jpeg;base64,{!! stream_get_contents($product->image) !!}"/>--}}
                                <img src="data:image/jpeg;base64,{!!  stream_get_contents($products->image) !!}" width="100" height="100" class="img-responsive"/>
                            </div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['nombre'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $details['precio'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['cantidad'] }}" class="form-control quantity" />
                    </td>
                    <td data-th="Subtotal" class="text-center">{{ $details['precio'] * $details['cantidad'] }}</td>
                    <td class="actions" data-th="">
                        <button class="update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                        <button class="remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
        <tfoot>

        <tr>
            <td><a href="{{ url('/products') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
            <!--<td><a href="{{ url('/ventas') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Venta</a></td>-->
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Total {{ $total }}€</strong></td>
        </tr>
        </tfoot>
    </table>

@endsection


@section('scripts')


    <script type="text/javascript">

        $(".update-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('update-cart') }}',
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {

            e.preventDefault();
            var ele = $(this);

            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.href = "/cart";
                    }
                });
            }
        });

    </script>

@endsection
