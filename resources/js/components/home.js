import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Home extends Component {

    constructor(props) {
        super(props);

        this.state = {
            isLoading: true,
            produtos: [],
            categorias: [],
        };
    }

    componentDidMount() {
        if(window.csrf_token!=null){
            this.setState({
                csrf_token: window.csrf_token,
            });
        }

        this.getCategorias();
    }

    render() {

        const Produtos = (props) => {
            if(this.state.produtos.length>0){
                return this.state.produtos.map((produto, index) =>
                    <div>
                        <div className="tabcontent" key={index}>
                            <img src={produto.imagem} width="20%" className="float-left"></img>
                            <div className="clear-both"></div>
                            <h3 className="">{produto.nome}</h3>
                            <span>R$ {produto.valor},00</span>
                        </div>
                        <div className="clear-both"></div>
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
                    <div className="item">
                        <button className={this.state.cat_selected == categoria.id_categoria ? 'active' : ''} onClick={this.getProdutos.bind(this, categoria.id_categoria)} key={categoria.id_categoria}>{categoria.nome}</button>
                    </div>
                )
            }

            return (
                <span className='float-left'> Sem categorias </span>
            )
        }


        return(
            <div className="card-body">
                <div className="tab">
                    <Categorias />
                </div>
            </div>
        );
    }

    getCategorias(){
        console.log("here");
        var url = '/categorias/all';
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data!=undefined && data.result=="success"){
                    this.setState({
                        categorias: data.categorias,
                    });
                }
                this.setState({ isLoading: false });
            });
    }

    getProdutos(id_categoria) {
        this.setState(
            {cat_selected: id_categoria}
        );

        var url = '/admin/produtos/'+id_categoria;
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

    showModal(){
        this.setState({ show: true });
    }

    hideModal(){
        this.setState({ show: false });
    }
}

if (document.getElementById('home')) {
    ReactDOM.render(<Home />, document.getElementById('home'));
}
