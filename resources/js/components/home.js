import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Home extends Component {

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
        this.getCategorias();
    }

    render() {
        const Carrinho = (props) => {
            return (
                <div className="carrinho">
                    <span className="float-right qtd_carrinho">{ this.state.qtd_produtos }</span>
                    <a href="/cliente/pedido"><img src="icons/cart.svg" width="30px" className="float-right"></img></a>
                    <span>Total: R$ { this.state.total_carrinho },00</span>
                </div>
            )
        }

        const QtdMng = (props) => {
            return (
                <div>
                    <button className="btn btn-success float-right" onClick={ this.addProduto.bind(this, props.produto) }><img src="icons/plus.svg"></img></button>
                        <span className="float-right span-border">{ props.qtd }</span>
                    <button className="btn btn-primary float-right" onClick={ this.removeProduto.bind(this, props.produto)}><img src="icons/minus.svg" className="float-right"></img></button>
                </div>
            )
        }

        const Produtos = (props) => {
            if(this.state.produtos.length>0){
                var qtd = 0;
                return this.state.produtos.map((produto, index) =>
                    <div key={produto.id_produto}>
                        <div className="tabcontent float-left">
                            <img src={produto.imagem} width="20%" className="float-left"></img>
                            <div className="clear-both float-left"></div>
                            <h3 className="float-left">{produto.nome}</h3>
                            <div className="clear-both"></div>
                            <span className="float-left">R$ {produto.valor},00</span>
                            <div className="clear-both"></div>
                            <br />
                            <button className="btn btn-success float-right" onClick={this.addProduto.bind(this, produto.id_produto)}>Add</button>
                        </div>
                    </div>
            )
            }else{
                return (
                    <div className="tabcontent">
                        <span> Categoria Vazia </span>
                    </div>
                )
            }
        }

        const Categorias = (props) =>{
            // View de Categorias
            if(this.state.isLoading){
                return(
                    <h3>Carregando... </h3>
                )
            }
            else if(this.state.categorias.length>0){
                return this.state.categorias.map((categoria, index) =>
                    <div className="item" key={index}>
                        <button className={this.state.cat_selected == categoria.id_categoria ? 'active' : ''} onClick={this.getProdutos.bind(this, categoria.id_categoria)} key={categoria.id_categoria}>{categoria.nome}</button>
                    </div>
                )
            }

            return (
                <span className='float-left'> Sem categorias </span>
            )
        }


        return(
            <div className="">
                <Carrinho />
                <div className="tab">
                    <Categorias />
                </div>
                <Produtos />
            </div>
        );
    }

    getCategorias(){
        var url = '/categorias/all';
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if(data!=undefined && data.result=="success"){
                    this.setState({
                        categorias: data.categorias,
                        cat_selected: data.categorias[0].id_categoria,
                    });
                    this.getProdutos(data.categorias[0].id_categoria);
                }
                this.setState({ isLoading: false });
            });
    }

    getProdutos(id_categoria) {
        this.setState(
            {cat_selected: id_categoria}
        );

        var url = '/produtos_categoria/'+id_categoria;
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if(data!=undefined){
                    this.setState({
                        produtos: data,
                    });
                }
                this.setState({ isLoading: false });
            });
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

    showModal(){
        this.setState({ showModal: true });
    }

    hideModal(){
        this.setState({ showModal: false });
    }
}

if (document.getElementById('home')) {
    ReactDOM.render(<Home />, document.getElementById('home'));
}
