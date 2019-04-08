import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Categoria_produtos extends Component {

    constructor(props) {
        super(props);

        this.state = {
            isLoading: true,
            produtos: [],
            categorias: [],
            cat_selected: 0,
            show: false,
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
        const Modal = ({ handleClose, show }) => {
            const showHideClassName = show ? 'modal display-block' : 'modal display-none';

            return (
                <div className={showHideClassName}>
                    <div className='modal-main card'>
                        <div className='card_body md-col-12'>
                            <button onClick={handleClose} className='btn btn-danger float-right'>X</button>
                        </div>

                        <form method="POST" action="/admin/produto/create" enctype="multipart/form-data">
                            <input type="hidden" value="PUT" name="_method"></input>
                            <input type="hidden" value={this.state.csrf_token} name="_token"></input>
                            <div className="col-md-12">
                                <label className="label">Categoria</label>
                                <select className="form-control" type="text" name="categoria">
                                    <CategoriasOption />
                                </select>
                            </div>
                            <div className="col-md-12">
                                <label className="label">Nome</label>
                                <input className="form-control" type="text" name="nome"></input>
                            </div>
                            <div className="col-md-12">
                                <label className="label">Descrição</label>
                                <textarea className="form-control" type="text" name="descricao"></textarea>
                            </div>
                            <div className="col-md-12">
                                <label className="label">Valor</label>
                                <input className="form-control" type="number" name="valor"></input>
                            </div>
                            <div className="col-md-12">
                                <label>Imagem</label>
                                <input type='file' id="primaryImage" name="primaryImage" accept="image/*" className="form-control" />
                            </div>
                            <br />
                            <div className="col-md-12">
                                <input type="submit" value="Adicionar" className="btn btn-success float-right"></input>
                            </div>

                        </form>
                    </div>
                </div>
            )
        }

        const Produtos = (props) => {
            if(this.state.produtos.length>0){
                return this.state.produtos.map((produto, index) =>
                    <div className="tabcontent" key={index}>
                        <img src={produto.imagem} width="100px"></img>
                        <h3>{produto.nome}</h3>
                        <span>R$ {produto.valor},00</span>
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
                    <button className={this.state.cat_selected == categoria.id_categoria ? 'active' : ''} onClick={this.getProdutos.bind(this, categoria.id_categoria)} key={categoria.id_categoria}>{categoria.nome}</button>
                )
            }

            return (
                <span className='float-left'> Sem categorias </span>
            )
        }

        const CategoriasOption = (props) =>{
            if(this.state.categorias.length>0){
                return this.state.categorias.map((categoria, index) =>
                    <option key={categoria.id_categoria} value={categoria.id_categoria}>{categoria.nome}</option>
                )
            }else{
                return(
                    <option>Cadastre uma Categoria</option>
                )
            }
        }

        return(
            <div className="card-body">
                <Modal show={this.state.show} handleClose={this.hideModal.bind(this)} />
                <div className="form-group">
                    <div className="col-md-10">
                        <input name="search" type="text" className="form-control float-left">
                        </input>
                    </div>
                    <button className="btn btn-success">Search</button>
                </div>
                <button className="btn btn-primary float-right" onClick={this.showModal.bind(this)}>Adicionar Produto</button>
                <br />
                <br />
                <div className="tab">
                    <Categorias />
                </div>
                <Produtos />
            </div>
        );
    }

    getCategorias(){
        var url = 'http://localhost:8000/admin/categorias/all';
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if(data!=undefined){
                    this.setState({
                        categorias: data,
                    });

                    this.getProdutos(data[0].id_categoria);
                }
                this.setState({ isLoading: false });
            });
    }

    getProdutos(id_categoria) {
        this.setState(
            {cat_selected: id_categoria}
        );

        var url = 'http://localhost:8000/admin/produtos/'+id_categoria;
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

if (document.getElementById('categoria_produtos')) {
    ReactDOM.render(<Categoria_produtos />, document.getElementById('categoria_produtos'));
}
