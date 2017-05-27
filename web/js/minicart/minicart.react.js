var MiniCartButton = React.createClass({
  getInitialState: function() {
    return {
      items: [],
      totals: {
        totals: {}
      }
    }
  },
  componentDidMount: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    $.ajax({
      url: '/api/checkout/cart',
      success: function (data) {
        this.setState({items: data.items, totals: data.totals});
      }.bind(this)
    });
  },
  toggleMiniCart: function(e) {
    $("#dropdown-menu").toggle();
  },
  render: function() {
    var minicartContent = null;
    minicartContent = <MiniCartEmpty/>;
    if (this.state.totals.totals.items_qty > 0) {
      minicartContent = <MiniCartContent
                            checkoutUrl={this.props.checkoutUrl}
                            cartUrl={this.props.cartUrl}
                            items={this.state.items}
                            totals={this.state.totals}
                          />;
    }


    return (
      <li className="nav navbar-nav navbar-right">
      <a onClick={this.toggleMiniCart.bind(this)}>
          <i className="fa fa-shopping-cart fa-3" aria-hidden="true"></i>
          {this.state.totals.totals.items_qty}
      </a>
      <div className="dropdown">
        <div id="dropdown-menu" className="dropdown-menu">
        <button type="button" className="pull-right" onClick={this.toggleMiniCart.bind(this)}>
          <span className="fa fa-window-close fa-3" aria-hidden="true"></span>
        </button>
        <hr/>
        {minicartContent}
        </div>
      </div>
      </li>
    );
  }
});
var MiniCartEmpty = React.createClass({
  render: function() {
    return (
      <p>You have no items on your shopping cart</p>
    );
  }
});
var MiniCartContent = React.createClass({
  gotoCheckout: function() {
    window.location.href=this.props.checkoutUrl;
  },
  render: function() {
    var itemNodes = this.props.items.map(function(item) {
      return (
        <ItemBlock sku={item.sku} name={item.name} price={item.price} qty={item.qty}></ItemBlock>
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
      <span><a href={this.props.cartUrl}>View and edit cart</a></span>
      </div>
      </div>
    );
  }
});
var ItemBlock = React.createClass({
  removeItem: function() {
    alert("delete me");
  },
  render: function() {
    return (
      <li className="list-group-item">
        <small>{this.props.name} - {this.props.sku}</small>
        <small>{this.props.price}</small>
        <div className="form-group">
          <label>Qty</label>
          <input value={this.props.qty} type="text" className="form-control mb-2 mr-sm-2 mb-sm-0"/>
          <button type="button" onClick={this.removeItem.bind(this)}>
            <span className="fa fa-trash fa-3" aria-hidden="true"></span>
          </button>
        </div>
      </li>
    );
  }
});
window.MiniCartButton = MiniCartButton;
