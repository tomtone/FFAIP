var ReactDOM = require('react-dom');
var React = require('react');
var Registry = require('./component/Registry');
var Minicart = require('./minicart/Minicart');
var AddToCartButton = require('./cart/AddButton');

Registry.addClass("Minicart", Minicart);
Registry.addClass("AddToCartButton", AddToCartButton);

$( document ).ready(function() {
  $.each($("script[type='text/x-init']"), function(index, value) {
    var elementConfig = JSON.parse($(value).html());
    var element = elementConfig["element"];
    var componentName = elementConfig["component"];
    var props = elementConfig["props"];

    var componentClass = Registry.getClass(componentName);
    if (componentClass) {
      var component = React.createElement(componentClass, props);
      var componentInstance = ReactDOM.render(
        component,
        document.getElementById(element)
      );
      Registry.addInstance(componentName, componentInstance);
    }
  });
});
