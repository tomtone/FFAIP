var React = require('react');

module.exports = React.createClass({
  render: function() {
    return (
      <a onClick={this.props.toggle}>
          <i className="fa fa-shopping-cart fa-3" aria-hidden="true"></i>
          {this.props.itemsQty}
      </a>
    );
  }
});

