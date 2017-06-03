var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Grid = require('react-bootstrap').Grid;
var Row = require('react-bootstrap').Row;
var Col = require('react-bootstrap').Col;
var ShoppingCart = require('../../cart/ShoppingCart');
var AddressSelect = require('../components/AddressSelect');
var ShippingMethodSelect = require('../components/ShippingMethodSelect');
var Client = require('../../remote/Client');
var Spinner = require('../../component/Spinner');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      shippingMethods: [],
      shippingAddress: null,
      loading: false
    }
  },
  render: function() {
    var addressPanel = (
      <div>
        <Panel header="Shipping Address">
          <AddressSelect changedAddress={ this.changedAddress } loading={this.state.loading}/>
        </Panel>
      </div>
    );

    return ( <div>
      <Grid>
        <Row className="show-grid">
          <Col xs={12} md={8}>
            { addressPanel }
            <ShippingMethodSelect methods={ this.state.shippingMethods } loading={this.state.loading} />
            <button onClick={ this.saveAndContinue }>Next</button>
          </Col>
          <Col xs={6} md={4}>
            <h2>Order Summary</h2>
            <ShoppingCart mediaUrl={this.props.mediaUrl} editable={false} />
          </Col>
        </Row>
      </Grid>

      <label>Name</label>
      <input type="text"
             ref="name"
             defaultValue={ this.props.fieldValues.name } />

      <label>Password</label>
      <input type="password"
             ref="password"
             defaultValue={ this.props.fieldValues.password } />

      <label>Email</label>
      <input type="email"
             ref="email"
             defaultValue={ this.props.fieldValues.email } />
      </div>

    )
  },

  changedAddress: function(address) {
    this.setState({shippingAddress: address});
    this.loadShippingMethods(address);
  },
  loadShippingMethods: function(address) {
    this.setState({loading: true});
    Client.getShippingMethods(
      address,
      function (data) {
        var newState = {shippingMethods: data.methods, loading: false};
        this.setState(newState);
      }.bind(this)
    );
  },
  saveAndContinue: function(e) {
    e.preventDefault()

    // TODO
    var data = {
      // name     : this.refs.name.value,
      // password : this.refs.password.value,
      // email    : this.refs.email.value,
      shippingMethod: this.refs.shippingMethod.value,
      addressId: this.state.addressId
    }

    this.props.saveValues(data)
    this.props.nextStep()
  }
})
