var React         = require('react');
var Shipping = require('./steps/Shipping');
var Payment  = require('./steps/Payment');
var assign        = require('object-assign');
var ReactDOM = require('react-dom');
var Alert = require('react-bootstrap').Alert;
var Client = require('../remote/Client');

var fieldValues = {
  addressId: null,
  paymentMethod: 'checkmo',
  name     : null,
  email    : null,
  password : null,
  age      : null,
  colors   : []
};

var Registration = React.createClass({
  getInitialState: function() {
		return {
			step: 1
		}
	},
  nextStep: function() {
    this.setState({
      step : this.state.step + 1
    })
  },
  previousStep: function() {
    this.setState({
      step : this.state.step - 1
    })
  },
  submitRegistration: function() {
    alert("Aweseome");
    // this.nextStep()
  },
  showStep: function() {
    switch (this.state.step) {
      case 1:
        return <Shipping fieldValues={fieldValues}
                              nextStep={this.nextStep}
                              previousStep={this.previousStep}
                              saveValues={this.saveValues}
                              mediaUrl={this.props.mediaUrl} />
      case 2:
        return <Payment fieldValues={fieldValues}
                             placeOrder={this.placeOrder}
                             previousStep={this.previousStep}
                             submitRegistration={this.submitRegistration}
                             mediaUrl={this.props.mediaUrl} />
    }
  },
  getStepTitle: function(stepId) {
    switch (this.state.step) {
      case 1:
        return "Shipping";
      case 2:
        return "Payment";
    }

  },
  saveValues: function(field_value) {
    return function() {
      fieldValues = assign({}, fieldValues, field_value)
    }.bind(this)()
  },
  render: function() {
    var style = {
      width : (this.state.step / 3 * 100) + '%'
    }

    return (
      <main>
        <div className="progress">
          <div className="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style={style}>
             {this.getStepTitle(this.state.step)}
          </div>
        </div>
        {this.showStep()}
      </main>
    )
  },
  placeOrder: function() {
    var order = {
      paymentMethod: {
        method: fieldValues.paymentMethod
      }
    };
    Client.placeOrder(
      order,
      function (data) {
        alert("awesome");
        // var newState = {shippingMethods: data.methods, loading: false};
        // this.setState(newState);
      }.bind(this)
    );
  }
});

module.exports = Registration;
