var React = require('react');
var Item = require('./Item');

module.exports = React.createClass({
  render: function() {
    var mediaUrl = this.props.mediaUrl;
    var refresh = this.props.refresh;
    var loading = this.props.loading;
    var items = this.props.items.map(function(item) {
      return (
        <Item
          sku={item.sku}
          name={item.name}
          price={item.price}
          qty={item.qty}
          itemId={item.item_id}
          imageUrl={mediaUrl + "w/b/wb06-red-0_alt1.jpg"}
          refresh={refresh}
          loading={loading}
        />
      );
    });
    return (
      <ul className="list-group">
        {items}
      </ul>
    );
  }
});
