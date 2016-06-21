<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
            <form action="{{URL::route('admin.busca.store')}}" method="POST">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control tel-mask" placeholder="Buscar cliente" name="telefone" required>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <!-- /input-group -->
            </li>
            <li>
                <a href="{{URL::route('admin.index')}}"><i class="fa fa-dashboard fa-fw"></i> Painel</a>
            </li>
            <li>
                <a href="{{URL::route('admin.pedidos.index')}}"><i class="fa fa-shopping-cart fa-fw"></i> Pedidos</a>
            </li>            
            <li>
                <a href="{{URL::route('admin.produtos.index')}}"><i class="fa fa-cutlery fa-fw"></i> Produtos</a>
            </li>
            <li>
                <a href="{{URL::route('admin.categorias.index')}}"><i class="fa fa-sitemap fa-fw"></i> Categorias</a>
            </li>
            <li>
                <a href="{{URL::route('admin.estoque.index')}}"><i class="fa fa-cubes fa-fw"></i> Estoque</a>
            </li>
            <li>
                <a href="{{URL::route('admin.unidades.index')}}"><i class="fa fa-bars fa-fw"></i> Unidades</a>
            </li>
            <li>
                <a href="{{URL::route('admin.mesas.index')}}"><i class="fa fa-ticket fa-fw"></i> Mesas</a>
            </li>
            <li>
                <a href="{{URL::route('admin.contas.index')}}"><i class="fa fa-money fa-fw"></i> Contas a pagar</a>
            </li>
            <li>
                <a href="{{URL::route('admin.clientes.index')}}"><i class="fa fa-users fa-fw"></i> Clientes</a>
            </li>
            <li>
                <a href="{{URL::route('admin.funcionarios.index')}}"><i class="fa fa-users fa-fw"></i> Funcionários</a>
            </li>
            <li>
                <a href="{{URL::route('admin.usuarios.index')}}"><i class="fa fa-users fa-fw"></i> Usuários</a>
            </li>
            <li>
                <a href="{{URL::route('admin.config.index')}}"><i class="fa fa-gears fa-fw"></i> Configurações</a>
            </li>
<!--            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="blank.html">Blank Page</a>
                    </li>
                    <li>
                        <a href="login.html">Login Page</a>
                    </li>
                </ul>
                 /.nav-second-level 
            </li>-->
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->