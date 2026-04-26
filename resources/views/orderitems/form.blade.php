<x-layout>
    <div class="row m-4">
        <div class="col-6">
            <h3>{{ $orderItem->id ? 'Editar Artículo de Orden' : 'Nuevo Artículo de Orden' }}</h3>

            <form action="{{ $orderItem->id ? route('orderitems.update', $orderItem) : route('orderitems.store') }}"
                method="POST">
                @csrf
                @if($orderItem->id)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="order_id" class="form-label">Orden</label>
                    <select class="form-control @error('order_id') is-invalid @enderror" id="order_id" name="order_id" required>
                        <option value="">Selecciona una orden</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id', $orderItem->order_id) == $order->id ? 'selected' : '' }}>
                                Orden #{{ $order->id }} - ${{ $order->total_amount }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Cantidad</label>
                    <input type="number" step="1" class="form-control @error('quantity') is-invalid @enderror"
                        id="quantity" name="quantity" required
                        value="{{ old('quantity', $orderItem->quantity) }}">
                    @error('quantity')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Precio Unitario</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                        id="price" name="price" required
                        value="{{ old('price', $orderItem->price) }}">
                    @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ $orderItem->id ? 'Actualizar' : 'Crear' }}</button>
                <a href="{{ route('orderitems.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</x-layout>