var React = require('react');
var ReactDOM = require('react-dom');
var Alert = require('react-bootstrap').Alert;
var Client = require('./Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      qty: this.props.qty,
    }
  },
  removeItem: function() {
    var refresh = this.props.refresh;
    var itemId = this.props.item_id;

    Client.removeItem(
      itemId,
      function (data) {
        refresh();
        const alertInstance = (
          <Alert bsStyle="warning">
            <strong>Holy guacamole!</strong> You did something awesome.
          </Alert>
        );
        ReactDOM.render(alertInstance, document.getElementById('alert-container'));
      }.bind(this)
    );
  },
  changeQty: function(e) {
    var qty = e.target.value;
    this.setState({
      qty: qty
    })
    return true;
  },
  updateQty: function() {
    var refresh = this.props.refresh;

    Client.updateQty(
      this.props.item_id,
      this.state.qty,
      function(data) {
        refresh();
      }.bind(this)
    );
  },
  render: function() {
    var style = {
      width: '100px'
    };
    return (
      <li className="list-group-item">
        <small>{this.props.name} - {this.props.sku}</small>
        <small>{this.props.price}</small>
        <p><img style={style} src={this.props.image_url} /></p>
        <div className="form-group">
          <label>Qty</label>
          <input onChange={this.changeQty.bind(this)} value={this.state.qty} type="text" className="form-control mb-2 mr-sm-2 mb-sm-0"/>
          <span><button onClick={this.updateQty}>Update</button></span>
          <button type="button" onClick={this.removeItem.bind(this)}>
            <span className="fa fa-trash fa-3" aria-hidden="true"></span>
          </button>
        </div>
      </li>
    );
  }
});
