<x-dashboard-layout title="Add New Product">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Add New Product</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('product.store-new-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-8">
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                    <div class="col-md-8">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="brand" class="col-md-4 col-form-label text-md-end">Brand</label>
                    <div class="col-md-8">
                        <input type="text" id="brand" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand') }}" required>
                        @error('brand')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="price" class="col-md-4 col-form-label text-md-end">Price</label>
                    <div class="col-md-8">
                        <input type="number" id="price" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category" class="col-md-4 col-form-label text-md-end">Category</label>
                    <div class="col-md-8">
                        <select class="form-control" name="category_id" id="category">
                        @foreach($categories as $category)
                            @if(old('category_id') == $category->id) 
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                  </div>
                <div class="row mb-3">
                    <label for="product_image" class="col-md-4 col-form-label text-md-end">Product Image</label>
                    <div class="col-md-8">
                        <input type="file" id="product_image" class="form-control @error('product_image') is-invalid @enderror " name="product_image">
                        @error('product_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">File size: max. 1 MB, Image format: .JPEG, .PNG</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>