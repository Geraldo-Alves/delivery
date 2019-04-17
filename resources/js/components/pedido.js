import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Pedido extends Component {

    constructor(props) {
        super(props);

        this.state = {
            isLoading: true,
            produtos: [],
            categorias: [],
            cat_selected: 0,
            carrinho: [],
            total_carrinho: 0,
            qtd_produtos: 0,
            showModal: false,
        };
    }

    componentDidMount() {
        if(window.csrf_token!=null){
            this.setState({
                csrf_token: window.csrf_token,
            });
        }

        this.getCarrinho();
    }

    render() {
        const QtdMng = (props) => {
            return (
                <div>
                    <button className="btn btn-success float-right" onClick={ this.addProduto.bind(this, props.produto) }><img src="/icons/plus.svg"></img></button>
                        <div className="clear-both"></div>
                        <span className="float-right span-border">{ props.qtd }</span>
                        <div className="clear-both"></div>
                    <button className="btn btn-primary float-right" onClick={ this.removeProduto.bind(this, props.produto)}><img src="/icons/minus.svg" className="float-right"></img></button>
                </div>
            )
        }


        const ProdutosCarrinho = () => {
            return this.state.carrinho.map((produto, index) =>
                <tr key={index}>
                    <td>
                        <h6 className="float-left">{produto.nome}</h6>
                        <span className="float-left">R$ {produto.valor},00</span>
                    </td>
                    <td align="right">
                        <div className="clear-both"></div>
                        <QtdMng qtd={ produto.qtd } produto={produto.id_produto} />
                    </td>
                </tr>
            )
        }

        const Carrinho = ({ handleClose, show }) => {

            return (
                <table className="table table-striped">
                    <tbody>
                        <ProdutosCarrinho />
                        <tr>
                            <td></td>
                            <td align="right">
                                <button className="btn btn-success">Fechar Pedido</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            )
        }

        return(
            <div className="">
                <a href="/home" className="back float-left"><img src="/icons/back.svg"></img> Voltar</a>
                <br />
                <div className="clear-both"></div>
                <h4 className="float-left"><img src="/icons/cart.svg"></img> Total: </h4>
                <h4 className="float-right">R$ { this.state.total_carrinho },00 </h4>
                <Carrinho />
            </div>
        );
    }

    addProduto(id_produto){
        var url = '/cliente/add_produto/'+id_produto;
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(carrinho => {
                if(carrinho!=undefined){
                    this.setState({
                        carrinho: carrinho.pedido.produtos,
                        total_carrinho: carrinho.pedido.total,
                        qtd_produtos: carrinho.pedido.qtd_produtos,
                    });
                }
            });
    }

    removeProduto(id_produto){
        var url = '/cliente/remove_produto/'+id_produto;
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(carrinho => {
                if(carrinho!=undefined){
                    this.setState({
                        carrinho: carrinho.pedido.produtos,
                        total_carrinho: carrinho.pedido.total,
                        qtd_produtos: carrinho.pedido.qtd_produtos,
                    });
                    if(carrinho.pedido.produtos.length==0){
                        this.hideModal();
                    }
                }
            });
    }

    getCarrinho(){
        var url = '/cliente/carrinho';
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(carrinho => {
                if(carrinho!=undefined && carrinho.produtos!=0){
                    this.setState({
                        carrinho: carrinho.pedido.produtos,
                        total_carrinho: carrinho.pedido.total,
                        qtd_produtos: carrinho.pedido.qtd_produtos,
                    });
                }
            });
    }
}

if (document.getElementById('pedido')) {
    ReactDOM.render(<Pedido />, document.getElementById('pedido'));
}
