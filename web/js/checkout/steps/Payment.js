var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Grid = require('react-bootstrap').Grid;
var Row = require('react-bootstrap').Row;
var Col = require('react-bootstrap').Col;
var ShoppingCart = require('../../cart/ShoppingCart');
var Client = require('../../remote/Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      methods: [],
      paymentMethod: null,
      loading: true
    }
  },
  componentDidMount: function() {
    this.loadPaymentMethods();
  },
  loadPaymentMethods: function() {
    this.setState({loading: true});
    Client.getPaymentMethods(
      function (data) {
        var newState = {methods: data.payment_methods, loading: false};
        this.setState(newState);
      }.bind(this)
    );
  },
  render: function() {
    var paymentMethods = this.state.methods.map(function(method) {
      return (
        <li>{ method.title }</li>
      );
    });

    return (
      <Grid>
        <Row className="show-grid">
          <Col xs={12} md={8}>
            <Panel header="Payment Method">
              <ul>
                { paymentMethods }
              </ul>
            </Panel>
            <button className="btn -default pull-left" onClick={this.props.previousStep}>Back</button>
            <button className="btn btn-primary pull-right" onClick={ this.saveAndContinue }>Place Order</button>
          </Col>
          <Col xs={6} md={4}>
            <h2>Order Summary</h2>
            <ShoppingCart mediaUrl={this.props.mediaUrl} editable={false} />
          </Col>
        </Row>
      </Grid>
    )
  },
  saveAndContinue: function(e) {
    e.preventDefault()
    // var data = {
    // }
    // this.props.saveValues(data)
    this.props.placeOrder()
  }
})
