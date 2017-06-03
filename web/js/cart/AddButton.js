var React = require('react');
var Registry = require('../component/Registry');
var Client = require('../remote/Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      qty: 1,
      disabled: false
    }
  },
  addToCart: function() {
    this.setState({
        disabled: true
    });

    var configurableAttributes = Registry.getInstance("ConfigurableAttributes");
    var configuredOptions = configurableAttributes.getData();
    var self = this;

    Client.addItem(this.props.sku, this.state.qty, configuredOptions,  function() {
      var miniCartButton = Registry.getInstance("Minicart");
      miniCartButton.refresh();

        self.setState({
          disabled: false
      });
    });
  },
  changeQty: function(e) {
    var qty = e.target.value;
    this.setState({
      qty: qty
    });
    return true;
  },
  render: function() {
    var qtyInput = (
      <input className="form-control" type="text" value={this.state.qty} onChange={this.changeQty.bind(this)}/>
    );
    return (
      <div>
        { this.props.qtyInputEnabled ? qtyInput : '' }
        <button className="btn btn-primary" onClick={this.addToCart.bind(this)} disabled={this.state.disabled}>Add to Cart</button>
      </div>
    );
  }
});
