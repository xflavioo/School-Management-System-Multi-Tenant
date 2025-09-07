# Brazilian PT-BR Formatting Implementation

## Overview

This implementation provides comprehensive Brazilian Portuguese (PT-BR) formatting for the Laravel School Management System. The system includes date, time, currency, and number formatting following Brazilian standards.

## Features Implemented

### 1. Application Configuration
- **Locale**: `pt-BR` (Brazilian Portuguese)
- **Fallback Locale**: `en` (English)
- **Timezone**: `America/Sao_Paulo`
- **Carbon Locale**: `pt_BR`

### 2. Core Formatting Classes

#### `App\Support\BrFormat` (New - following specification)
Provides static methods for Brazilian formatting with strict typing:
- `date($value): string` - Formats dates as dd/mm/yyyy
- `datetime($value): string` - Formats datetime as dd/mm/yyyy HH:mm
- `money($value): string` - Formats currency as R$ 1.234,56
- `number($value, int $decimals = 2): string` - Formats numbers as 1.234,56

#### `App\Helpers\BrazilianFormat` (Enhanced existing)
Extended functionality including:
- All BrFormat methods plus additional Brazilian document formatting
- CPF, CNPJ, CEP, phone number formatting and validation
- Enhanced timezone handling with proper fallbacks
- NumberFormatter integration with fallback support

### 3. Blade Directives

#### New ViewFormattingServiceProvider
Provides clean Blade directives using the BrFormat class:
- `@dateBR($value)` - Format dates
- `@datetimeBR($value)` - Format datetime
- `@moneyBR($value)` - Format currency
- `@numberBR($value, $decimals = 2)` - Format numbers

#### Existing AppServiceProvider (maintained for compatibility)
Provides additional Brazilian formatting directives:
- `@cpfBR($value)` - Format CPF documents
- `@cnpjBR($value)` - Format CNPJ documents
- `@cepBR($value)` - Format postal codes
- `@phoneBR($value)` - Format phone numbers

### 4. Language Support

#### resources/lang/pt-BR/
- `validation.php` - Comprehensive Brazilian Portuguese validation messages
- `messages.php` - System messages in Portuguese

#### resources/lang/pt_BR/
- `validation.php` - Copy for underscore naming convention
- `messages.php` - Copy for underscore naming convention

### 5. Service Providers

#### ViewFormattingServiceProvider
- Registers BrFormat-based Blade directives
- Follows the exact specification requirements
- Added to `config/app.php` providers array

#### AppServiceProvider (enhanced)
- Sets Carbon locale to pt_BR
- Registers BrazilianFormat-based directives for backward compatibility
- Maintains existing functionality

## Usage Examples

### In Blade Templates
```blade
{{-- Date formatting --}}
@dateBR($user->created_at) {{-- Output: 25/12/2023 --}}

{{-- DateTime formatting --}}
@datetimeBR($order->created_at) {{-- Output: 25/12/2023 14:30 --}}

{{-- Currency formatting --}}
@moneyBR($product->price) {{-- Output: R$ 1.234,56 --}}

{{-- Number formatting --}}
@numberBR($statistics->average) {{-- Output: 1.234,56 --}}
@numberBR($percentage, 1) {{-- Output: 99,5 --}}

{{-- Brazilian documents --}}
@cpfBR($person->cpf) {{-- Output: 123.456.789-01 --}}
@cnpjBR($company->cnpj) {{-- Output: 12.345.678/0001-95 --}}
```

### In PHP Code
```php
use App\Support\BrFormat;
use App\Helpers\BrazilianFormat;

// Using BrFormat (new specification)
echo BrFormat::date('2023-12-25'); // 25/12/2023
echo BrFormat::money(1234.56); // R$ 1.234,56

// Using BrazilianFormat (enhanced existing)
echo BrazilianFormat::cpf('12345678901'); // 123.456.789-01
echo BrazilianFormat::validateCpf('12345678901'); // true/false
```

## Technical Details

### NumberFormatter Integration
- Uses PHP's `NumberFormatter` class when available for currency formatting
- Automatically falls back to `number_format()` if `intl` extension is not available
- Handles non-breaking space issues for consistent output

### Timezone Handling
- All date/datetime methods respect the application timezone configuration
- Graceful fallback to 'America/Sao_Paulo' when config is not available
- Works correctly in both web and CLI contexts

### Testing
- Comprehensive unit tests for all formatting methods
- Feature tests for Blade directive compilation and rendering
- Edge case handling (null values, empty strings, etc.)
- Cross-compatibility testing between old and new implementations

## Compatibility

This implementation maintains full backward compatibility with existing code while adding the new specification-compliant features. Both the original `BrazilianFormat` class and the new `BrFormat` class are available and functional.

## Requirements Met

✅ config/app.php: locale = pt_BR, fallback_locale = en, timezone = America/Sao_Paulo
✅ AppServiceProvider@boot: Carbon::setLocale('pt_BR')
✅ Created app/Support/BrFormat.php with required methods
✅ Created ViewFormattingServiceProvider with Blade directives
✅ Added ViewFormattingServiceProvider to config/app.php
✅ Created resources/lang/pt_BR/validation.php and messages.php
✅ Enhanced existing functionality without breaking changes
✅ Comprehensive testing coverage
✅ Manual verification of formatting output