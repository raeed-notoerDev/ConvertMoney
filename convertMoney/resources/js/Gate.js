import axios from 'axios';

export default class Gate {


    constructor(user) {
        this.user = user;
        // this.permissions = [];
    }

    isAllows() {
        var permission = null;
        axios.get('api/select-permission').then(response => {
            permission = response.data;
            console.log(permission);
            console.log('permission');
            return permission;
        });


    }


    isAdmin() {
        this.result = false;
        axios.get('api/select-role').then(response => {
            if (response.data.admin === true)
                this.result = true;
            console.log(this.result);
        });
        return this.result;
    }

    isClient() {
        var resultc = false;
        axios.get('api/select-role').then(response => {
            console.log(response.data.client);
            resultc = response.data.client;
        });
        return resultc;
    }
}
