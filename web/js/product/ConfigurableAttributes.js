var React = require('react');
var Registry = require('../component/Registry');
var Select = require('../component/Select');

module.exports = React.createClass({
    updateImages: function () {
        alert("I bims wörklich!");
    },
    render: function() {

        var select = this.props.configurableAttributes.map(function(value) {
            name = "_attributes["+ value.id +"]";
            id = "attribute-" + value.id;
            options = value.options.map(function (option) {
                return <option value={option.value} >{option.label}</option>
            });

            label = <label for={id}>{value.label}</label>;

            return (
                <select id={id} name={name}>{options}</select>
            );

        });

        var select = this.props.configurableAttributes.map(function (value) {
            id = "attribute-" + value.id;
            name = "_attributes[" + value.id +"]";
            id = "attribute-" + value.id;
            return <Select
                id={id}
                name={name}
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
