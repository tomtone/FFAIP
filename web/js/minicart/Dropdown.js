var React = require('react');
var ItemList = require('./ItemList');
var NoItems = require('./NoItems');

module.exports = React.createClass({
  render: function() {
    var items = null;
    items = <NoItems/>;
    if (this.props.totals.totals.items_qty > 0) {
      items = <ItemList
                            checkoutUrl={this.props.checkoutUrl}
                            cartUrl={this.props.cartUrl}
                            mediaUrl={this.props.mediaUrl}
                            items={this.props.items}
                            totals={this.props.totals}
                            refresh={this.props.refresh}
                          />;
    }
    return (
      <div className="dropdown">
        <div id="dropdown-menu" className="dropdown-menu">
          <button type="button" className="pull-right" onClick={this.props.toggle}>
            <span className="fa fa-window-close fa-3" aria-hidden="true"></span>
          </button>
          <hr/>
          <div>
            <ul className="list-group">
              <li className="list-group-item">
                <span>{this.props.totals.totals.itemsQty} Item</span>
                <span>Cart Subtotal: {this.props.totals.totals.subtotal}</span>
              </li>
            </ul>
            <button onClick={this.props.gotoCheckout}>Go to Checkout</button>
            <div className="form-inline">
              {items}
              <hr />
              <span><a href={this.props.cartUrl}>View and edit cart</a></span>
            </div>
          </div>
        </div>
      </div>
    );
  }
});
