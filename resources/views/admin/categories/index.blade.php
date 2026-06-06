@extends('admin.layout')
@section('title', 'Categories')

@section('content')

<div style="display:grid; grid-template-columns:1fr 360px; gap:20px; align-items:start;">

    {{-- List --}}
    <div class="card">
        <div class="card-header"><span class="card-title">All Categories</span></div>
        <table class="table">
            <thead>
                <tr><th>Name</th><th>Products</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>
                        <div style="font-weight:600;">{{ $cat->name }}</div>
                        <div style="font-size:11px; color:var(--muted);">{{ $cat->slug }}</div>
                        @if($cat->description)
                        <div style="font-size:11px; color:var(--muted); margin-top:2px;">{{ Str::limit($cat->description, 50) }}</div>
                        @endif
                    </td>
                    <td><span class="badge badge-muted">{{ $cat->products_count }}</span></td>
                    <td>
                        <span class="badge {{ $cat->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $cat->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description ?? '') }}', {{ $cat->is_active ? 'true' : 'false' }})"
                                    class="btn btn-ghost btn-sm">Edit</button>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                  onsubmit="return confirm('Delete \'{{ addslashes($cat->name) }}\'? This will fail if it has products.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:32px; color:var(--muted);">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Create Form --}}
    <div class="card">
        <div class="card-header"><span class="card-title" id="form-title">New Category</span></div>
        <div class="card-body">
            <form id="cat-form" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="cat-method" value="POST">
                <input type="hidden" name="_cat_id" id="cat-id" value="">

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" id="cat-name" class="form-control" required placeholder="e.g. Accessories">
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="cat-desc" class="form-control" rows="3" placeholder="Short description…"></textarea>
                </div>
                <div class="form-group" style="margin-bottom:20px;">
                    <label class="toggle-wrap">
                        <input type="checkbox" name="is_active" value="1" id="cat-active" class="toggle-input" checked>
                        <div class="toggle" id="cat-toggle" style="background:var(--accent);"></div>
                        <span style="font-size:13px;">Active (visible in store)</span>
                    </label>
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn btn-accent" id="cat-submit">Create Category</button>
                    <button type="button" onclick="resetForm()" class="btn btn-ghost" id="cat-cancel" style="display:none;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openEdit(id, name, desc, active) {
    document.getElementById('form-title').textContent = 'Edit Category';
    document.getElementById('cat-submit').textContent = 'Save Changes';
    document.getElementById('cat-cancel').style.display = '';
    document.getElementById('cat-name').value  = name;
    document.getElementById('cat-desc').value  = desc;
    document.getElementById('cat-active').checked = active;
    document.getElementById('cat-toggle').style.background = active ? 'var(--accent)' : 'var(--border)';
    document.getElementById('cat-id').value    = id;
    document.getElementById('cat-method').value = 'PUT';
    document.getElementById('cat-form').action = '/admin/categories/' + id;
    document.getElementById('cat-form').scrollIntoView({ behavior: 'smooth' });
}
function resetForm() {
    document.getElementById('form-title').textContent   = 'New Category';
    document.getElementById('cat-submit').textContent   = 'Create Category';
    document.getElementById('cat-cancel').style.display = 'none';
    document.getElementById('cat-name').value  = '';
    document.getElementById('cat-desc').value  = '';
    document.getElementById('cat-active').checked = true;
    document.getElementById('cat-toggle').style.background = 'var(--accent)';
    document.getElementById('cat-method').value = 'POST';
    document.getElementById('cat-form').action = '{{ route('admin.categories.store') }}';
}
document.getElementById('cat-active').addEventListener('change', function() {
    document.getElementById('cat-toggle').style.background = this.checked ? 'var(--accent)' : 'var(--border)';
});
</script>
@endpush

@endsection
