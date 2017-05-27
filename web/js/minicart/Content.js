var React = require('react');
var Item = require('./Item');

module.exports = React.createClass({
  gotoCheckout: function() {
    window.location.href=this.props.checkoutUrl;
  },
  render: function() {
    var refresh = this.props.refresh;
    var itemNodes = this.props.items.map(function(item) {
      return (
        <Item
          sku={item.sku}
          name={item.name}
          price={item.price}
          qty={item.qty}
          item_id={item.item_id}
          refresh={refresh}></Item>
      );
    });
    return (
      <div>
      <ul className="list-group">
        <li className="list-group-item">
          <span>{this.props.totals.totals.items_qty} Item</span>
          <span>Cart Subtotal: {this.props.totals.totals.subtotal}</span>
        </li>
      </ul>
      <button onClick={this.gotoCheckout.bind(this)}>Go to Checkout</button>
      <div className="form-inline">
      <ul className="list-group">
        {itemNodes}
      </ul>
      <hr />
      <span><a href={this.props.cartUrl}>View and edit cart</a></span>
      </div>
      </div>
    );
  }
});
