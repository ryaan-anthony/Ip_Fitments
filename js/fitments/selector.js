
/**
 * Fitment class is used to control the options for each fitment type
 * @type {*}
 */

var Fitment = Class.create();
Fitment.prototype = {
    initialize: function(selector, update_url) {
        // save fitment type and update url
        this.selector = selector;
        this.update_url = update_url;
        //this.selector.options[0].selected = true;
    },
    reset: function() {
        // remove options that contain values
        this.selector.select('option').each(function(option){
            if(option.readAttribute('value') != -1){
                option.remove();
            }
        });
        this.selector.options[0].selected = true;
    },
    setOptions: function(selected) {
        var submit_button = $('vehicle-selector').select('button')[0];
        submit_button.setAttribute('disabled', 'disabled');
        this.selector.setAttribute('disabled', 'disabled');
        this.selector.innerHTML = '<option value="-1">Please wait...</option>';
        var self = this;
        new Ajax.Request(this.update_url, {
            method:'post',
            parameters: selected,
            onComplete: function(response) {
                if (200 == response.status){
                    var result = response.responseText.evalJSON() || {"0": {"id": "", "value": "Fits Any"}};
                    self.selector.options[0].remove();
                    for(var index in result) {
                        var item = result[index];
                        if(item == Array.prototype[index])continue;
                        var opt = document.createElement('option');
                        opt.text = item.value;
                        opt.value = item.id;
                        self.selector.insert(opt);
                    }
                    if(self.selector.options.length < 3){
                        if(self.selector.options.length == 1){
                            self.selector.options[self.selector.options.length - 1].innerHTML = "Fits Any";
                        }
                        self.selector.options[self.selector.options.length - 1].selected = true;
                        self.selector.simulate('change');
                    }
                }else{
                    //alert('Something went wrong...');
                }
                submit_button.removeAttribute('disabled');
                self.selector.removeAttribute('disabled');
            }
        });
    }
};

// Simulate event in prototype
// code thanks to greg http://stackoverflow.com/questions/460644/trigger-an-event-with-prototype#answer-460709
Element.prototype.simulate = function(eventName)
{
    if (document.createEvent)
    {
        var evt = document.createEvent('HTMLEvents');
        evt.initEvent(eventName, true, true);

        return this.dispatchEvent(evt);
    }

    if (this.fireEvent)
        return this.fireEvent('on' + eventName);
}