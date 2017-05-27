var ReactDOM = require('react-dom');
var React = require('react');
var Button = require('./Button');

$( document ).ready(function() {
  $.each($("script[type='text/x-init']"), function(index, value) {
    var elementConfig = JSON.parse($(value).html());
    var element = elementConfig["element"];
    var component = elementConfig["compontent"];
    var props = elementConfig["props"];

    ReactDOM.render(
      <Button cartUrl={props.cartUrl} checkoutUrl={props.checkoutUrl} />,
      document.getElementById('minicart')
    );
  });
});
