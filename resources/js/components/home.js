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
        const ProdutosCarrinho = () => {
            return this.state.carrinho.map((produto, index) =>
                <div key={index}>
                    <div className="tabcontent float-left">
                        <img src={produto.imagem} width="10%" className="float-left"></img>
                        <div className="clear-both float-left"></div>
                        <h5 className="float-left">{produto.nome}</h5>
                        <div className="clear-both"></div>
                        <span className="float-left">R$ {produto.valor},00</span>
                        <button className="btn btn-danger float-right" onClick={this.removeProduto.bind(this, produto.id_produto)}>Remove</button>
                    </div>
                </div>
            )
        }

        const ModalCarrinho = ({ handleClose, show }) => {
            const showHideClassName = show ? 'modal display-block' : 'modal display-none';

            return (
                <div className={showHideClassName}>
                    <div className='modal-main card'>
                        <div className='card_body md-col-12'>
                            <button onClick={handleClose} className='btn btn-primary float-right'>X</button>
                        </div>
                        <ProdutosCarrinho />
                    </div>
                </div>
            )
        }

        const Carrinho = (props) => {
            return (
                <div className="carrinho" onClick={this.showModal.bind(this)}>
                    <span className="float-right qtd_carrinho">{ this.state.carrinho.length }</span>
                    <img src="icons/cart.svg" width="30px" className="float-right"></img>
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
                            <QtdMng qtd={0} produto={produto.id_produto} />
                            <div className="clear-both"></div>
                            <br />
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
                <ModalCarrinho show={this.state.showModal} handleClose={this.hideModal.bind(this)} />
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
                        carrinho: carrinho.produtos,
                        total_carrinho: carrinho.total,
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
                        carrinho: carrinho.produtos,
                        total_carrinho: carrinho.total,
                    });
                    if(carrinho.produtos.length==0){
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
                    //console.log(carrinho.produtos);
                    this.setState({
                        carrinho: carrinho.produtos,
                        total_carrinho: carrinho.total,
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
