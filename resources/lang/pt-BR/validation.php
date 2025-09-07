<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O campo :attribute deve ser aceito.',
    'active_url'           => 'O campo :attribute não é uma URL válida.',
    'after'                => 'O campo :attribute deve ser uma data posterior a :date.',
    'after_or_equal'       => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O campo :attribute deve conter apenas letras.',
    'alpha_dash'           => 'O campo :attribute deve conter apenas letras, números, hífens e sublinhados.',
    'alpha_num'            => 'O campo :attribute deve conter apenas letras e números.',
    'array'                => 'O campo :attribute deve ser um array.',
    'before'               => 'O campo :attribute deve ser uma data anterior a :date.',
    'before_or_equal'      => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'file'    => 'O campo :attribute deve ter entre :min e :max kilobytes.',
        'string'  => 'O campo :attribute deve ter entre :min e :max caracteres.',
        'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação do campo :attribute não confere.',
    'date'                 => 'O campo :attribute não é uma data válida.',
    'date_format'          => 'O campo :attribute não coincide com o formato :format.',
    'different'            => 'Os campos :attribute e :other devem ser diferentes.',
    'digits'               => 'O campo :attribute deve ter :digits dígitos.',
    'digits_between'       => 'O campo :attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo :attribute tem um valor duplicado.',
    'email'                => 'O campo :attribute deve ser um endereço de email válido.',
    'exists'               => 'O :attribute selecionado é inválido.',
    'file'                 => 'O campo :attribute deve ser um arquivo.',
    'filled'               => 'O campo :attribute deve ter um valor.',
    'gt'                   => [
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'file'    => 'O campo :attribute deve ter mais que :value kilobytes.',
        'string'  => 'O campo :attribute deve ter mais que :value caracteres.',
        'array'   => 'O campo :attribute deve ter mais que :value itens.',
    ],
    'gte'                  => [
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'file'    => 'O campo :attribute deve ter :value kilobytes ou mais.',
        'string'  => 'O campo :attribute deve ter :value caracteres ou mais.',
        'array'   => 'O campo :attribute deve ter :value itens ou mais.',
    ],
    'image'                => 'O campo :attribute deve ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'O campo :attribute não existe em :other.',
    'integer'              => 'O campo :attribute deve ser um número inteiro.',
    'ip'                   => 'O campo :attribute deve ser um endereço IP válido.',
    'ipv4'                 => 'O campo :attribute deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json'                 => 'O campo :attribute deve ser uma string JSON válida.',
    'lt'                   => [
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'file'    => 'O campo :attribute deve ter menos que :value kilobytes.',
        'string'  => 'O campo :attribute deve ter menos que :value caracteres.',
        'array'   => 'O campo :attribute deve ter menos que :value itens.',
    ],
    'lte'                  => [
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'file'    => 'O campo :attribute deve ter :value kilobytes ou menos.',
        'string'  => 'O campo :attribute deve ter :value caracteres ou menos.',
        'array'   => 'O campo :attribute deve ter :value itens ou menos.',
    ],
    'max'                  => [
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
        'file'    => 'O campo :attribute não pode ter mais que :max kilobytes.',
        'string'  => 'O campo :attribute não pode ter mais que :max caracteres.',
        'array'   => 'O campo :attribute não pode ter mais que :max itens.',
    ],
    'mimes'                => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'file'    => 'O campo :attribute deve ter pelo menos :min kilobytes.',
        'string'  => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'array'   => 'O campo :attribute deve ter pelo menos :min itens.',
    ],
    'not_in'               => 'O :attribute selecionado é inválido.',
    'not_regex'            => 'O formato do campo :attribute é inválido.',
    'numeric'              => 'O campo :attribute deve ser um número.',
    'present'              => 'O campo :attribute deve estar presente.',
    'regex'                => 'O formato do campo :attribute é inválido.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'O campo :attribute é obrigatório a menos que :other esteja em :values.',
    'required_with'        => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without'     => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
    'same'                 => 'Os campos :attribute e :other devem coincidir.',
    'size'                 => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file'    => 'O campo :attribute deve ter :size kilobytes.',
        'string'  => 'O campo :attribute deve ter :size caracteres.',
        'array'   => 'O campo :attribute deve conter :size itens.',
    ],
    'string'               => 'O campo :attribute deve ser uma string.',
    'timezone'             => 'O campo :attribute deve ser uma zona válida.',
    'unique'               => 'O campo :attribute já foi utilizado.',
    'uploaded'             => 'Falha no upload do campo :attribute.',
    'url'                  => 'O formato do campo :attribute é inválido.',
    'uuid'                 => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensagem-personalizada',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];