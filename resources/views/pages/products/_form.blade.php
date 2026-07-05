<div class="mb-3">
    <label>Kategori</label>
    <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
        <option value="">Pilih Kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id_kategori }}"
                {{ old('id_kategori', $product->id_kategori ?? '') == $category->id_kategori ? 'selected' : '' }}>
                {{ $category->nama_kategori }}
            </option>
        @endforeach
    </select>

    @error('id_kategori')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Nama Produk</label>
    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
        value="{{ old('nama_produk', $product->nama_produk ?? '') }}">
    @error('nama_produk')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Harga Beli</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="harga_beli" class="form-control"
                value="{{ old('harga_beli', $product->harga_beli ?? 0) }}">
        </div>
    </div>
    <div class="col-md-6">
        <label>Harga Jual</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="harga_jual" class="form-control"
                value="{{ old('harga_jual', $product->harga_jual ?? 0) }}">
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-6">
        <label>Minimum Stock</label>
        <input type="number" name="min_stok" class="form-control"
            value="{{ old('min_stok', $product->min_stok ?? 0) }}">
    </div>
    <div class="col-md-6">
        <label>Maximum Stock</label>
        <input type="number" name="max_stok" class="form-control"
            value="{{ old('max_stok', $product->max_stok ?? 0) }}">
    </div>
</div>
<br>

<div class="row">
    @php
        $units = ['PCS', 'BOX', 'CTN', 'PACK', 'LUSIN', 'ROLL'];
    @endphp
    <div class="col-md-6 mb-3">
        <label for="satuan" class="form-label">Satuan</label>
        <select name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror">
            <option value="">-- Pilih Satuan --</option>
            @foreach ($units as $unit)
                <option value="{{ $unit }}"
                    {{ old('satuan', $product->satuan ?? '') == $unit ? 'selected' : '' }}>
                    {{ $unit }}
                </option>
            @endforeach
        </select>
        @error('satuan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="fraction" class="form-label">
            Isi per Satuan (PCS)
        </label>
        <input type="number" name="fraction" id="fraction" value="{{ old('fraction', $product->fraction ?? 1) }}"
            class="form-control @error('fraction') is-invalid @enderror">
        <small class="text-muted">
            Contoh:
            PCS = 1,
            BOX = 24,
            CTN = 48
        </small>
        @error('fraction')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<br>
<div class="mb-3">
    <label for="foto" class="form-label">Foto Produk</label>
    <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
    @error('foto')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    @if (isset($product) && $product->foto)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $product->foto) }}" width="140" class="img-thumbnail">
        </div>
    @endif
    <small class="text-muted">
        Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 2 MB.
    </small>
</div>
