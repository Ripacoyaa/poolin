<form method="POST"
      action="{{ isset($goal) ? route('personal.goals.update', $goal) : route('personal.goals.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if(isset($goal))
        @method('PUT')
    @endif


    <div class="form-group">
    <label for="nama">Goal Name</label>
    <input type="text" id="nama" name="nama"
           value="{{ old('nama', $goal->nama ?? '') }}" required>
    @error('nama') <div class="error">{{ $message }}</div> @enderror
</div>

    <div class="form-group">
        <label for="target_tabungan">Target Amount (Rp)</label>
        <input type="number"
               id="target_tabungan"
               name="target_tabungan"
               step="1000" min="0"
               value="{{ old('target_tabungan', $goal->target_tabungan ?? '') }}" required>
        @error('target_tabungan') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
    <label for="foto">Goal Image (optional)</label>
    <input type="file" id="foto" name="foto" accept="image/*">
    @error('foto')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

    @if(isset($goal))
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="active" {{ $goal->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="finished" {{ $goal->status === 'finished' ? 'selected' : '' }}>Finished</option>
            </select>
            @error('status') <div class="error">{{ $message }}</div> @enderror
        </div>
    @endif

    <div class="actions">
        <button type="submit" class="btn-primary">
            {{ isset($goal) ? 'Update Goal' : 'Save Goal' }}
        </button>
        <a href="{{ route('personal.goals') }}" class="btn-secondary">Cancel</a>
    </div>
</form>
