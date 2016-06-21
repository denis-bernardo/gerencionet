<?php

class ConfigController extends BaseController {

    protected $validator;
    protected $configEmail;
    protected $config;

    public function __construct(
        ConfigEmailValidator $validator,
        ConfigEmail $configEmail,
        ConfigGeral $config,
        ConfigValidator $validatorConfig
    )
    {
        $this->beforeFilter('csrf', ['on' => 'put', 'post']);
        $this->validator = $validator;
        $this->configEmail = $configEmail;
        $this->config = $config;
        $this->validatorConfig = $validatorConfig;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $configEmail = $this->configEmail->find(1);
        $config = $this->config->find(1);
        return View::make(
            'config.index',
            [
                'configEmail' => $configEmail,
                'config' => $config
            ]
        );
	}

    /**
     * Store General Configs
     *
     * @return Response
     */
    public function gerais()
    {
        try {
            $data = Input::all();
            $this->validatorConfig->validate($data);
            $this->config->fill($data)->save();
            Session::flash('message', 'Configurações salvas com sucesso!');
            Session::forget('config');
            return Redirect::route('admin.config.index');
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.config.index')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Update General Configs
     *
     * @return Response
     */
    public function geraisUpdate($id)
    {
        try {
            $data = Input::all();
            $this->validatorConfig->validate($data);
            $this->config->find($id)->fill($data)->save();
            Session::flash('message', 'Configurações editadas com sucesso!');
            Session::forget('config');
            return Redirect::route('admin.config.index');
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.config.index')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Store Emails Configs
     *
     * @return Response
     */
    public function emails()
    {
        try {
            $data = Input::all();
            $this->validator->validate($data);
            $data['senha'] = Crypt::encrypt($data['senha']);
            $this->configEmail->fill($data)->save();
            Session::flash('message', 'Configurações de email salvas com sucesso!');
            Session::forget('config');
            return Redirect::route('admin.config.index');
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.config.index')->withErrors($e->getMessage())->withInput(Input::except('senha'));
        }
    }

    /**
     * Update a email config
     *
     * @return Response
     */
    public function emailsUpdate($id)
    {
        try {
            $data = Input::all();
            $this->validator->validate($data, $id);
            if (isset($data['senha'])) {
                $data['senha'] = Crypt::encrypt($data['senha']);
            }
            $this->configEmail->find($id)->fill($data)->save();
            Session::flash('message', 'Configurações de email editadas com sucesso!');
            Session::forget('config');
            return Redirect::route('admin.config.index');
        } catch (InvalidArgumentException $e) {
            return Redirect::route('admin.config.index')->withErrors($e->getMessage())->withInput(Input::except('senha'));
        }
    }

    public function testarEnvio()
    {
        Mail::send('emails.teste', array(''), function($message)
        {
            $message->to(Session::get('configEmail')['email'], 'Gerencionet')->subject('Teste de configurações');
        });

        if(count(Mail::failures()) > 0) {
            return Response::json('Falha ao enviar email, favor verificar novamente as configurações.', 400);
        } else {
            return Response::json('Configuração bem sucedida!', 200);
        }
    }
}

