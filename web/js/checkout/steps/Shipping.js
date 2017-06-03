var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Grid = require('react-bootstrap').Grid;
var Row = require('react-bootstrap').Row;
var Col = require('react-bootstrap').Col;
var ShoppingCart = require('../../cart/ShoppingCart');
var Address = require('../../customer/Address');
var Client = require('../../remote/Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      addresses: [],
      addressId: null
    }
  },
  componentDidMount: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    Client.getCustomer(
      function (data) {
        var newState = {addresses: data.customer.addresses};
        if (data.customer.addresses.length > 0 && this.state.addressId == null) {
          // init selected address
          newState['addressId'] = data.customer.addresses[0].id;
        }
        this.setState(newState);
      }.bind(this)
    );
  },
  changeAddress: function(event) {
    var selectedAddressId = parseInt($(event.target).attr('data-address-id'));
    if (selectedAddressId) {
      this.setState({ addressId: selectedAddressId  });
    }
  },
  render: function() {
    var self = this;
    var remoteAddresses = this.state.addresses;
    var selectedAddressId = this.state.addressId;

    var addresses = remoteAddresses.map(function(address) {
      var style = {};
      if (address.id == selectedAddressId) {
        style['background-color'] = '#5cb85c';
      }
      return (
        <Panel style={style}>
          <Address
            onClick={self.changeAddress.bind(self)}
            addressId={ address.id }
            firstname={ address.firstname }
            lastname={ address.lastname }
            street={ address.street }
            city={ address.city }
            region={ address.region }
            postcode={ address.postcode }
            country_id={ address.country_id }
            telephone={ address.telephone }
          />
        </Panel>
      );
    });
    var addressPanel = (
      <div>
        <Panel header="Shipping Address">
          { addresses }
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
