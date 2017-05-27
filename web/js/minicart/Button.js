var React = require('react');
var NoItems = require('./NoItems');
var Content = require('./Content');
var Client = require('./Client');

module.exports = React.createClass({
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
  refresh: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    Client.getItems(
      function (data) {
        this.setState({items: data.items, totals: data.totals});
      }.bind(this)
    );
  },
  toggleMiniCart: function(e) {
    $("#dropdown-menu").toggle();
  },
  render: function() {
    var minicartContent = null;
    minicartContent = <NoItems/>;
    if (this.state.totals.totals.items_qty > 0) {
      minicartContent = <Content
                            checkoutUrl={this.props.checkoutUrl}
                            cartUrl={this.props.cartUrl}
                            items={this.state.items}
                            totals={this.state.totals}
                            refresh={this.refresh}
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
