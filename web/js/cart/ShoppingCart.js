var React = require('react');
var Registry = require('../component/Registry');
var Client = require('../remote/Client');
var Item = require('../minicart/Item');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      items: [],
      totals: {
        totals: {}
      },
      loading: true,
      editable: this.props.editable
    }
  },
  componentDidMount: function() {
    this.refresh();
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
  render: function() {
    var loading = this.state.loading;
    var editable = this.state.editable;
    var refresh = this.refresh;
    var mediaUrl = this.props.mediaUrl;
    var items = this.state.items.map(function(item) {
      return (
        <Item
          sku={item.sku}
          name={item.name}
          price={item.price}
          qty={item.qty}
          itemId={item.item_id}
          refresh={refresh}
          loading={loading}
          mediaUrl={mediaUrl}
          editable={editable}
        />
      );
    });
    return (
      <ul>
        { items }
      </ul>
    );
  }
});
