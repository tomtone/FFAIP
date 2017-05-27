var ReactDOM = require('react-dom');
var React = require('react');
var Registry = require('./component/Registry');
var MiniCartButton = require('./minicart/Button');
var AddToCartButton = require('./cart/AddButton');

Registry.addClass("MiniCartButton", MiniCartButton);
Registry.addClass("AddToCartButton", AddToCartButton);

$( document ).ready(function() {
  $.each($("script[type='text/x-init']"), function(index, value) {
    var elementConfig = JSON.parse($(value).html());
    var element = elementConfig["element"];
    var componentName = elementConfig["component"];
    var props = elementConfig["props"];

    // try {
      // if (componentName == "MiniCartButton") {
        // Registry.value = 10;
        // var str = "./minicart/"+"Button";
        // var component = require(componentName);
        var componentClass = Registry.getClass(componentName);
        if (componentClass) {
          // console.log(component);
          var component = React.createElement(componentClass, props);
          var componentInstance = ReactDOM.render(
            component,
            document.getElementById(element)
          );
          Registry.addInstance(componentName, componentInstance);

          // button2.toggleMiniCart();
        // }
      }
    // } catch (err) {
    //   console.log(err);
    // }
  });
});
