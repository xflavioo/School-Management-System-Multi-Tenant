<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrazilianStudentRequest extends FormRequest
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
        return [
            // Basic student info
            'my_class_id' => 'required|exists:my_classes,id',
            'section_id' => 'required|exists:sections,id',
            'adm_no' => 'required|string|max:30|unique:student_records,adm_no,' . $this->route('student_record'),
            'session' => 'required|string',
            'year_admitted' => 'nullable|string|digits:4',
            'house' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:3|max:25',
            
            // Parent/Guardian
            'my_parent_id' => 'nullable|exists:users,id',
            
            // Brazilian specific fields
            'enrollment_type' => 'nullable|string|max:50',
            'transport_type' => 'nullable|string|max:50|in:próprio,escolar,público,a_pé',
            'has_special_needs' => 'boolean',
            'special_needs_description' => 'nullable|string|max:500|required_if:has_special_needs,true',
            
            // Emergency contact
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/',
            'emergency_contact_relationship' => 'nullable|string|max:100',
            
            // Documents
            'has_birth_certificate' => 'boolean',
            'has_vaccination_card' => 'boolean',
            'has_medical_certificate' => 'boolean',
            'has_transfer_certificate' => 'boolean',
            
            // Previous school
            'previous_school' => 'nullable|string|max:255',
            'previous_school_city' => 'nullable|string|max:255',
            'previous_school_state' => 'nullable|string|size:2|in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
            
            // Scholarship
            'has_scholarship' => 'boolean',
            'scholarship_percentage' => 'nullable|numeric|min:0|max:100|required_if:has_scholarship,true',
            'scholarship_type' => 'nullable|string|max:255|required_if:has_scholarship,true',
            
            // Dormitory
            'dorm_id' => 'nullable|exists:dorms,id',
            'dorm_room_no' => 'nullable|string|max:10',
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
            'my_class_id' => 'turma',
            'section_id' => 'seção',
            'adm_no' => 'número de matrícula',
            'session' => 'ano letivo',
            'year_admitted' => 'ano de admissão',
            'house' => 'casa',
            'age' => 'idade',
            'my_parent_id' => 'responsável',
            'enrollment_type' => 'tipo de matrícula',
            'transport_type' => 'tipo de transporte',
            'has_special_needs' => 'necessidades especiais',
            'special_needs_description' => 'descrição das necessidades especiais',
            'emergency_contact_name' => 'nome do contato de emergência',
            'emergency_contact_phone' => 'telefone do contato de emergência',
            'emergency_contact_relationship' => 'parentesco do contato de emergência',
            'has_birth_certificate' => 'certidão de nascimento',
            'has_vaccination_card' => 'cartão de vacinação',
            'has_medical_certificate' => 'atestado médico',
            'has_transfer_certificate' => 'declaração de transferência',
            'previous_school' => 'escola anterior',
            'previous_school_city' => 'cidade da escola anterior',
            'previous_school_state' => 'estado da escola anterior',
            'has_scholarship' => 'bolsa de estudos',
            'scholarship_percentage' => 'percentual da bolsa',
            'scholarship_type' => 'tipo de bolsa',
            'dorm_id' => 'dormitório',
            'dorm_room_no' => 'número do quarto',
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
            'emergency_contact_phone.regex' => 'O telefone de emergência deve estar no formato (11) 99999-9999.',
            'transport_type.in' => 'Selecione um tipo de transporte válido.',
            'previous_school_state.in' => 'Selecione um estado válido.',
            'special_needs_description.required_if' => 'A descrição das necessidades especiais é obrigatória quando o aluno possui necessidades especiais.',
            'scholarship_percentage.required_if' => 'O percentual da bolsa é obrigatório quando o aluno possui bolsa de estudos.',
            'scholarship_type.required_if' => 'O tipo de bolsa é obrigatório quando o aluno possui bolsa de estudos.',
        ];
    }
}