<?php

namespace App\Http\Requests;

use App\Rules\ValidCpf;
use App\Rules\ValidCep;
use Illuminate\Foundation\Http\FormRequest;

class BrazilianUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;
        
        return [
            'name' => 'required|string|max:255',
            'social_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'username' => 'nullable|string|max:100|unique:users,username,' . $userId,
            'cpf' => ['nullable', new ValidCpf(), 'unique:users,cpf,' . $userId],
            'rg' => 'nullable|string|max:20',
            'rg_issuer' => 'nullable|string|max:20',
            'rg_state' => 'nullable|string|size:2',
            'rg_issue_date' => 'nullable|date',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'phone_mobile' => 'nullable|string|regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/',
            'phone_home' => 'nullable|string|regex:/^\(\d{2}\)\s\d{4}-\d{4}$/',
            'cep' => ['nullable', new ValidCep()],
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:15',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'uf' => 'nullable|string|size:2|in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
            'address' => 'nullable|string|max:255',
            'birth_certificate' => 'nullable|string|max:255',
            'vaccination_card' => 'nullable|string|max:255',
            'sus_card' => 'nullable|string|max:20',
            'nis' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nome',
            'social_name' => 'nome social',
            'email' => 'e-mail',
            'username' => 'nome de usuário',
            'cpf' => 'CPF',
            'rg' => 'RG',
            'rg_issuer' => 'órgão emissor',
            'rg_state' => 'UF do RG',
            'rg_issue_date' => 'data de emissão do RG',
            'dob' => 'data de nascimento',
            'gender' => 'gênero',
            'phone' => 'telefone',
            'phone_mobile' => 'celular',
            'phone_home' => 'telefone residencial',
            'cep' => 'CEP',
            'street' => 'logradouro',
            'number' => 'número',
            'complement' => 'complemento',
            'neighborhood' => 'bairro',
            'city' => 'cidade',
            'uf' => 'UF',
            'address' => 'endereço',
            'birth_certificate' => 'certidão de nascimento',
            'vaccination_card' => 'cartão de vacinação',
            'sus_card' => 'cartão SUS',
            'nis' => 'NIS',
            'password' => 'senha',
            'photo' => 'foto',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone_mobile.regex' => 'O celular deve estar no formato (11) 99999-9999.',
            'phone_home.regex' => 'O telefone residencial deve estar no formato (11) 9999-9999.',
            'uf.in' => 'Selecione um estado válido.',
        ];
    }
}