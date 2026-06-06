@extends('admin.layout')
@section('title', isset($product) ? 'Edit Product' : 'New Product')

@section('topbar-actions')
<a href="{{ route('admin.products.index') }}" class="btn btn-ghost">← Back to Products</a>
@endsection

@section('content')

<div style="max-width:800px;">
    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        {{-- Basic Info --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><span class="card-title">Product Information</span></div>
            <div class="card-body">
                <div class="form-grid form-grid-2">
                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required placeholder="e.g. Silk Draped Midi Dress">
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select category…</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stock Quantity *</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
                        @error('stock')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Product description…">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><span class="card-title">Pricing</span></div>
            <div class="card-body">
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Sale Price * (Tk)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0" required placeholder="0.00">
                        @error('price')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Compare Price (Tk) <span style="color:var(--muted); font-size:10px;">shows strikethrough</span></label>
                        <input type="number" name="compare_price" class="form-control" value="{{ old('compare_price', $product->compare_price ?? '') }}" step="0.01" min="0" placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>

        {{-- Variants --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><span class="card-title">Variants</span></div>
            <div class="card-body">
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Sizes</label>
                        <input type="text" name="sizes" class="form-control"
                               value="{{ old('sizes', isset($product) ? implode(', ', $product->sizes ?? []) : '') }}"
                               placeholder="XS, S, M, L, XL">
                        <span class="form-hint">Comma-separated. Leave blank if no sizes.</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Colors</label>
                        <input type="text" name="colors" class="form-control"
                               value="{{ old('colors', isset($product) ? implode(', ', $product->colors ?? []) : '') }}"
                               placeholder="Black, White, Navy">
                        <span class="form-hint">Comma-separated. Leave blank if no colors.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Images --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><span class="card-title">Product Images</span></div>
            <div class="card-body">

                {{-- Existing images --}}
                @if(isset($product) && !empty($product->images))
                <div style="margin-bottom:20px;">
                    <div class="form-label" style="margin-bottom:10px;">Current Images</div>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;" id="existing-images">
                        @foreach($product->images as $i => $img)
                        <div style="position:relative; display:inline-block;">
                            <img src="{{ $img }}" alt="Image {{ $i+1 }}"
                                 style="width:90px; height:110px; object-fit:cover; border-radius:6px; border:1px solid var(--border); display:block;">
                            <div style="position:absolute; bottom:4px; left:0; right:0; text-align:center; font-size:9px; color:rgba(255,255,255,.7); background:rgba(0,0,0,.5); padding:2px;">
                                {{ $i === 0 ? 'Primary' : 'Image '.($i+1) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p style="font-size:11px; color:var(--muted); margin-top:8px;">Uploading new images will be added alongside existing ones. The first image shown is the primary display image.</p>
                </div>
                @endif

                {{-- Upload area --}}
                <div class="form-group">
                    <label class="form-label">{{ isset($product) && !empty($product->images) ? 'Add More Images' : 'Upload Images' }}</label>

                    <div id="drop-zone"
                         style="border:2px dashed var(--border); border-radius:8px; padding:32px; text-align:center; cursor:pointer; transition:all .2s; position:relative; background:var(--bg);"
                         onclick="document.getElementById('image-input').click()"
                         ondragover="handleDragOver(event)"
                         ondragleave="handleDragLeave(event)"
                         ondrop="handleDrop(event)">

                        <input type="file" name="images[]" id="image-input" multiple accept="image/*"
                               style="display:none;" onchange="handleFiles(this.files)">

                        <div id="drop-placeholder">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.5" style="margin:0 auto 12px;">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <div style="font-size:14px; color:var(--muted); margin-bottom:4px;">Click to browse or drag & drop images here</div>
                            <div style="font-size:11px; color:var(--border);">JPG, PNG, WEBP — max 4MB each — multiple files allowed</div>
                        </div>

                        <div id="preview-grid" style="display:none; flex-wrap:wrap; gap:10px; justify-content:center;"></div>
                    </div>

                    @error('images.*')<p class="form-error" style="margin-top:6px;">{{ $message }}</p>@enderror

                    <div id="file-count" style="font-size:12px; color:var(--muted); margin-top:8px; display:none;"></div>
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="card" style="margin-bottom:24px;">
            <div class="card-header"><span class="card-title">Settings</span></div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <label class="toggle-wrap">
                        <input type="checkbox" name="is_active" value="1" id="tog-active" class="toggle-input"
                               {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <div class="toggle" id="div-active"></div>
                        <div>
                            <div style="font-size:13px; font-weight:600;">Active</div>
                            <div style="font-size:11px; color:var(--muted);">Visible in the store</div>
                        </div>
                    </label>
                    <label class="toggle-wrap">
                        <input type="checkbox" name="is_featured" value="1" id="tog-featured" class="toggle-input"
                               {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        <div class="toggle" id="div-featured"></div>
                        <div>
                            <div style="font-size:13px; font-weight:600;">Featured</div>
                            <div style="font-size:11px; color:var(--muted);">Show in homepage hero section</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn btn-accent" style="padding:12px 28px;">
                {{ isset($product) ? 'Save Changes' : 'Create Product' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost" style="padding:12px 28px;">Cancel</a>

            @if(isset($product))
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="margin-left:auto;" onsubmit="return confirm('Permanently delete this product?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="padding:12px 28px;">Delete Product</button>
            </form>
            @endif
        </div>
    </form>
</div>

@push('styles')
<style>
#drop-zone.dragover {
    border-color: var(--accent);
    background: rgba(200,169,126,.05);
}
.preview-item {
    position: relative;
    width: 90px;
    height: 110px;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid var(--border);
    flex-shrink: 0;
}
.preview-item img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.preview-item .remove-btn {
    position: absolute; top: 3px; right: 3px;
    width: 18px; height: 18px;
    background: rgba(0,0,0,.7); color: white;
    border: none; border-radius: 50%;
    font-size: 11px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    line-height: 1;
}
.preview-item .primary-tag {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(200,169,126,.85); color: #0f0f0f;
    font-size: 9px; text-align: center; padding: 3px;
    font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
}
</style>
@endpush

@push('scripts')
<script>
// Toggle init
function initToggle(cbId, divId) {
    const cb = document.getElementById(cbId);
    const div = document.getElementById(divId);
    div.style.background = cb.checked ? 'var(--accent)' : 'var(--border)';
    cb.addEventListener('change', () => {
        div.style.background = cb.checked ? 'var(--accent)' : 'var(--border)';
    });
}
initToggle('tog-active', 'div-active');
initToggle('tog-featured', 'div-featured');

// File handling
let selectedFiles = [];

function handleFiles(fileList) {
    const newFiles = Array.from(fileList).filter(f => f.type.startsWith('image/'));
    selectedFiles = [...selectedFiles, ...newFiles];
    rebuildInput();
    renderPreviews();
}

function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('drop-zone').classList.add('dragover');
}
function handleDragLeave(e) {
    document.getElementById('drop-zone').classList.remove('dragover');
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('drop-zone').classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    rebuildInput();
    renderPreviews();
}

function rebuildInput() {
    // Rebuild the file input with current selectedFiles using DataTransfer
    const input = document.getElementById('image-input');
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function renderPreviews() {
    const grid = document.getElementById('preview-grid');
    const placeholder = document.getElementById('drop-placeholder');
    const countEl = document.getElementById('file-count');

    grid.innerHTML = '';

    if (selectedFiles.length === 0) {
        grid.style.display = 'none';
        placeholder.style.display = '';
        countEl.style.display = 'none';
        return;
    }

    placeholder.style.display = 'none';
    grid.style.display = 'flex';
    countEl.style.display = '';
    countEl.textContent = selectedFiles.length + ' image' + (selectedFiles.length > 1 ? 's' : '') + ' selected';

    selectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                ${i === 0 ? '<div class="primary-tag">Primary</div>' : ''}
                <button type="button" class="remove-btn" onclick="removeFile(${i})">×</button>
            `;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush

@endsection
