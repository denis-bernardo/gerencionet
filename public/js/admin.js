$(function () {
    // switch between languages
    numeral.language('pt-br');

    if ($('.table-list')[0]) {
        $('.table-list').DataTable({
            order: [[0, "desc"]],
            responsive: true,
            "language": {
                "sProcessing": "Processando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Nenhum resultado encontrado.",
                "sEmptyTable": "Nenhum registro disponível para tabela",
                "sInfo": "Mostrando _START_ ao _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Carregando...",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sLast": "Último",
                    "sNext": "Próximo",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar coluna de forma ascendente",
                    "sSortDescending": ": Ordenar coluna de forma descendente"
                }
            }
        });
    }

    //Busca CEP
    $('.btn-cep').click(function () {
        if ($('.cep').val().length == 8) {
            var cep = $('.cep').val();
            $.ajax({
                url: 'http://api.postmon.com.br/v1/cep/' + cep,
                success: function (data) {
                    $('.bairro').val(data.bairro);
                    $('.cidade').val(data.cidade);
                    $('.logradouro').val(data.logradouro);
                    $('.estado').val(data.estado_info.nome);
                },
                error: function () {
                    return false;
                }
            });
        }
    });

    //Masks    
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

    $('.tel-mask').mask(SPMaskBehavior, spOptions);
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.datepicker').datetimepicker({
        locale: 'pt_br',
        format: 'DD/MM/YYYY'
    });
    $('.date').mask('00/00/0000');

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var message = $(this).data('message');
        var $this = $(this);
        bootbox.dialog({
            title: "Alerta",
            message: message,
            buttons: {
                success: {
                    label: "DELETAR",
                    className: "btn-danger",
                    callback: function () {
                        $this.submit();
                    }
                },
                danger: {
                    label: "CANCELAR",
                    className: "btn-default",
                    callback: function () {
                        bootbox.hideAll();
                    }
                }
            }
        });
    });

    $('.info').popover({
        placement: 'top',
        trigger: 'hover'
    });

    $('.show-fields-user').click(function () {
        $(this).parent().hide();
        $('.field-disabled').each(function () {
            $(this).show();
            $(this).find('input').removeAttr('disabled');
        });
    });


    $('.add-estoque').click(function () {
        $('.estoque-modal').modal();
    });

    //AJAX ITENS ESTOQUE PRODUTO
    $(document).on('change', '.estoque-list', function () {
        var id = $(this).val();
        if (id !== 0) {
            $('.estoque-qtd').removeAttr('readonly');
            $('.estoque-info').removeClass('hide');
            $.ajax({
                url: '/admin/estoque/' + id,
                method: 'GET',
                success: function (data) {
                    var qtd = data.quantidade <= data.minimo ? '<span class="label label-danger">' + data.quantidade + '</span>' : '<span class="label label-success">' + data.quantidade + '</span>';
                    $('.estoque-info > label').html(data.item);
                    $('.estoque-info-cod').html(data.id);
                    $('.estoque-info-qtd').html(qtd);
                    $('.estoque-info-preco').html(Number(data.preco).formatMoney(2, ',', '.'));
                    $('.estoque-info-preco').attr('data-preco', data.preco);
                }
            });
        }
    });

    $(document).on('click', '.estoque-add', function () {
        if ($('.estoque-qtd').val() != '') {
            var item = $('.estoque-info > label').html();
            var id = $('.estoque-info-cod').html();
            var qtd = $('.estoque-qtd').val();
            var preco = numeral().unformat($('.estoque-info-preco').html());
            var total = Number(($('.estoque-info-preco').attr('data-preco')) * qtd).toFixed(2);
            var sum = 0;
            if ($('.produto-itens tbody').children().length) {
                $('.produto-itens tbody').find('tr').each(function () {
                    if ($(this).data('id') == id) {
                        $('.produto-itens tbody tr[data-id="' + id + '"]').remove();
                        $('.produto-itens tbody').append('<tr data-id="' + id + '"><td>' + item + '<input type="hidden" name="id_estoque[' + id + '][quantidade]" value="' + qtd + '"><input type="hidden" name="id_estoque[' + id + '][valor]" value="' + total + '"></td><td>' + qtd + '</td><td>' + Number(preco).formatMoney(2, ',', '.') + '</td><td class="produto-itens-total">' + Number(total).formatMoney(2, ',', '.') + '</td><td><a href="javascript:void(0)" class="remove-item btn btn-danger"><i class="fa fa-trash-o"></i></a></td></tr>');
                    } else {
                        $('.produto-itens tbody').append('<tr data-id="' + id + '"><td>' + item + '<input type="hidden" name="id_estoque[' + id + '][quantidade]" value="' + qtd + '"><input type="hidden" name="id_estoque[' + id + '][valor]" value="' + total + '"></td><td>' + qtd + '</td><td>' + Number(preco).formatMoney(2, ',', '.') + '</td><td class="produto-itens-total">' + Number(total).formatMoney(2, ',', '.') + '</td><td><a href="javascript:void(0)" class="remove-item btn btn-danger"><i class="fa fa-trash-o"></i></a></td></tr>');
                    }
                });
            } else {
                $('.produto-itens tbody').append('<tr data-id="' + id + '"><td>' + item + '<input type="hidden" name="id_estoque[' + id + '][quantidade]" value="' + qtd + '"><input type="hidden" name="id_estoque[' + id + '][valor]" value="' + total + '"></td><td>' + qtd + '</td><td>' + Number(preco).formatMoney(2, ',', '.') + '</td><td class="produto-itens-total">' + Number(total).formatMoney(2, ',', '.') + '</td><td><a href="javascript:void(0)" class="remove-item btn btn-danger"><i class="fa fa-trash-o"></i></a></td></tr>');
            }
            $('.produto-itens-total').each(function () {
                sum += numeral().unformat($(this).text());
            });
            $('.preco_custo').val(Number(sum).formatMoney(2, ',', '.'));
            if ($('.margem').val() != '') {
                var total = Number(($('.margem').val() / 100) * numeral().unformat($('.preco_custo').val())) + numeral().unformat($('.preco_custo').val());
                $('.preco_final').val(Number(total).formatMoney(2, ',', '.'));
            }
        }
    });

    $(document).on('click', '.remove-item', function () {
        $(this).closest('tr').remove();
        var sum = 0;
        $('.produto-itens-total').each(function () {
            sum += numeral().unformat($(this).text());
        });
        $('.preco_custo').val(Number(sum).formatMoney(2, ',', '.'));
        if ($('.margem').val() != '') {
            var total = Number(($('.margem').val() / 100) * numeral().unformat($('.preco_custo').val())) + numeral().unformat($('.preco_custo').val());
            $('.preco_final').val(Number(total).formatMoney(2, ',', '.'));
        }
    });

    $('.margem').keyup(function () {
        if ($('.preco_custo').val() != '') {
            var total = Number(($(this).val() / 100) * numeral().unformat($('.preco_custo').val())) + numeral().unformat($('.preco_custo').val());
            $('.preco_final').val(Number(total).formatMoney(2, ',', '.'));
        }
    });

    $('.delete-product').click(function () {
        $('.delete-product-modal').modal();
    });
    
    $('.delete-pedido').click(function () {
        $('.delete-pedido-modal').modal();
    });

    $('.add-produto').click(function () {
        $('.produto-modal').modal();
    });

    $(document).on('click', '.prod-ped-half', function () {
        var id = $(this).attr('data-id');
        var preco = $(this).closest('tr').find('.td-preco').html();
        $(this).attr('data-preco', preco);
        $('.produto-add-half').attr('data-prod', id);
        $('.produto-half-modal').modal();
    });

    //PEDIDOS ENTREGA
    $('.select-entrega').change(function () {
        if ($(this).val() == 1) {
            $('.col-entrega, .taxa-group, .entregador-group').show();
            $('.col-entrega').find('input').each(function () {
                $(this).removeAttr('disabled');
            });
            $('.taxa_entrega').removeAttr('disabled');
            $('.entregador').removeAttr('disabled');
        } else {
            $('.col-entrega, .taxa-group, .entregador-group').hide();
            $('.col-entrega').find('input').each(function () {
                $(this).attr('disabled', 'disabled');
            });
            $('.taxa_entrega').attr('disabled', 'disabled');
            $('.entregador').attr('disabled', 'disabled');
        }
    });

    //BUSCA CLIENTE PEDIDO
    $('.buscar-cliente').click(function () {
        if ($('.telefone-cliente').val() != '') {
            var telefone = $('.telefone-cliente').val();
            $.ajax({
                url: '/admin/busca',
                method: 'POST',
                data: {telefone: telefone},
                success: function (data) {
                    if (data.length) {
                        $('.cliente-404').addClass('hide');
                        $('.pedido-idcliente').val(data[0].id);
                        $('.pedido-nome').val(data[0].nome);
                        $('.pedido-email').val(data[0].email);
                        $('.pedido-telefone').val(data[0].telefone);
                        $('.pedido-celular').val(data[0].celular);
                        $('.pedido-cep').val(data[0].cep);
                        $('.pedido-logradouro').val(data[0].logradouro);
                        $('.pedido-numero').val(data[0].numero);
                        $('.pedido-bairro').val(data[0].bairro);
                        $('.pedido-complemento').val(data[0].complemento);
                        $('.pedido-cidade').val(data[0].cidade);
                        $('.pedido-estado').val(data[0].estado);
                    } else {
                        $('.cliente-404').removeClass('hide');
                    }
                }
            });
        }
    });

    //ADICIONA UM PRODUTO AO PEDIDO
    $('.produto-add-pedido').click(function () {
        var count = Number($('.produtos-pedido tr').length);
        var sum = 0;
        var id = $(this).attr('data-id');
        var ref = $(this).closest('tr').find('.produto-info-ref').html();
        var nome = $(this).closest('tr').find('.produto-info-produto').html();
        var preco = numeral().unformat($(this).closest('tr').find('.produto-info-preco').html());
        var precoPt = $(this).closest('tr').find('.produto-info-preco').html();
        var remove = '<a href="javascript:void(0)" class="prod-ped-remove btn btn-danger" data-preco="' + preco + '"><i class="fa fa-trash-o"></i></a>';
        var plus = '<a href="javascript:void(0)" data-id="' + id + '" class="prod-ped-plus btn btn-default" title="Adicionar itens"><i class="fa fa-plus"></i></a>';
        var minus = '<a href="javascript:void(0)" data-id="' + id + '" class="prod-ped-minus btn btn-default" title="Remover itens"><i class="fa fa-minus"></i></a>';
        var half = '<a href="javascript:void(0)" data-id="' + id + '" class="prod-ped-half btn btn-default" title="Fracionar item"><i class="fa fa-pie-chart"></i></a>';
        var produto = '<tr data-id="' + id + '"><input type="hidden" name="produto[' + count + '][id]" value="' + id + '"><input type="hidden" class="preco-hidden" name="produto[' + count + '][preco]" value="' + preco + '"><td>' + ref + '</td><td class="td-prod">' + nome + '</td><td class="td-preco">' + precoPt + '</td><td>' + half + plus + minus + remove + '</td></tr>';
        $('.produtos-pedido tbody').append(produto);
        $('.td-preco').each(function () {
            sum += numeral().unformat($(this).text());
        });
        $('.preco_total').val(sum.formatMoney(2, ',', '.'));
        if ($('.taxa_entrega')[0]) {
            sum = sum + numeral().unformat($('.taxa_entrega').val());
        }
        $('.preco_final').val(sum.formatMoney(2, ',', '.'));
    });

    //REMOVE UM PRODUTO DO PEDIDO
    $(document).on('click', '.prod-ped-remove', function () {
        $('.preco_total').val(Number(numeral().unformat($('.preco_total').val()) - $(this).attr('data-preco')).formatMoney(2, ',', '.'));
        $('.preco_final').val(Number(numeral().unformat($('.preco_final').val()) - $(this).attr('data-preco')).formatMoney(2, ',', '.'));
        $(this).closest('tr').remove();
    });

    //REMOVE UM ITEM DO PRODUTO AO PEDIDO
    $(document).on('click', '.prod-ped-minus', function () {
        $('.estoque-info table tbody tr').remove();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '/admin/produtos/estoque/' + id,
            success: function (data) {
                $.each(data, function (key, value) {
                    $('.estoque-info table tbody').append('<tr><td class="td-estoque">' + value.item + '</td><td class="td-estoque-qtd">' + value.quantidade + '</td><td><a class="item-remove btn btn-danger" data-prod="' + id + '" data-id="' + value.id + '"><i class="fa fa-trash-o"></i></a></td></tr>')
                });
            }
        });
        $('.itens-modal').modal();
    });

    $(document).on('click', '.prod-ped-plus', function () {
        $('.estoque-ped-modal').modal();
        var id = $(this).attr('data-id');
        $('.item-add').attr('data-prod', id);
    });

    $(document).on('click', '.item-remove', function () {
        var idprod = $(this).attr('data-prod');
        var id = $(this).attr('data-id');
        var name = $(this).closest('tr').find('.td-estoque').html();
        var qtd = $(this).closest('tr').find('.td-estoque-qtd').html();
        $('.produtos-pedido').find('tr').each(function () {
            if ($(this).attr('data-id') == idprod) {
                $(this).find('.td-prod').append('<label class="label label-danger">s/ ' + name + '<input type="hidden" name="produto[' + idprod + '][removidos][][id]" value="' + id + '"><input type="hidden" name="produto[' + idprod + '][removidos][][name]" value="' + name + '"><input type="hidden" name="produto[' + idprod + '][removidos][][quantidade]" value="' + qtd + '"><i class="fa fa-close"></i></label>');
                var i = 0;
                $(this).find('.td-prod').each(function () {
                    i = $(this).find('.label-danger').length;
                    $(this).find('.label-danger:last-child').each(function () {
                        $(this).find('input').each(function () {
                            var oldAttr = $(this).attr('name');
                            var newAttr = oldAttr.replace(/(\[\])/, '[' + i + ']');
                            $(this).attr('name', newAttr);
                        });
                    });
                });
            }
        });
    });

    $(document).on('click', '.td-prod .label-danger i', function () {
        $(this).closest('label').remove();
    });

    $(document).on('click', '.td-prod .label-success i', function () {
        var preco = $(this).closest('label').attr('data-preco');
        var sub = Number($(this).closest('tr').find('.td-preco').html()) - Number(preco);
        var total = 0;
        $(this).closest('tr').find('.td-preco').html(sub);
        $(this).closest('label').remove();

        $('.td-preco').each(function () {
            total += Number($(this).text());
        });
        $('.preco_total').val(total);
        $('.preco_final').val(total);
    });

    $(document).on('click', '.td-prod .label-primary i', function () {
        var old = $(this).closest('tr').find('.prod-ped-half').attr('data-preco');
        var total = 0;
        $(this).closest('tr').find('.td-preco').html(old);
        $(this).closest('label').remove();

        $('.td-preco').each(function () {
            total += Number($(this).text());
        });
        $('.preco_total').val(total);
        $('.preco_final').val(total);
    });

    $(document).on('click', '.item-add', function () {
        if ($(this).prev().find('input').val() == '') {
            return false;
        } else {
            var idprod = $(this).attr('data-prod');
            var id = $(this).attr('data-id');
            var name = $(this).closest('tr').find('.td-estoque').html();
            var qtd = $(this).prev().find('input').val();
            var preco = Number($(this).closest('tr').find('.td-estoque-preco').html()) * Number(qtd);
            var sum = 0;
            var total = 0;
            $('.produtos-pedido').find('tr').each(function () {
                if ($(this).attr('data-id') == idprod) {
                    $(this).find('.td-prod').append('<label class="label label-success" data-preco="' + preco + '">c/ ' + name + '<input type="hidden" name="produto[' + idprod + '][opcionais][][id]" value="' + id + '"><input type="hidden" name="produto[' + idprod + '][opcionais][][name]" value="' + name + '"><input type="hidden" name="produto[' + idprod + '][opcionais][][preco]" value="' + preco + '"><input type="hidden" name="produto[' + idprod + '][opcionais][][quantidade]" value="' + qtd + '"><i class="fa fa-close"></i></label>');
                    sum = Number($(this).find('.td-preco').html()) + Number(preco);
                    $(this).find('.td-preco').html(sum);
                    $(this).find('.preco-hidden').val(sum);
                    var i = 0;
                    $(this).find('.td-prod').each(function () {
                        i = $(this).find('.label-success').length;
                        $(this).find('.label-success:last-child').each(function () {
                            $(this).find('input').each(function () {
                                var oldAttr = $(this).attr('name');
                                var newAttr = oldAttr.replace(/(\[\])/, '[' + i + ']');
                                $(this).attr('name', newAttr);
                            });
                        });
                    });
                }
            });
            $('.td-preco').each(function () {
                total += Number($(this).text());
            });
            $('.preco_total').val(total);
            $('.preco_final').val(total);
            $('.opcionais_input').val('');
        }
    });


    $('.modal').on('hidden.bs.modal', function (e) {
        $(this).find('input[type="text"]').val('');
    });


    $(document).on('click', '.produto-add-half', function () {
        var idprod = $(this).attr('data-prod');
        var id = $(this).attr('data-id');
        var name = $(this).closest('tr').find('.produto-half-produto').html();
        var preco = $(this).closest('tr').find('.produto-half-preco').html();
        var sum = 0;
        var total = 0;
        $('.produtos-pedido').find('tr').each(function () {
            if ($(this).attr('data-id') == idprod) {
                $(this).find('.td-prod').append('<label class="label label-primary" data-preco="' + preco + '">meia ' + name + '<input type="hidden" name="produto[' + idprod + '][composto][][id]" value="' + id + '"><input type="hidden" name="produto[' + idprod + '][composto][][name]" value="' + name + '"><input type="hidden" name="produto[' + idprod + '][composto][][preco]" value="' + preco + '"><i class="fa fa-close"></i></label>');
                sum = (Number($(this).find('.td-preco').html()) + Number(preco)) / 2;
                $(this).find('.td-preco').html(sum);
                $(this).find('.preco-hidden').val(sum);
                var i = 0;
                $(this).find('.td-prod').each(function () {
                    i = $(this).find('.label-primary').length;
                    $(this).find('.label-primary:last-child').each(function () {
                        $(this).find('input').each(function () {
                            var oldAttr = $(this).attr('name');
                            var newAttr = oldAttr.replace(/(\[\])/, '[' + i + ']');
                            $(this).attr('name', newAttr);
                        });
                    });
                });
            }
        });
        $('.td-preco').each(function () {
            total += Number($(this).text());
        });
        $('.preco_total').val(total);
        $('.preco_final').val(total);
    });

    if ($('.id_mesa').val() != '') {
        $('.col-entrega, .taxa-group').hide();
        $('.col-entrega').find('input').each(function () {
            $(this).attr('disabled', 'disabled');
        });
        $('.taxa_entrega').attr('disabled', 'disabled');
    } else {
        $('.col-entrega, .taxa-group').show();
        $('.col-entrega').find('input').each(function () {
            $(this).removeAttr('disabled');
        });
        $('.taxa_entrega').removeAttr('disabled');
    }

    $('.id_mesa').change(function () {
        if ($(this).val() != '') {
            $('.col-entrega, .taxa-group').hide();
            $('.col-entrega').find('input').each(function () {
                $(this).attr('disabled', 'disabled');
            });
            $('.taxa_entrega').attr('disabled', 'disabled');
        } else {
            $('.col-entrega, .taxa-group').show();
            $('.col-entrega').find('input').each(function () {
                $(this).removeAttr('disabled');
            });
            $('.taxa_entrega').removeAttr('disabled');
        }
    });

    $('.taxa_entrega').keyup(function () {
        var sum = numeral().unformat($(this).val()) + numeral().unformat($('.preco_total').val());
        $('.preco_final').val(sum.formatMoney(2, ',', '.'));
    });
    //
    //if($('.taxa_entrega')[0]){
    //    if($('.taxa_entrega').val() != '' && $('.taxa_entrega').val() != 0){
    //        var sum = numeral().unformat($('.taxa_entrega').val()) + numeral().unformat($('.preco_total').val());
    //       $('.preco_final').val(sum.formatMoney(2, ',', '.'));
    //    } else {
    //       $('.preco_final').val(Number($('.preco_total').val()).formatMoney(2, ',', '.'));
    //    }
    //}
    
    $(document).on('click', '.finish', function (){
        $('.finish-modal').modal();
        if ($('.preco_final')[0]){
            $('.finish-price span').html($('.preco_final').val());
            $('.valor-finish').val(numeral().unformat($('.preco_final').val()));
        }
    });
    
    $('.valor_recebido').keyup(function (){
        var value = numeral().unformat($(this).val());
        var total = $('.valor-finish').val();
        var sum = (value - total);
        if (value == '' || value == 0) {
            $('.troco').val('');
        } else {
            $('.troco').val(sum.formatMoney(2, ',', '.'));
        }
    });
    
    $('.finish-btn').click(function (){
        var pedido = $(this).attr('data-pedido');
        var preco = $(this).attr('data-preco');
        var action = '/admin/pedidos/'+pedido+'/finish';
        $('.valor-finish').val(preco);
        $('.finish-modal-order').modal();
        $('.finish-price span').html(Number(preco).formatMoney(2, ',', '.'));
        $('.finish-form').attr('action', action);
    });
    
    $('.valor_recebido_order').keyup(function (){
        var value = numeral().unformat($(this).val());
        var total = Number($('.valor-finish').val());
        var sum = (value - total);
        if (value == '' || value == 0) {
            $('.troco_order').val('');
        } else {
            $('.troco_order').val(sum.formatMoney(2, ',', '.'));
        }
    });

    $('.birthdate-send').click(function(){
        var userId = $(this).data('id');
        var $this = $(this);
        var count = $('.birthdate-send').length;
        var badge = $('.dropdown-birthdate').find('.badge');
        $.ajax({
            url: '/admin/birthdate/' + userId,
            method: 'POST',
            beforeSend: function () {
                $('.loading').fadeIn();
            },
            success: function(data) {
                $this.remove();
                count = count - 1
                if (count == 0) {
                    badge.remove();
                } else {
                    badge.html(count);
                }
            },
            complete: function () {
                $('.loading').fadeOut();
            }
        });

    });

    $('.alterar-senha').click(function(){
        $('#emails-senha').removeAttr('disabled');
    });

    $('.emails-testar').click(function () {
        $.ajax({
            url: '/admin/configuracoes/testar-envio',
            beforeSend: function () {
              $('.loading').fadeIn();
            },
            success: function(data){
                $('.alert-ajax').removeClass('hide alert-warning').addClass('alert-success');
                $('.alert-ajax').find('span').html(data);
            },
            error: function (jqXHR) {
                $('.alert-ajax').removeClass('hide alert-success').addClass('alert-warning');
                $('.alert-ajax').find('span').html(jqXHR.responseJSON);
                if (jqXHR.status === 500)
                    $('.alert-ajax').find('span').html('Houve um erro ao realizar o teste, tente novamente mais tarde.');
            },
            complete: function () {
                $('.loading').fadeOut();
            }
        });
    });

    if ($('.select-entrega').val() == 1) {
        $('.col-entrega, .taxa-group, .entregador-group').show();
        $('.col-entrega').find('input').each(function () {
            $(this).removeAttr('disabled');
        });
        $('.taxa_entrega').removeAttr('disabled');
        $('.entregador').removeAttr('disabled');
    } else if ($('.select-entrega').val() == 0) {
        $('.col-entrega, .taxa-group, .entregador-group').hide();
        $('.col-entrega').find('input').each(function () {
            $(this).attr('disabled', 'disabled');
        });
        $('.taxa_entrega').attr('disabled', 'disabled');
        $('.entregador').attr('disabled', 'disabled');
    }

    $('.filter-by').change(function () {
        var url = window.location.href;
        var key = $(this).data('key');
        var value = $(this).val();
        window.location.href = updateQueryStringParameter(url, key, value);
    });

});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function getCategories(id, evt)
{
    if ($(evt).hasClass('active')) {
        $(evt).removeClass('active');
        $(evt).addClass('fa-plus').removeClass('fa-minus');
        $('.list-group-item-' + id).remove();
    } else {
        $(evt).addClass('active');
        $(evt).removeClass('fa-plus').addClass('fa-minus');
        $.ajax({
            url: '/admin/categorias/' + id,
            success: function (data) {
                $.each(data, function (key, value) {
                    $('<li class="list-group-item list-group-item-' + value.parent + '"><span class="space"></span><a href="/admin/categorias/' + value.id + '/edit">' + value.nome + '</a></li>').insertAfter($(evt).parent());
                });
            }
        });
    }
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}