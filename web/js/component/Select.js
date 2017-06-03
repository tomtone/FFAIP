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
        return (
            <div class="form-group">
                <label for={this.props.id}>{this.props.label}</label>
                <select id={this.props.id} name={this.props.name} class="form-control">
                    <option>Please select...</option>
                    {options}
                </select>
            </div>
        );
    }
});
