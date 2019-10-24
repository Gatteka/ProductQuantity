define(['uiComponent', 'jquery',], function (Component, $) {
    return Component.extend({
        initialize: function () {
            this._super();
            this.currentQty = '';
            this.observe(['currentQty']);
        },

        getQty: function () {
            this.call(this.currentQty);
        },
        call: function (currentQty) {
            $.ajax({
                url: 'get_qty/GetQty/Index',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: this.id,
                },
                complete: function (response) {
                    let qty = response.responseJSON.success;
                    if (!qty) {
                        return
                    }
                    currentQty('Available quantity ' + qty);

                },
                error: function () {
                    console.log('Error happens. Try again.');
                }
            });
        }
    });
});