var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Grid = require('react-bootstrap').Grid;
var Row = require('react-bootstrap').Row;
var Col = require('react-bootstrap').Col;
var ShoppingCart = require('../../cart/ShoppingCart');

module.exports = React.createClass({
  render: function() {
    var addressPanel = (
      <div>
        <Panel header="Shipping Address">
          <address>
          Veronica Costello
          6146 Honey Bluff Parkway
          Calder, Michigan 49628-7978
          United States
          (555) 229-3326
          </address>
        </Panel>
      </div>
    );
    var methodPanel = (
      <div>
        <Panel header="Shipping Method">
          <div>
            <p><input type="radio" value="Method1" ref="shippingMethod"/> Method1</p>
            <p><input type="radio" value="Method2" ref="shippingMethod"/> Method2</p>
          </div>
        </Panel>
      </div>
    );

    return ( <div>
      <Grid>
        <Row className="show-grid">
          <Col xs={12} md={8}>
            { addressPanel }
            { methodPanel }
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

  saveAndContinue: function(e) {
    e.preventDefault()

    // TODO
    var data = {
      name     : this.refs.name.value,
      password : this.refs.password.value,
      email    : this.refs.email.value,
      shippingMethod: this.refs.shippingMethod.value
    }

    this.props.saveValues(data)
    this.props.nextStep()
  }
})
