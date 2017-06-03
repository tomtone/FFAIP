var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Client = require('../../remote/Client');

module.exports = React.createClass({
  render: function() {
    return (
      <div>
        <Panel header="Shipping Method">
          <div>
            <p><input type="radio" value="Method1" ref="shippingMethod"/> Method1</p>
            <p><input type="radio" value="Method2" ref="shippingMethod"/> Method2</p>
          </div>
        </Panel>
      </div>
    );
  },
})
