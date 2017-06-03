var ReactDOM = require('react-dom');
var React = require('react');
var Registry = require('./component/Registry');

// TODO: make this more dynamic
var Minicart = require('./minicart/Minicart');
var AddToCartButton = require('./cart/AddButton');
var ShoppingCart = require('./cart/ShoppingCart');
var Checkout = require('./checkout/Checkout');

Registry.addClass("Minicart", Minicart);
Registry.addClass("ShoppingCart", ShoppingCart);
Registry.addClass("AddToCartButton", AddToCartButton);
Registry.addClass("Checkout", Checkout);

$( document ).ready(function() {
  $.each($("script[type='text/x-init']"), function(index, value) {
    var elementConfig = JSON.parse($(value).html());
    var element = elementConfig["element"];
    var componentName = elementConfig["component"];
    var props = elementConfig["props"];

    var componentClass = Registry.getClass(componentName);
    var component = React.createElement(componentClass, props);

    // either render the element into the given element
    if (element) {
      var componentInstance = ReactDOM.render(
        component,
        document.getElementById(element)
      );
    } else {
      // or replace script tag with component anonumously
      var tmpContainer = document.createElement("div");
      var componentInstance = ReactDOM.render(
        component,
        tmpContainer
      );
      $(this).replaceWith(tmpContainer);
    }

    // only add it to registry, if element is given, these ones
    // will be shared for access by other components
    if (element) {
      Registry.addInstance(componentName, componentInstance);
    }
  });
});
