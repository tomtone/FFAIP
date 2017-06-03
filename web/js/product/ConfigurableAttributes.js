var React = require('react');
var Registry = require('../component/Registry');
var Select = require('../component/Select');

module.exports = React.createClass({
    updateImages: function () {
        alert("I bims wörklich!");
    },
    render: function() {

        var select = this.props.configurableAttributes.map(function (value) {
            id = "attribute-" + value.id;
            name = "_attributes[" + value.attribute_id +"]";
            id = "attribute-" + value.id;
            return <Select
                id={id}
                name={name}
                attribute_id={value.attribute_id}
                label={value.label}
                options={value.options}
            />
        })
        return (
            <div class="lalala">
                {select}
            </div>
        );
    }
});
