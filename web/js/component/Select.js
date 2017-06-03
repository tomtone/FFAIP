var React = require('react');

module.exports = React.createClass({
    getInitialState: function() {
        return {
        }
    },
    render: function() {
        var options = this.props.options.map(function (option) {
            return <option value={option.value}>{option.label}</option>
        });
        var name="_attributes[" + this.props.attribute_id + "]";
        return (
            <div className="form-group">
                <label htmlFor={this.props.id}>{this.props.label}</label>
                <select id={this.props.id} name={name} class="form-control" className="form-control">
                    <option>Please select...</option>
                    {options}
                </select>
            </div>
        );
    }
});
