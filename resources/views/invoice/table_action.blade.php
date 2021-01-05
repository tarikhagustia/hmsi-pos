<x-table-view-action :show="route('invoices.show', ['invoice' => $model->id])">
    <a class="btn btn-sm btn-success" href="{{ route('invoices.payment-form', ['invoice' => $model->id]) }}" data-toggle="tooltip" data-placement="top" title="Bayar">
        <i class="fas fa-money-bill-wave"></i>
    </a>
</x-table-view-action>
