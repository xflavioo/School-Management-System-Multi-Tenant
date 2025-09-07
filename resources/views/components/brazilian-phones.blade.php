{{-- Brazilian Phone Fields Component --}}
<div class="form-group">
    <h5 class="mb-3">{{ __('general.contact_info') }}</h5>
    
    <div class="row">
        <div class="col-md-4">
            <label for="phone_mobile" class="form-label">{{ __('general.phone_mobile') }}</label>
            <input type="text" class="form-control @error('phone_mobile') is-invalid @enderror" 
                   id="phone_mobile" name="phone_mobile" value="{{ old('phone_mobile', $user->phone_mobile ?? '') }}" 
                   placeholder="(11) 99999-9999" maxlength="15">
            @error('phone_mobile')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-4">
            <label for="phone_home" class="form-label">{{ __('general.phone_home') }}</label>
            <input type="text" class="form-control @error('phone_home') is-invalid @enderror" 
                   id="phone_home" name="phone_home" value="{{ old('phone_home', $user->phone_home ?? '') }}" 
                   placeholder="(11) 9999-9999" maxlength="14">
            @error('phone_home')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-4">
            <label for="email" class="form-label">{{ __('general.email') }} <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                   placeholder="usuario@exemplo.com" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- JavaScript for phone masks --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile phone mask (11) 99999-9999
    document.getElementById('phone_mobile').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
        }
        
        e.target.value = value;
    });
    
    // Home phone mask (11) 9999-9999
    document.getElementById('phone_home').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        }
        
        e.target.value = value;
    });
});
</script>