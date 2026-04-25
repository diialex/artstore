<x-layout>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" action="{{ $payment->exists ? route('payments.update', $payment) : route('payments.store') }}">
                @csrf
                @if($payment->exists) @method('PUT') @endif

                <div class="form-group">
                    <label>Orden ID</label>
                    <input name="order_id" class="form-control" value="{{ old('order_id', $payment->order_id) }}" type="number">
                    @error('order_id') <div>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Cantidad</label>
                    <input name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" type="number" step="0.01">
                    @error('amount') <div>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Método de Pago</label>
                    <input name="payment_method" class="form-control" value="{{ old('payment_method', $payment->payment_method) }}">
                    @error('payment_method') <div>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <select name="status" class="form-control">
                        <option value="pending" @selected(old('status', $payment->status) === 'pending')>Pendiente</option>
                        <option value="completed" @selected(old('status', $payment->status) === 'completed')>Completado</option>
                        <option value="failed" @selected(old('status', $payment->status) === 'failed')>Fallido</option>
                    </select>
                    @error('status') <div>{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary mt-2">{{ $payment->exists ? 'Actualizar' : 'Crear' }}</button>
            </form>
        </div>
    </div>
</x-layout>