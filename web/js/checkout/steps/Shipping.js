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
      shippingMethod: null,
      loading: true
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

    return (
      <Grid>
        <Row className="show-grid">
          <Col xs={12} md={8}>
            { addressPanel }
            <ShippingMethodSelect
              methods={ this.state.shippingMethods }
              changedMethod={ this.changedShippingMethod }
              loading={this.state.loading}
            />
            <button className="btn btn-primary pull-right" onClick={ this.saveAndContinue }>Next</button>
          </Col>
          <Col xs={6} md={4}>
            <h2>Order Summary</h2>
            <ShoppingCart mediaUrl={this.props.mediaUrl} editable={false} />
          </Col>
        </Row>
      </Grid>
    );
  },
  changedShippingMethod: function(event) {
    var method = $(event.target).val();
    this.setState({shippingMethod: method});
  },
  changedAddress: function(address) {
    this.setState({shippingAddress: address, shippingMethod: null});
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
    if (this.state.shippingMethod == null || this.state.shippingAddress == null) {
      alert("please select something");
      return;
    }
    var data = {
      shippingMethod: this.state.shippingMethod,
      shippingAddress: this.state.shippingAddress
    }
    this.props.saveValues(data)
    this.props.nextStep()
  }
})
