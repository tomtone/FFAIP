var React = require('react');
var ReactDOM = require('react-dom');
var Alert = require('react-bootstrap').Alert;
var Client = require('../remote/Client');
var ProductImage = require('../product/Image');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      qty: this.props.qty,
    }
  },
  removeItem: function() {
    var refresh = this.props.refresh;
    var itemId = this.props.itemId;

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
  componentDidUpdate: function(prevProps, prevState){
    // dirty workaround to make qty chances from add to cart button possible
    if (this.props.qty != prevProps.qty && this.props.qty != this.state.qty) {
      this.setState({
        qty: this.props.qty
      });
    }
  },
  changeQty: function(e) {
    var qty = e.target.value;
    this.setState({
      qty: qty
    });
    return true;
  },
  updateQty: function() {
    var refresh = this.props.refresh;

    Client.updateQty(
      this.props.itemId,
      this.state.qty,
      function(data) {
        refresh();
      }.bind(this)
    );
  },
  render: function() {
    return (
      <li className="list-group-item">
        <small>{this.props.name} - {this.props.sku}</small>
        <small>{this.props.price}</small>
        <ProductImage sku={this.props.sku} mediaUrl={this.props.mediaUrl}/>
        <div className="form-group">
          <label>Qty</label>
          <input
            onChange={this.changeQty.bind(this)}
            value={this.state.qty}
            type="text"
            className="form-control mb-2 mr-sm-2 mb-sm-0"
            disabled={this.props.loading}
          />
          <span>
            <button
              disabled={this.props.loading}
              onClick={this.updateQty}
            >
              Update
            </button>
          </span>
          <button
            type="button"
            onClick={this.removeItem.bind(this)}
            disabled={this.props.loading}
          >
            <span className="fa fa-trash fa-3" aria-hidden="true"></span>
          </button>
        </div>
      </li>
    );
  }
});
