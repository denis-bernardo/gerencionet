<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{URL::route('admin.index')}}">
            {{Session::get('config')['nome_estabelecimento']  ? Session::get('config')['nome_estabelecimento'] . ' | ' : '' }}
            Gerencionet
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown dropdown-birthdate">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                @if (count($birthDates) > 0)
                    <span class="badge">{{count($birthDates)}}</span>
                @endif
                <i class="fa fa-birthday-cake fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                @if (count($birthDates) > 0)
                    @foreach($birthDates as $k => $v)
                        <li>
                            <a href="javascript:void(0)" class="birthdate-send" data-id="{{$v->id}}">
                                <div>
                                    <strong>{{$v->nome}}</strong>
                                    <div class="pull-right text-muted">
                                        <span class="label label-info">{{\Carbon\Carbon::parse($v->data_nascimento)->diffInYears()}} anos</span>
                                    </div>
                                    <div class="pull-right text-muted">
                                        <span class="label label-primary">{{\Carbon\Carbon::parse($v->data_nascimento)->toFormattedDateString()}}</span>
                                    </div>
                                </div>
                                <div><label class="label label-success">Enviar e-mail</label></div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <li>
                        <a>
                            <div>
                                Não há aniversáriantes este mês
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <!-- /.dropdown -->
        <li class="dropdown dropdown-stock">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                @if (count($stockNotification) > 0)
                    <span class="badge">{{count($stockNotification)}}</span>
                @endif
                <i class="fa fa-cubes fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                @if (count($stockNotification) > 0)
                    @foreach($stockNotification as $k => $v)
                        <li>
                            <a href="{{URL::route('admin.estoque.edit', [$v->id])}}">
                                <div>
                                    <strong>{{$v->item}}</strong>
                                    <span class="pull-right text-muted">
                                        <em>Abaixo do estipulado</em>
                                    </span>
                                </div>
                                <div><label class="label label-danger">Quantidade atual: {{$v->quantidade}}</label></div>
                            </a>
                        </li>
                    @endforeach
                @else
                    <li>
                        <a>
                            <div>
                                Não há itens abaixo do estoque
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="dropdown dropdown-debits">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                @if (count($contas) > 0)
                    <span class="badge">{{count($contas)}}</span>
                @endif
                <i class="fa fa-money fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
            @if (count($contas) > 0)
                @foreach($contas as $k => $v)
                    <li>
                        <a href="{{URL::route('admin.contas.edit', [$v['id']])}}">
                            <div>
                                {{$v['nome']}}
                                <span class="pull-right text-muted small">Próx. do vencimento</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            @else
                <li>
                    <a>
                        <div>
                            Não há contas próximas do vencimento
                        </div>
                    </a>
                </li>
            @endif
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="javascript:void(0)"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->nome }}</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->    
</nav>