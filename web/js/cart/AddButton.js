var React = require('react');
var Registry = require('../component/Registry');
var Client = require('../remote/Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      qty: 1
    }
  },
  addToCart: function() {
    Client.addItem(this.props.sku, this.state.qty, function() {
      var miniCartButton = Registry.getInstance("Minicart");
      miniCartButton.refresh();
    });
  },
  changeQty: function(e) {
    var qty = e.target.value;
    this.setState({
      qty: qty
    })
    return true;
  },
  render: function() {
    return (
      <div>
      <input className="form-control" type="text" value={this.state.qty} onChange={this.changeQty.bind(this)}/>
      <button className="btn btn-primary" onClick={this.addToCart.bind(this)}>Add to Cart</button>
      </div>
    );
  }
});
