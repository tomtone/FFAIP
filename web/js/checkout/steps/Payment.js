var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Grid = require('react-bootstrap').Grid;
var Row = require('react-bootstrap').Row;
var Col = require('react-bootstrap').Col;
var ShoppingCart = require('../../cart/ShoppingCart');

module.exports = React.createClass({
  render: function() {
    return (
      <Grid>
        <Row className="show-grid">
          <Col xs={12} md={8}>
            <Panel header="Payment Method">
              <ul>
                <li>Paypal</li>
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
  }
})
