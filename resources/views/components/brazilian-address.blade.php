{{-- Brazilian Address Form Component --}}
<div class="form-group">
    <h5 class="mb-3">{{ __('general.address') }}</h5>
    
    <div class="row">
        <div class="col-md-3">
            <label for="cep" class="form-label">{{ __('general.cep') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                   id="cep" name="cep" value="{{ old('cep', $user->cep ?? '') }}" 
                   placeholder="00000-000" maxlength="9">
            @error('cep')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label for="street" class="form-label">{{ __('general.street') }}</label>
            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                   id="street" name="street" value="{{ old('street', $user->street ?? '') }}" 
                   placeholder="Rua, Avenida, etc.">
            @error('street')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-3">
            <label for="number" class="form-label">{{ __('general.number') }}</label>
            <input type="text" class="form-control @error('number') is-invalid @enderror" 
                   id="number" name="number" value="{{ old('number', $user->number ?? '') }}" 
                   placeholder="123">
            @error('number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-4">
            <label for="complement" class="form-label">{{ __('general.complement') }}</label>
            <input type="text" class="form-control @error('complement') is-invalid @enderror" 
                   id="complement" name="complement" value="{{ old('complement', $user->complement ?? '') }}" 
                   placeholder="Apto, Bloco, etc.">
            @error('complement')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-4">
            <label for="neighborhood" class="form-label">{{ __('general.neighborhood') }}</label>
            <input type="text" class="form-control @error('neighborhood') is-invalid @enderror" 
                   id="neighborhood" name="neighborhood" value="{{ old('neighborhood', $user->neighborhood ?? '') }}" 
                   placeholder="Bairro">
            @error('neighborhood')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-4">
            <label for="city" class="form-label">{{ __('general.city') }}</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                   id="city" name="city" value="{{ old('city', $user->city ?? '') }}" 
                   placeholder="Cidade">
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-3">
            <label for="uf" class="form-label">{{ __('general.uf') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('uf') is-invalid @enderror" id="uf" name="uf">
                <option value="">{{ __('general.select_option') }}</option>
                @foreach(__('general.states') as $uf => $stateName)
                    <option value="{{ $uf }}" {{ old('uf', $user->uf ?? '') == $uf ? 'selected' : '' }}>
                        {{ $uf }} - {{ $stateName }}
                    </option>
                @endforeach
            </select>
            @error('uf')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- JavaScript for CEP lookup (ViaCEP) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    const streetInput = document.getElementById('street');
    const neighborhoodInput = document.getElementById('neighborhood');
    const cityInput = document.getElementById('city');
    const ufSelect = document.getElementById('uf');
    
    // CEP mask
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
        
        // If CEP is complete, try to lookup address
        if (value.length === 9) {
            lookupCep(value.replace('-', ''));
        }
    });
    
    function lookupCep(cep) {
        if (cep.length !== 8) return;
        
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    streetInput.value = data.logradouro || '';
                    neighborhoodInput.value = data.bairro || '';
                    cityInput.value = data.localidade || '';
                    ufSelect.value = data.uf || '';
                }
            })
            .catch(error => {
                console.log('Erro ao buscar CEP:', error);
            });
    }
});
</script>