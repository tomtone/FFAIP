var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Client = require('../../remote/Client');
var Spinner = require('../../component/Spinner');

module.exports = React.createClass({
  render: function() {
    var self = this;
    var methods = this.props.methods.map(function(method) {
      return (
        <p>
          <input
            type="radio"
            value={ method.method_code }
            ref="ShippingMethod"
            name="ShippingMethod"
            onChange={ self.props.changedMethod }
          /> { method.method_title } { method.carrier_title } - { method.price_incl_tax }</p>
      );
    });

    var spinner = (<Spinner />);

    return (
      <div>
        <Panel header="Shipping Method">
          <div>
            { this.props.loading ? spinner : methods  }
          </div>
        </Panel>
      </div>
    );
  },
})
