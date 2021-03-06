var React = require('react');
var Registry = require('../component/Registry');
var Select = require('../component/Select');

module.exports = React.createClass({
    getData:function () {

        var options = {}
        this.props.configurableAttributes.map(function (value) {
            selectValue = $('select[name="_attributes['+ value.attribute_id +']"]').val();
            options[value.attribute_id] = selectValue;
        });

        return options;
    },
    updateImages: function (event) {
        var imagePath = event.target[event.target.selectedIndex].getAttribute('data-image');
        if(imagePath) {
            document.getElementById('product-base-image').src = this.props.product_base_url + imagePath;
        }
    },
    render: function() {
        var self = this;
        var select = this.props.configurableAttributes.map(function (value) {
            id = "attribute-" + value.id;
            name = "_attributes[" + value.attribute_id +"]";
            id = "attribute-" + value.id;
            return <Select
                name={name}
                attribute_id={value.attribute_id}
                label={value.label}
                options={value.options}
                onChange={self.updateImages.bind(self)}
            />
        })
        return (
            <div>
                {select}
            </div>
        );
    }
});
