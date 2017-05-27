var React = require('react');
var Client = require('../remote/Client');
var Dropdown = require('./Dropdown');
var NavIcon = require('./NavIcon');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      items: [],
      totals: {
        totals: {}
      },
      loading: true
    }
  },
  componentDidMount: function() {
    this.loadFromServer();
  },
  refresh: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    this.setState({loading: true});
    Client.getItems(
      function (data) {
        this.setState({items: data.items, totals: data.totals, loading: false});
      }.bind(this)
    );
  },
  toggle: function() {
    $("#dropdown-menu").toggle();
  },
  gotoCheckout: function() {
    window.location.href=this.props.checkoutUrl;
  },
  render: function() {
    return (
      <li className="nav navbar-nav navbar-right">
      <NavIcon
        toggle={this.toggle.bind(this)}
        itemsQty={this.state.totals.totals.items_qty}
        loading={this.state.loading}
      />
      <Dropdown
        toggle={this.toggle.bind(this)}
        checkoutUrl={this.props.checkoutUrl}
        cartUrl={this.props.cartUrl}
        mediaUrl={this.props.mediaUrl}
        items={this.state.items}
        totals={this.state.totals}
        refresh={this.refresh}
        gotoCheckout={this.gotoCheckout.bind(this)}
        loading={this.state.loading}
        mediaUrl={this.props.mediaUrl}
      />
      </li>
    );
  }
});
