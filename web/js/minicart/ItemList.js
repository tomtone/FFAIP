var React = require('react');
var Item = require('./Item');

module.exports = React.createClass({
  render: function() {
    var refresh = this.props.refresh;
    var loading = this.props.loading;
    var mediaUrl = this.props.mediaUrl;
    var items = this.props.items.map(function(item) {
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
          editable={true}
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
