var React = require('react');

module.exports = React.createClass({
    getInitialState: function() {
        return {
        }
    },
    render: function() {
        var options = this.props.options.map(function (option) {
            var optionElement = '';
            if(option.image){
                optionElement = <option value={option.value} data-image={option.image}>{option.label}</option>;
            }else{
                optionElement = <option value={option.value} >{option.label}</option>;
            }
            return optionElement;
        });
        var name="_attributes[" + this.props.attribute_id + "]";
        var attributeId = "attribute-" + this.props.attribute_id;
        return (
            <div className="form-group">
                <label htmlFor={attributeId}>{this.props.label}</label>
                <select id={attributeId} name={name} class="form-control" className="form-control" onChange={this.props.onChange}>
                    <option>Please select...</option>
                    {options}
                </select>
            </div>
        );
    }
});
