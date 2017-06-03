var React         = require('react');
var Shipping = require('./steps/Shipping');
var Payment  = require('./steps/Payment');
var assign        = require('object-assign');

var fieldValues = {
  addressId: null,
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
                             nextStep={this.nextStep}
                             previousStep={this.previousStep}
                             submitRegistration={this.submitRegistration}
                             mediaUrl={this.props.mediaUrl} />
    }
  },
  saveValues: function(field_value) {
    return function() {
      fieldValues = assign({}, fieldValues, field_value)
    }.bind(this)()
  },
  render: function() {
    var style = {
      width : (this.state.step / 4 * 100) + '%'
    }

    return (
      <main>
        <span className="progress-step">Step {this.state.step}</span>
        <progress className="progress" style={style}></progress>
        {this.showStep()}
      </main>
    )
  }
});

module.exports = Registration;
