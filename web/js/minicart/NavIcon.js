var React = require('react');

module.exports = React.createClass({
  render: function() {
    var style = {
      'font-size': '24px'
    };
    var spinner = (
      <i className="fa fa-spinner fa-spin" style={ style } ></i>
    );

    var cartIcon = (
      <i className="fa fa-shopping-cart fa-3" aria-hidden="true"></i>
    );

    return (
      <a onClick={this.props.toggle}>
        { this.props.loading ? spinner : cartIcon  }
        {this.props.itemsQty}
      </a>
    );
  }
});
