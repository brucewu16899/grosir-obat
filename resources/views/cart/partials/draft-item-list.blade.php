<legend>{{ trans('transaction.items') }} <small class="text-muted">({{ $draft->items()->count() }} Item)</small></legend>
<div class="panel panel-default">
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Item</th>
                    <th>Harga Satuan</th>
                    <th>Diskon per Item</th>
                    <th>Qty</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($draft->items() as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ formatRp($item->price) }}</td>
                        {{ Form::open(['route' => ['cart.update-draft-item', $draft->draftKey], 'method' => 'patch']) }}
                        {{ Form::hidden('item_key', $key) }}
                    <td>
                        {{ Form::text('item_discount', $item->item_discount, ['id' => 'item_discount-' . $key, 'style' => 'width:80px;text-align:right']) }}
                    </td>
                    <td>
                        {{ Form::number('qty', $item->qty, ['id' => 'qty-' . $key, 'style' => 'width:50px;text-align:center']) }}
                    </td>
                    <td class="text-right">{{ formatRp($item->subtotal) }}</td>
                        {{ Form::submit('update-item-' . $key, ['style'=>'display:none']) }}
                        {{ Form::close() }}
                    <td class="text-center show-on-hover-parent">
                        {!! FormField::delete([
                            'route' => ['cart.remove-draft-item', $draft->draftKey],
                            'onsubmit' => 'Yakin ingin menghapus Item ini?',
                            'class' => '',
                        ], 'x', ['id' => 'remove-item-' . $key, 'class' => 'btn btn-danger btn-xs show-on-hover','title' => 'Hapus item ini'], ['item_index' => $key]) !!}
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">{{ trans('transaction.subtotal') }} :</th>
                    <th class="text-right">{{ formatRp($draft->getSubtotal()) }}</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">{{ trans('transaction.discount_total') }} :</th>
                    <th class="text-right">{{ formatRp($draft->getDiscountTotal()) }}</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">{{ trans('transaction.total') }} :</th>
                    <th class="text-right">{{ formatRp($draft->getTotal()) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>