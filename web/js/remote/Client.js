var React = require('react');
var ReactDOM = require('react-dom');
var Alert = require('react-bootstrap').Alert;

module.exports = {
  getItems: function(successCallback) {
    $.ajax({
      url: '/api/cart',
      success: successCallback,
      error: this.handleError
    });
  },
  removeItem: function(itemId, successCallback) {
    $.ajax({
      url: '/api/cart/items/' + itemId,
      method: 'DELETE',
      success: successCallback,
      error: this.handleError
    });
  },
  updateQty: function(itemId, qty, successCallback) {
    $.ajax({
      url: '/api/cart/items/'+ itemId + '/update_qty',
      data: { qty: qty },
      method: 'PUT',
      success: successCallback,
      error: this.handleError
    });
  },
  addItem: function(sku, qty, successCallback) {
    $.ajax({
      url: '/api/cart/items',
      data: {
        _qty: qty,
        _sku: sku
      },
      method: 'POST',
      success: successCallback,
      error: this.handleError
    });
  },
  getProduct: function(sku, successCallback) {
    $.ajax({
      url: '/api/catalog/product/' + sku,
      method: 'get',
      success: successCallback,
      error: this.handleError
    });
  },
  handleError: function(data) {
    var message = JSON.stringify(data['responseJSON']);
    const alertInstance = (
      <Alert bsStyle="danger">
        {message}
      </Alert>
    );
    ReactDOM.render(alertInstance, document.getElementById('alert-container'));
  },
  getCustomer: function(successCallback) {
    $.ajax({
      url: '/api/customer',
      method: 'get',
      success: successCallback,
      error: this.handleError
    });
  },
  getShippingMethods: function(successCallback) {
    $.ajax({
      url: '/api/checkout/shipping_methods',
      method: 'get',
      success: successCallback,
      error: this.handleError
    });
  }

};
