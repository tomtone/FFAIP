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
  },
  updateQty: function(itemId, qty, successCallback) {
    $.ajax({
      url: '/api/cart/items/'+ itemId + '/update_qty',
      data: { qty: qty },
      method: 'PUT',
      success: successCallback
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
      success: successCallback
    });
  },
};
