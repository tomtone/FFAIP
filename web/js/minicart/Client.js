module.exports = {
  getItems: function(successCallback) {
    $.ajax({
      url: '/api/cart',
      success: successCallback
    });
  },
  removeItem: function(itemId, successCallback) {
    $.ajax({
      url: '/api/cart/items/' + itemId,
      method: 'DELETE',
      success: successCallback
    });
  }
};
