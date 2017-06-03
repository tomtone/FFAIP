var React = require('react')

module.exports = React.createClass({

  render: function() {
    var street = null;
    if (Array.isArray(this.props.street)) {
       street = this.props.street.map(function(item) {
        return (
          <p>{ item } </p>
        );
      });
    } else {
      street = this.props.street;
    }

    var region = null;
    if (this.props.region) {
      region = this.props.region.region;
    }

    return (
      <address
        onClick={ this.props.onClick }
        data-address-id={ this.props.addressId }
      >
        <strong>{ this.props.firstname } { this.props.lastname }</strong>
        { street }
        { this.props.city } { region } { this.props.postcode }<br/>
        { this.props.country_id }<br/>
        <abbr title="Phone">P:</abbr> { this.props.telephone }
      </address>
    )
  }
})
