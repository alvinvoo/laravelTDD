import Axios from "axios";

// using an OO form like this means we can easily extend the functionality of the form
// and of course generalized it to be used everywhere
class BirdBoardForm {
    constructor(data) {
        // get the empty data structure
        // I only want to pass this relevant data during submission
        // assigning like this will still maintain the reference by tasks array
        // this.orginalData = data;

        // to get rid of the reference - i.e. get rid of the _reactivity_ observer as well
        this.originalData = JSON.parse(JSON.stringify(data));

        // assign the data to THIS object
        // so that the all data is available as this.title, this.tasks..
        // the _reactivity_ observer is also assigned
        Object.assign(this, data);

        // good to have this here, but I don't want it to be passed during form submission via _this_
        this.errors = {};
    }

    data() {
        let retData = {}

        for (let attribute in this.originalData) {
            // only assign the relevant attributes
            retData[attribute] = this[attribute];
        }

        return retData;
    }

    patch(endpoint){
        this.submit(endpoint, 'patch')
    }

    delete(endpoint){
        this.submit(endpoint, 'delete')
    }

    submit(endpoint, requestType = 'post') {
        return Axios[requestType](endpoint, this.data())
            .catch(this.onFail.bind(this))
            .then(this.onSuccess.bind(this));
    }

    onSuccess(response) {
        // do something 
        this.errors = {};

        return response;
    }

    onFail(error){
        this.errors = error.response.data.errors;

        throw error;// throw error again in case we need to handle it outside
    }

    reset(){
        Object.assign(this, this.originalData);
    }
}

export default BirdBoardForm;