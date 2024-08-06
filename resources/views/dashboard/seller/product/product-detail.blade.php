<x-dashboard-layout title="Product Detail">
    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession
    <div class="mb-2">
        <a href="{{ route('view-product') }}" class="btn btn-primary "><i class="bi bi-arrow-return-left"></i> Back</a>
        <a href="{{ route('product.edit-product', ['product' => $product->id]) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
    </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Product Detail</h6>
                    </div>
                    <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Name</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->name }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Description</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->description }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Brand</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->brand }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Category</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->category->name }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Price</label>
                                <p class="col-md-9 col-form-label text-md-end">: Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Discount</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->discount }}%</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Items sold</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->sold }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Stock</label>
                                <p class="col-md-9 col-form-label text-md-end">: {{ $product->stock }}</p>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-form-label text-md-end">Image</label>
                                @if ( $product->image )
                                    <img src="{{ asset($product_picture_path . $product->image) }}" alt="Product Picture" class="img-profile" width="100">
                                @else
                                    <p class="col-md-9 col-form-label text-md-end">: No Image</p>
                                @endif                             
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Add Stock</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.add-stock', ['product' => $product->id]) }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label for="numberOfProducts" class="form-label text-right">Number of product:</label>
                                    <input type="number" class="form-control @error('numberOfProducts') is-invalid @enderror" id="numberOfProducts"
                                        name="numberOfProducts" required value="{{ old('numberOfProducts', 1) }}">
                                    @error('numberOfProducts')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary ml-auto">
                                        <i class="bi bi-plus"></i>
                                        Add Stock</button>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Set discount</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.set-discount', ['product' => $product->id]) }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label for="discount" class="form-label text-right">Total discount:</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                                        name="discount" required value="{{ old('discount', $product->discount) }}">
                                    @error('discount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary ml-auto">
                                        <i class="bi bi-percent"></i>
                                        Set Discount</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
</x-dashboard-layout>