var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Client = require('../../remote/Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      methods: [],
    }
  },
  componentDidMount: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    Client.getShippingMethods(
      function (data) {
        var newState = {methods: data.customer};
        this.setState(newState);
      }.bind(this)
    );
  },
  render: function() {
    var methods = this.state.methods.map(function(method) {
      return (
        <p>
          <input
            type="radio"
            value={ method.method_code }
            ref="ShippingMethod"
            name="ShippingMethod"
          /> { method.method_title } { method.carrier_title } - { method.price_incl_tax }</p>
      );
    });

    return (
      <div>
        <Panel header="Shipping Method">
          <div>
            { methods }
          </div>
        </Panel>
      </div>
    );
  },
})
