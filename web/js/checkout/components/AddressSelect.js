var React = require('react')
var Panel = require('react-bootstrap').Panel;
var Address = require('../../customer/Address');
var Client = require('../../remote/Client');
var Spinner = require('../../component/Spinner');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      addressId: null,
      addresses: [],
      loading: false
    }
  },
  componentDidMount: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    this.setState({loading: true});
    Client.getCustomer(
      function (data) {
        var newState = {addresses: data.customer.addresses, loading: false};
        if (data.customer.addresses.length > 0 && this.state.addressId == null) {
          // init selected address
          newState['addressId'] = data.customer.addresses[0].id;
        }
        this.setState(newState);
        this.props.changedAddress(data.customer.addresses[0]);
      }.bind(this)
    );
  },
  getAddressById: function(addressId) {
    for (var i=0;i<this.state.addresses.length;i++) {
      if (this.state.addresses[i].id == addressId) {
        return this.state.addresses[i];
      }
    }
    return null;

  },
  changeAddress: function(event) {
    var selectedAddressId = parseInt($(event.target).attr('data-address-id'));
    if (selectedAddressId) {
      this.props.changedAddress(this.getAddressById(selectedAddressId));
      this.setState({ addressId: selectedAddressId  });
    }
  },
  render: function() {
    var self = this;
    var remoteAddresses = this.state.addresses;
    var selectedAddressId = this.state.addressId;

    var addresses = remoteAddresses.map(function(address) {
      var style = {};
      var isSelected = address.id == selectedAddressId;
      if (isSelected) {
        style['background-color'] = '#5cb85c';
      }
      var selectButton = (
        <button onClick={self.changeAddress.bind(self)} data-address-id={ address.id } >
          Select
        </button>
      );
      return (
        <Panel style={style}>
          <Address
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
        { isSelected ? '' : selectButton }
        </Panel>
      );
    });

    var spinner = (<Spinner />);

    return (
      <div>
        { this.state.loading ? spinner : addresses  }
      </div>
    );
  },
});
