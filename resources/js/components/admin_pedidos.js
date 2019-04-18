import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class AdminPedidos extends Component {

    constructor(props) {
        super(props);

        this.state = {
            isLoading: true,
            pedidos: [],
            status: 'criado',
        };
    }

    componentDidMount() {
        if(window.csrf_token!=null){
            this.setState({
                csrf_token: window.csrf_token,
            });
        }

        this.getPedidos(this.state.status);
    }

    render() {

        const Pedidos = () => {
            return this.state.pedidos.map((pedido, index) =>
                <tr key={index}>
                    <td>
                        <h4 className="float-left">{pedido.cliente.name}</h4>
                        <div className="clear-both"></div>
                        <span className="float-left">R$ {pedido.total},00</span>
                    </td>
                    <td>
                        <span className="float-left">{pedido.status}</span>
                    </td>
                    <td>
                        <button className="btn btn-danger" onClick={this.setPedidoStatusAnterior.bind(this, pedido.id_pedido)}><img src="/icons/previous.svg"></img></button>
                        <button className="btn btn-primary" onClick={this.setPedidoProximoStatus.bind(this, pedido.id_pedido)}><img src="/icons/next.svg"></img></button>
                    </td>

                </tr>
            )
        }

        return(
            <div className="">
                <br />
                <div className="form-group col-md-6">
                    <label className="label">Status</label>
                    <select className="form-control col-md-8" onChange={this.setStatus.bind(this)} value={this.state.status}>
                        <option value="criado">Criado</option>
                        <option value="em_producao">Em produção</option>
                        <option value="pronto">Pronto</option>
                        <option value="entrega">Entrega</option>
                        <option value="concluido">Concluído</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <br />
                <table className="table table-striped">
                    <tbody>
                        <tr>
                            <th>Pedido</th>
                            <th>Status</th>
                            <th>Opções</th>
                        </tr>
                        <Pedidos />
                    </tbody>
                </table>
            </div>
        );
    }

    setStatus(event){
        this.setState({
           status: event.target.value
        });
        this.getPedidos(event.target.value);
    }

    getPedidos($status){
        var url = '/admin/pedidos/'+$status;
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if(data!=undefined && data.result=='success'){
                    this.setState({
                        pedidos: data.pedidos,
                    });
                }
            });
    }

    setPedidoProximoStatus($id_pedido){
        var url = '/admin/pedido/proximo_status/'+$id_pedido;
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if(data!=undefined && data.result=='success'){
                    this.getPedidos(this.state.status);
                }
            });
    }
    setPedidoStatusAnterior($id_pedido){
        var url = '/admin/pedido/status_anterior/'+$id_pedido;
        var options = { method: 'GET',
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if(data!=undefined && data.result=='success'){
                    this.getPedidos(this.state.status);
                }
            });
    }
}

if (document.getElementById('pedidos')) {
    ReactDOM.render(<AdminPedidos />, document.getElementById('pedidos'));
}
