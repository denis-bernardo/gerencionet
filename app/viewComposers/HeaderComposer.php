<?php

class HeaderComposer
{
    public function compose($view)
    {
        $stockNotification = Estoque::select()->whereRaw('quantidade <= minimo')->get();

        if (Cookie::get('birthdates')['users']) {
            $birthDates = Cliente::select()
                ->where(DB::raw('MONTH(data_nascimento)'), '=', \Carbon\Carbon::now()->month)
                ->whereNotIn('id', Cookie::get('birthdates')['users'])
                ->get();
        } else {
            $birthDates = Cliente::select()
                ->where(DB::raw('MONTH(data_nascimento)'), '=', \Carbon\Carbon::now()->month)
                ->where('email', '!=', '')
                ->get();
        }

        $contas = Conta::select()
            ->whereBetween(
                'vencimento', [\Carbon\Carbon::now(), \Carbon\Carbon::now()->addDays(10)]
            )->where('paga', '=', 0)->get();

        $view->with(
            [
                'stockNotification' => $stockNotification,
                'birthDates' => $birthDates,
                'contas' => $contas
            ]
        );
    }
}