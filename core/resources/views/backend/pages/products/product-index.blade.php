@extends('backend.admin-master')

@section('site-title', __('All Products'))

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .icons { display: flex; align-items: center; gap: 10px; }
</style>
@endsection

@section('content')
<div class="row align-items-center mt-20">
    <div class="col-md-6"><h5>Products</h5></div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.products.add') }}" class="btn btn-primary">
            Add Product
        </a>
    </div>

     {{-- Success Message --}}
    @if(session('message'))
      <div class="alert alert-success mt-3">
          {{ session('message') }}
      </div>
    @endif

    <table class="table table-bordered mt-25">
      <thead>
        <tr>
            <th>S.No</th>
            <th>Product Name</th>
            <th>Category</th>
            {{-- <th>Price</th> --}}
            <th>Distributor Price</th>
            <th>BV Points</th>
            <th>Weight (g)</th>
            <th>Size and Price</th>
            {{-- <th>Unit</th>
            <th>Unit Measurement</th> --}}
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
          @php
              $img = $product->imageFile->path ?? 'no-image.png';
              $sizeIds = explode('|', $product->size_id ?? '');
              $sizePrices = explode('|', $product->size_price ?? '');
              $distributorPrice = (float) $product->distributor_price;

              // Load sizes if available
              $sizeMap = \App\Models\Size::whereIn('id', $sizeIds)->pluck('name', 'id')->toArray();
          @endphp
          <tr id="product-row-{{ $product->id }}">
              <td>{{ $loop->iteration }}</td>
              <td class="d-flex align-items-center gap-3">
                  <img src="{{ asset('assets/uploads/media-uploader/'.$img) }}"
                      style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                  {{ $product->name }}
              </td>
              <td>{{ $product->category->category ?? 'N/A' }}</td>
              {{-- <td>₹{{ number_format($product->price, 2) }}</td> --}}
              <td>₹{{ number_format($product->distributor_price, 2) }}</td>
              <td>{{ $product->bv_points ?? 0 }}</td>
              <td>{{ $product->weight ? number_format($product->weight, 2) . ' g' : '—' }}</td>
              {{-- <td>{{ $product->unit->name ?? 'N/A' }}</td>
              <td>{{ $product->unit_measurement ?? '-' }}</td> --}}
              <td>
                  @if(!empty($sizeIds) && !empty($sizePrices))
                      @foreach($sizeIds as $index => $sizeId)
                          @php
                              $label = $sizeMap[$sizeId] ?? 'N/A';
                              $extra = (float) ($sizePrices[$index] ?? 0);
                              $finalPrice = $distributorPrice + $extra;
                          @endphp
                          <div>{{ $label }} - ₹{{ number_format($finalPrice, 2) }}</div>
                      @endforeach
                  @else
                      <div>—</div>
                  @endif
              </td>
              <td class="icons">
                  <a href="{{ route('admin.products.edit', $product->id) }}"
                    class="btn btn-warning btn-sm" title="Edit">
                      <i class="fas fa-edit"></i>
                  </a>

                  <form
                    action="{{ route('admin.products.destroy', $product->id) }}"
                    method="POST"
                    class="d-inline delete-form"
                  >
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
              </td>
          </tr>
        @empty
          <tr>
              <td colspan="7" class="text-center text-muted">{{ __('No products available.') }}</td>
          </tr>
        @endforelse
      </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this product?')) {
          form.submit();
        }
      });
    });
  });
</script>
@endsection