<?php

class ConfigEmailValidator
{
    public function validate($data, $id = null)
    {
        $rules = [
            'email' => 'required|email',
            'servidor' => 'required',
            'porta' => 'required|numeric'
        ];

        $messages = [
            'email.required' => 'O campo <b>email</b> é obrigatório.',
            'email.email' => 'Formato do <b>email</b> inválido.',
            'servidor.required' => 'O campo <b>servidor SMTP</b> é obrigatório.',
            'porta.required' => 'O campo <b>porta</b> é obrigatório.',
            'porta.numeric' => 'O campo <b>porta</b> deve conter apenas valores numéricos.'
        ];

        if (!$id) {
            $rules['senha'] = 'required';
            $messages['senha.required'] =  'O campo <b>senha</b> é obrigatório.';
        }

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $errors = implode('<br>', array_values($validator->messages()->all()));
            throw new InvalidArgumentException($errors);
        }

        return true;
    }
}
