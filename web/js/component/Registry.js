module.exports = {
  classes: {},
  instances: {},
  addClass: function(name, component) {
    this.classes[name] = component;
  },
  getClass: function(name) {
    var result = this.classes[name];
    if (result) {
      return result;
    }
    throw new "Class with registred name of " + name + " was not found.";
  },
  addInstance: function(name, instance) {
    this.instances[name] = instance;
  },
  getInstance: function(name) {
    var result = this.instances[name];
    if (result) {
      return result;
    }
    throw new "Instance with registred name of " + name + " was not found.";
  }
};

