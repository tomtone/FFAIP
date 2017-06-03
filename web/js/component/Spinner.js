var React = require('react');

module.exports = React.createClass({
  render: function() {
    var style = {
      'font-size': '24px'
    };
    return (
      <i className="fa fa-spinner fa-spin" style={ style } ></i>
    );
  }
});

