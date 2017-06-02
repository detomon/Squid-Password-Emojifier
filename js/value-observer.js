(function() {
'use strict';

function ValueObserver(object, proxy) {
	var self = this;

	this.object = object || {};
	this.elements = {};
	this.handlers = {};
	this.getters = {};
	this.setters = {};
	this.dependencies = {};

	this.observe = function(property, handler) {
		var handlers = this.handlers[property];

		if (!handlers) {
			Object.defineProperty(proxy, property, {
				get: function() {
					var value;
					var getter = self.getters[property];

					if (getter) {
						value = getter(property);
					}
					else {
						value = self.object[property];
					}

					return value;
				},
				set: function(value) {
					var setter = self.setters[property];

					if (setter) {
						setter(value, property);
					}
					else {
						self.object[property] = value;
					}

					var depends = self.dependencies[property];

					if (depends) {
						for (var i = 0; i < depends.length; i ++) {
							var dependProperty = depends[i];
							var dependValue = proxy[dependProperty];

							self.updateProperty(dependProperty, dependValue);
						}
					}

					self.updateProperty(property, value);
				},
			});

			handlers = this.handlers[property] = [];
		}

		if (handler) {
			handler = handler.bind(proxy);
			handlers.push(handler);
		}

		return this;
	};

	this.addProperty = function(property, options) {
		var self = this;

		if (options.get) {
			this.getters[property] = options.get.bind(proxy);
		}

		if (options.set) {
			this.setters[property] = options.set.bind(proxy);
		}

		if (options.depends) {
			options.depends.forEach(function(dependProperty) {
				if (!self.dependencies[dependProperty]) {
					self.dependencies[dependProperty] = [];
				}

				self.dependencies[dependProperty].push(property);
			});
		}

		this.observe(property);
	};

	this.bindElementProperty = function(property, element, elementProperty, options) {
		var self = this;
		var elements = this.elements[property];

		/*
			options = extend({
				takeValue: false,
				transform: null,
				reverseTransform: null,
				isClassName: false,
			});
		*/

		if (!elements) {
			elements = this.elements[property] = [];
		}

		element = {
			element: element,
			property: elementProperty,
			transform: options.transform,
			reverseTransform: options.reverseTransform,
			isClassName: options.isClassName,
		};

		elements.push(element);

		var eventName = this.eventNameForFormElement(element.element);

		element.element.addEventListener(eventName, function() {
			var value = this.value;

			if (element.transform) {
				value = element.transform(value);
			}

			proxy[property] = value;
		});

		this.observe(property);

		if (options.takeValue) {
			proxy[property] = this.getElementProperty(element);
		}
		else {
			this.setElementProperty(element, proxy[property]);
		}

		return this;
	};

	this.getElementProperty = function(element) {
		var value = element.element[element.property];

		if (element.transform) {
			value = element.transform(value);
		}

		return value;
	};

	this.setElementProperty = function(element, value) {
		if (element.reverseTransform) {
			value = element.reverseTransform(value);
		}

		if (element.isClassName) {
			var classList = element.element.classList;

			if (value) {
				classList.add(element.property);
			}
			else {
				classList.remove(element.property);
			}
		}
		else {
			if (element.element[element.property] != value) {
				element.element[element.property] = value;
			}
		}
	};

	this.bindElementClass = function(property, element, elementProperty, options) {
		options.isClassName = true;

		options.reverseTransform = options.transform;
		delete options.transform;

		return this.bindElementProperty.apply(this, arguments);
	};

	this.eventNameForFormElement = function(element) {
		var eventName = 'change';

		switch (element.tagName.toLowerCase()) {
			case 'input': {
				if (!/^(submit|button|reset)$/.test(element.type)) {
					eventName = 'input';
				}
				break;
			}
			case 'textarea': {
				eventName = 'input';
				break;
			}
		}

		return eventName;
	};

	this.updateProperty = function(property, value) {
		var self = this;

		self.updateElements(property, value);
		self.notifyHandlers(property, value);
	};

	this.updateElements = function(property, value) {
		var self = this;
		var elements = this.elements[property];

		if (elements) {
			elements.forEach(function(element) {
				self.setElementProperty(element, value);
			});
		}
	};

	this.notifyHandlers = function(property, value) {
		var handlers = this.handlers[property];

		if (handlers) {
			handlers.forEach(function(handler) {
				handler(value, property);
			});
		}
	};
}

function Observer(object) {
	var self = this;
	var observer = new ValueObserver(object, this);

	[
		'observe',
		'addProperty',
		'bindElementProperty',
		'bindElementClass',
	].forEach(function(method) {
		self[method] = function() {
			observer[method].apply(observer, arguments);
		};
	});
}

window.Observer = Observer;

}());
