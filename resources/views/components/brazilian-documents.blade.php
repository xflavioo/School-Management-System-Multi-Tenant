{{-- Brazilian Documents Form Component --}}
<div class="form-group">
    <h5 class="mb-3">{{ __('general.personal_documents') }}</h5>
    
    <div class="row">
        <div class="col-md-4">
            <label for="cpf" class="form-label">{{ __('general.cpf') }}</label>
            <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                   id="cpf" name="cpf" value="{{ old('cpf', $user->cpf ?? '') }}" 
                   placeholder="000.000.000-00" maxlength="14">
            @error('cpf')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-4">
            <label for="rg" class="form-label">{{ __('general.rg') }}</label>
            <input type="text" class="form-control @error('rg') is-invalid @enderror" 
                   id="rg" name="rg" value="{{ old('rg', $user->rg ?? '') }}" 
                   placeholder="12.345.678-9">
            @error('rg')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-4">
            <label for="rg_issuer" class="form-label">{{ __('general.rg_issuer') }}</label>
            <input type="text" class="form-control @error('rg_issuer') is-invalid @enderror" 
                   id="rg_issuer" name="rg_issuer" value="{{ old('rg_issuer', $user->rg_issuer ?? '') }}" 
                   placeholder="SSP, DETRAN, etc.">
            @error('rg_issuer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-3">
            <label for="rg_state" class="form-label">{{ __('general.rg_state') }}</label>
            <select class="form-select @error('rg_state') is-invalid @enderror" id="rg_state" name="rg_state">
                <option value="">{{ __('general.select_option') }}</option>
                @foreach(__('general.states') as $uf => $stateName)
                    <option value="{{ $uf }}" {{ old('rg_state', $user->rg_state ?? '') == $uf ? 'selected' : '' }}>
                        {{ $uf }}
                    </option>
                @endforeach
            </select>
            @error('rg_state')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-3">
            <label for="rg_issue_date" class="form-label">{{ __('general.rg_issue_date') }}</label>
            <input type="date" class="form-control @error('rg_issue_date') is-invalid @enderror" 
                   id="rg_issue_date" name="rg_issue_date" value="{{ old('rg_issue_date', $user->rg_issue_date ?? '') }}">
            @error('rg_issue_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-3">
            <label for="sus_card" class="form-label">{{ __('general.sus_card') }}</label>
            <input type="text" class="form-control @error('sus_card') is-invalid @enderror" 
                   id="sus_card" name="sus_card" value="{{ old('sus_card', $user->sus_card ?? '') }}" 
                   placeholder="000 0000 0000 0000">
            @error('sus_card')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-3">
            <label for="nis" class="form-label">{{ __('general.nis') }}</label>
            <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                   id="nis" name="nis" value="{{ old('nis', $user->nis ?? '') }}" 
                   placeholder="000.00000.00-0">
            @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- JavaScript for input masks --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CPF mask
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    });
    
    // RG mask (basic)
    document.getElementById('rg').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 9) {
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        e.target.value = value;
    });
    
    // SUS card mask
    document.getElementById('sus_card').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1 $2');
        value = value.replace(/(\d{4})(\d)/, '$1 $2');
        value = value.replace(/(\d{4})(\d)/, '$1 $2');
        e.target.value = value;
    });
    
    // NIS mask
    document.getElementById('nis').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{5})(\d)/, '$1.$2');
        value = value.replace(/(\d{2})(\d{1})$/, '$1-$2');
        e.target.value = value;
    });
});
</script>