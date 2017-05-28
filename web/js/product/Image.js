var React = require('react');
var Client = require('../remote/Client');

module.exports = React.createClass({
  getInitialState: function() {
    return {
      imageUrl: '/apple-touch-icon.png'
    };
  },
  componentDidMount: function() {
    this.loadFromServer();
  },
  loadFromServer: function() {
    var mediaUrl = this.props.mediaUrl;
    Client.getProduct(
      this.props.sku,
      function (data) {
        var gallery = data['product']['media_gallery_entries'];
        if (gallery[0]) {
          this.setState({
            imageUrl: mediaUrl + gallery[0]['file']
          });
        }
      }.bind(this)
    );
  },
  render: function() {
    var style = {
      width: '100px'
    };
    return (
      <p><img style={style} src={this.state.imageUrl} /></p>
    );
  }
});

