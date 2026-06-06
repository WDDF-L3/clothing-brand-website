<article class="product-card" style="padding:10px; border:1px solid var(--border); border-radius:4px; background:#fff; position:relative;">
    @if($product->discount_percent > 0)
        <div class="badge-sale">-{{ $product->discount_percent }}%</div>
    @endif
    @if($product->stock === 0)
        <div class="badge-oos">Sold Out</div>
    @endif

    <a href="{{ route('products.show', $product) }}" style="display:block;">
        <div class="card-img-wrap">
            @if(!empty($product->images))
                <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="card-img" loading="lazy">
            @else
                <div class="card-img-placeholder">
                    <span>{{ $product->name }}</span>
                </div>
            @endif
        </div>
    </a>

    <div class="card-body">
        <div class="card-category">{{ $product->category->name ?? '' }}</div>
        <h3 class="card-title">
            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
        </h3>

        {{-- Sizes --}}
        @if(!empty($product->sizes))
        <div style="display:flex; gap:4px; flex-wrap:wrap; margin-bottom:12px;">
            @foreach($product->sizes as $size)
            <span style="font-size:9px; padding:2px 6px; border:1px solid var(--border); letter-spacing:.08em;">{{ $size }}</span>
            @endforeach
        </div>
        @endif

        <div class="card-pricing">
            <span class="price">{{ $product->formatted_price }}</span>
            @if($product->compare_price)
            <span class="price-compare">{{ $product->formatted_compare_price }}</span>
            @endif
        </div>

        @if($product->stock > 0)
        <form action="{{ route('cart.add', $product) }}" method="POST" style="margin-top:12px;">
            @csrf
            @if(!empty($product->sizes))
            <select name="size" class="form-control" style="margin-bottom:8px; font-size:12px; padding:7px 10px;" required>
                <option value="">Select size</option>
                @foreach($product->sizes as $size)
                <option value="{{ $size }}">{{ $size }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="btn btn-dark" style="width:100%; justify-content:center;">
                Add to Bag
            </button>
        </form>
        @else
        <button class="btn" style="width:100%; justify-content:center; margin-top:12px; background:var(--warm); color:var(--stone); cursor:not-allowed;" disabled>
            Sold Out
        </button>
        @endif
    </div>
</article>
